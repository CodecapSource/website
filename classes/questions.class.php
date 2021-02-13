<?php

class Questions
{
    
    private $db;
    private $logs;
    private $class_name;
    private $class_name_lower;
    private $table_name;
    
    public function __construct(PDO $db) {
        $this->logs = new Logs($db);
        $this->db = $db;
        $this->class_name = "Questions";
        $this->class_name_lower = "questions_class";
        $this->table_name = "questions";
    }

    public function get_all_by_competition ($competition_id)
    {
        $q = "SELECT * FROM `".$this->table_name."` WHERE `question_competition_id` = :i";
        
        $s = $this->db->prepare($q);
        $s->bindParam(":i", $competition_id);
        
        if (!$s->execute()) {
            $failure = $this->class_name.'.get_all_by_competition - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Questions not found.'];
        }

        return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
    }

    public function insert ($competition, $title, $body, $points)
    {
        $r = 'question_';
        $q = "INSERT INTO `".$this->table_name."` (`{$r}competition_id`, `{$r}title`, `{$r}body`, `{$r}points`, `{$r}created`) VALUE (:ci, :t, :b, :p, :dt)";
        
        $s = $this->db->prepare($q);
        $s->bindParam(":ci", $competition);
        $s->bindParam(":t", $title);
        $s->bindParam(":b", $body);
        $s->bindParam(":p", $points);
        $dt = current_date();
        $s->bindParam(":dt", $dt);

        if (!$s->execute()) {
            $failure = $this->class_name.'.insert - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        return ['status' => true, 'type' => 'success', 'data' => 'Data is successfully inserted.'];
    }
}
