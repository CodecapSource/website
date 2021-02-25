<?php

class Members
{
    private $db;
    private $logs;
    private $class_name;
    private $class_name_lower;
    private $table_name;
    
    public function __construct(PDO $db) {
        $this->logs = new Logs($db);
        $this->db = $db;
        $this->class_name = "Members";
        $this->class_name_lower = "members_class";
        $this->table_name = "members";
    }

    public function get_one($column, $value, $compare = "=") {
        $q = "SELECT * FROM `".$this->table_name."` WHERE `$column` $compare :$column";
        $s = $this->db->prepare($q);
        $s->bindParam(":$column", $value);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_one - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        
        if ($s->rowCount() > 0) {
            return ['status' => true, 'type' => 'success', 'data' => $s->fetch()];
        }
        return ['status' => false, 'type' => 'empty', 'data' => 'no member not found!'];
    }

    public function insert ($name, $email, $password, $country_iso, $contact, $ip)
    {
        $cols = "`member_name`, `member_email`, `member_password`, `member_country_iso`, `member_contact`, `member_reg_ip`, `member_created`";
        $q = "INSERT INTO `".$this->table_name."` ($cols) VALUE (:n, :e, :p, :co, :c, :i, :dt)";
        
        $s = $this->db->prepare($q);
        $s->bindParam(":n", $name);
        $s->bindParam(":e", $email);
        $s->bindParam(":p", $password);
        $s->bindParam(":co", $country_iso);
        $s->bindParam(":c", $contact);
        $s->bindParam(":i", $ip);
        $dt = current_date();
        $s->bindParam(":dt", $dt);

        if (!$s->execute()) {
            $failure = $this->class_name.'.insert - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        
        return ['status' => true, 'type' => 'success', 'data' => 'member successfully inserted'];
    }

    public function update_balance ($balance, $spent, $member_id)
    {
        $q = "UPDATE `".$this->table_name."` SET `member_balance` = :b, `member_spent` = :s WHERE `member_id` = :m";
        $s = $this->db->prepare($q);
        $s->bindParam(":b", $balance);
        $s->bindParam(":s", $spent);
        $s->bindParam(":m", $member_id);
        if (!$s->execute()) {
            $failure = $this->class_name.'.update_balance - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        return ['status' => true, 'type' => 'success', 'data' => 'balance is successfully updated.'];
    }

    public function get_all_participations_of ($member_id, $status)
    {
        $q = "SELECT * FROM `participants` JOIN `teams` ON `participant_team_id` = `team_id` JOIN `competitions` ON `team_competition_id` = `competition_id` WHERE `participant_member_id` = :m AND `team_status` = :s";
        $s = $this->db->prepare($q);
        $s->bindParam(":m", $member_id);
        $s->bindParam(":s", $status);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_all_participations_of - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        
        if ($s->rowCount() > 0) {
            return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
        }
        return ['status' => false, 'type' => 'empty', 'data' => 'no participations found!'];

    }

    public function get_member_transactions ($member_id)
    {
        $q = "SELECT * FROM `member_transactions` WHERE `mt_member_id` = :m";

        $s = $this->db->prepare($q);
        $s->bindParam(":m", $member_id);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_member_transactions - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if ($s->rowCount() > 0) {
            return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
        }
        return ['status' => false, 'type' => 'empty', 'data' => 'no transactions found!'];
    }
    

}
