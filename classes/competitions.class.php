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


}
