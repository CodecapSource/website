<?php

class Competitions
{
    
    private $db;
    private $logs;
    private $class_name;
    private $class_name_lower;
    private $table_name;
    
    public function __construct(PDO $db) {
        $this->logs = new Logs($db);
        $this->db = $db;
        $this->class_name = "Competitions";
        $this->class_name_lower = "competitions_class";
        $this->table_name = "competitions";
    }

    public function create ($event, $name, $min, $max, $cost, $cost_type, $starts, $ends, $about, $rules)
    {
        $r = "competition";
        $cols = "`{$r}_event_id`, `{$r}_name`, `{$r}_member_min`, `{$r}_member_max`, `{$r}_cost`, `{$r}_cost_type`, `{$r}_starts`, `{$r}_ends`, `{$r}_about`, `{$r}_rules`, `{$r}_created`";
        $vals = ":ei, :n, :mi, :mx, :c, :ct, :s, :e, :ab, :ru, :dt";
        $q = "INSERT INTO `".$this->table_name."` ($cols) VALUE ($vals)";
        
        $s = $this->db->prepare($q);
        $s->bindParam(':ei', $event);
        $s->bindParam(':n', $name);
        $s->bindParam(':mi', $min);
        $s->bindParam(':mx', $max);
        $s->bindParam(':c', $cost);
        $s->bindParam(':ct', $cost_type);
        $s->bindParam(':s', $starts);
        $s->bindParam(':e', $ends);
        $s->bindParam(':ab', $about);
        $s->bindParam(':ru', $rules);
        $dt = current_date();
        $s->bindParam(':dt', $dt);

        if (!$s->execute()) {
            $failure = $this->class_name.'.create - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        return ['status' => true, 'type' => 'success', 'data' => 'data is successfully inserted.'];
    }


    public function get_all_competitions ()
    {
        $q = "SELECT * FROM `".$this->table_name."` JOIN `events` ON `competition_event_id` = `event_id`";
        
        $s = $this->db->prepare($q);
        
        if (!$s->execute()) {
            $failure = $this->class_name.'.get_all_competitions - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Competitions not found.'];
        }

        return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
    }

    
    public function get_all_competitions_details ()
    {
        $q = "SELECT * FROM `".$this->table_name."` JOIN `events` ON `competition_event_id` = `event_id` JOIN `countries` ON `event_country_iso` = `country_iso`";
        
        $s = $this->db->prepare($q);
        
        if (!$s->execute()) {
            $failure = $this->class_name.'.get_all_competitions_details - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Competitions not found.'];
        }

        return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
    }

    public function get_all_event_competitions ($event_id)
    {
        $q = "SELECT * FROM `".$this->table_name."` JOIN `events` ON `competition_event_id` = `event_id` WHERE `competition_event_id` = :i";
        
        $s = $this->db->prepare($q);
        $s->bindParam(":i", $event_id);
        
        if (!$s->execute()) {
            $failure = $this->class_name.'.get_all_event_competitions - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Competitions not found.'];
        }

        return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
    }

    public function get_one_competition_by ($col, $val)
    {
        $q = "SELECT * FROM `".$this->table_name."` JOIN `events` ON `competition_event_id` = `event_id` WHERE `$col` = :v";

        $s = $this->db->prepare($q);
        $s->bindParam(":v", $val);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_one_competition_by - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Competition not found.'];
        }
        
        return ['status' => true, 'type' => 'success', 'data' => $s->fetch()];
    }

    public function get_reviewers_of_competition ($competition_id)
    {
        $q = "SELECT * FROM `reviewers` JOIN `".$this->table_name."` ON `reviewer_competition_id` = `competition_id` WHERE `reviewer_competition_id` = :r";
        
        $s = $this->db->prepare($q);
        $s->bindParam(":r", $competition_id);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_reviewers_of_competition - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Reviewers not found.'];
        }

        return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
    }

    public function get_reviewer_by_in_competition ($col, $val, $competition_id)
    {
        $q = "SELECT * FROM `reviewers` JOIN `".$this->table_name."` ON `reviewer_competition_id` = `competition_id` WHERE `$col` = :v AND `reviewer_competition_id` = :r";
        
        $s = $this->db->prepare($q);
        $s->bindParam(":v", $val);
        $s->bindParam(":r", $competition_id);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_reviewer_by_in_competition - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Reviewer not found.'];
        }

        return ['status' => true, 'type' => 'success', 'data' => $s->fetch()];
    }

    public function insert_reviewer ($email, $competition_id)
    {
        $q = "INSERT INTO `reviewers` (`reviewer_email`, `reviewer_competition_id`, `reviewer_created`) VALUE (:e, :c, :dt)";
        
        $s = $this->db->prepare($q);
        $s->bindParam(":e", $email);
        $s->bindParam(":c", $competition_id);
        $dt = current_date();
        $s->bindParam(":dt", $dt);

        if (!$s->execute()) {
            $failure = $this->class_name.'.insert_reviewer - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        return ['status' => true, 'type' => 'success', 'data' => 'Reviewer successfully inserted'];
    }

    public function delete_reviewer ($reviewer_id)
    {
        $q = "DELETE FROM `reviewers` WHERE `reviewer_id` = :i";
        
        $s = $this->db->prepare($q);
        $s->bindParam(":i", $reviewer_id);
        
        if (!$s->execute()) {
            $failure = $this->class_name.'.delete_reviewer - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        return ['status' => true, 'type' => 'success', 'data' => 'Reviewer successfully deleted'];
    }

    public function validate_compete ($member, $competition, Teams $t)
    {
        $q = "SELECT * FROM `participants` JOIN `members` ON `participant_member_id` = `member_id` JOIN `teams` ON `participant_team_id` = `team_id` WHERE `member_id` = :mi AND `team_competition_id` = :ci";

        $s = $this->db->prepare($q);
        $s->bindParam(":mi", $member);
        $s->bindParam(":ci", $competition);
        
        if (!$s->execute()) {
            $failure = $this->class_name.'.validate_compete - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Participation not found.'];
        }

        $p = $s->fetch();

        $members = $t->get_participants_of_team($p['team_id']);
        if ($members['status']) {
            $p['members'] = $members['data'];
        } else {
            $p['members'] = [];
        }

        return ['status' => true, 'type' => 'success', 'data' => $p];
    }
    


}
