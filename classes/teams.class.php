<?php

class Teams {
    private $db;
    private $logs;
    private $class_name;
    private $class_name_lower;
    private $table_name;
    
    public function __construct(PDO $db) {
        $this->logs = new Logs($db);
        $this->db = $db;
        $this->class_name = "Teams";
        $this->class_name_lower = "teams_class";
        $this->table_name = "teams";
    }

    public function add_participants ($members, $team)
    {
        $leader = 0;
        $vals = "";
        foreach ($members as $i => $member) {
            if ($member[2]) { $leader = $i; }
            if ($i > 0) { $vals .= ", "; }
            $vals .= " ('".$member[0]."', :t)";
        }
        $q = "INSERT INTO `participants` (`participant_member_id`, `participant_team_id`) VALUES $vals";
        $s = $this->db->prepare($q);
        $s->bindParam(":t", $team);
        if (!$s->execute()) {
            $failure = $this->class_name.'.add_participants - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false];
        }
        return ['status' => true, 'leader' => $leader];
    }

    public function create_team ($members, $competition, $cost, $previous_balance, $current_balance, $new_spent, $transaction_info, Members $m)
    {
        try {
            
            $this->db->beginTransaction();

            // inserting team
            $r = $this->add($competition);
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'insert_error', 'data' => 'Could not add the participation'];
            }
            $team_id = $r['team_id'];
            
            // inserting participants
            $r = $this->add_participants ($members, $team_id);
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'insert_error', 'data' => 'Could not add the participation'];
            }
            $leader = $r['leader'];

            // saving transaction
            $r = $this->add_team_transaction($members[$leader][0], $cost, $previous_balance, $current_balance, $transaction_info);
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'insert_error', 'data' => 'Could not add the participation'];
            }

            // updating main account balance
            $r = $m->update_balance($current_balance, $new_spent, $members[$leader][0]);
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'insert_error', 'data' => 'Could not add the event'];
            }

            $this->db->commit();
            return ['status' => true, 'type' => 'success', 'data' => 'Event successfully added.'];

        } catch(PDOException $e) {
            $this->db->rollBack();
            return ['status' => false, 'type' => 'transaction_error', 'data' => 'Could not complete the transaction'];
        }

    }

    public function add ($competition)
    {
        $q = "INSERT INTO `teams` (`team_competition_id`, `team_created`) VALUE (:c, :dt)";
        $s = $this->db->prepare($q);
        $s->bindParam(":c", $competition);
        $dt = current_date();
        $s->bindParam(":dt", $dt);

        if (!$s->execute()) {
            $failure = $this->class_name.'.add - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false];
        }

        return ['status' => true, 'team_id' => $this->db->lastInsertId()];
    }

    public function add_team_transaction ($member, $amount, $previous_balance, $current_balance, $info)
    {
        $cols = "(`mt_member_id`, `mt_type`, `mt_amount`, `mt_previous_balance`, `mt_current_balance`, `mt_info`, `mt_created`)";
        $vals = "(:mi, 'P', :a, :pb, :cb, :in, :dt)";
        $q = "INSERT INTO `member_transactions` $cols VALUE $vals";
        $s = $this->db->prepare($q);
        $s->bindParam(":mi", $member);
        $s->bindParam(":a", $amount);
        $s->bindParam(":pb", $previous_balance);
        $s->bindParam(":cb", $current_balance);
        $s->bindParam(":in", $info);
        $dt = current_date();
        $s->bindParam(":dt", $dt);

        if (!$s->execute()) {
            $failure = $this->class_name.'.add_team_transaction - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false];
        }

        return ['status' => true];
    }

    public function get_participants_of_team ($team_id)
    {
        $q = "SELECT * FROM `participants` JOIN `members` ON `participant_member_id` = `member_id` WHERE `participant_team_id` = :t";

        $s = $this->db->prepare($q);
        $s->bindParam(":t", $team_id);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_participants_of_team - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        
        if ($s->rowCount() > 0) {
            return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
        }
        return ['status' => false, 'type' => 'empty', 'data' => 'no participations found!'];
    }

}
