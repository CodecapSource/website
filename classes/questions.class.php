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

    public function get_submissions_of ($team, $competition)
    {
        $q = "SELECT * FROM `submissions` JOIN `questions` ON `submission_question_id` = `question_id` WHERE `submission_team_id` = :t AND `question_competition_id` = :c";
        
        $s = $this->db->prepare($q);
        $s->bindParam(":c", $competition);
        $s->bindParam(":t", $team);
        if (!$s->execute()) {
            $failure = $this->class_name.'.get_submissions_of - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Submissions not found.'];
        }

        return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
    }

    public function set_blank_submissions ($team, $questions)
    {
        $vals = "";
        foreach ($questions as $i => $question) {
            if ($i > 0) {
                $vals .= ", ";
            }
            $vals .= "('".$question['question_id']."', :t, :dt)";
        }

        $q = "INSERT INTO `submissions` (`submission_question_id`, `submission_team_id`, `submission_created`) VALUES $vals";

        $s = $this->db->prepare($q);
        $s->bindParam(":t", $team);
        $dt = current_date();
        $s->bindParam(":dt", $dt);

        if (!$s->execute()) {
            $failure = $this->class_name.'.set_blank_submission - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        return ['status' => true, 'type' => 'success', 'data' => 'Data is successfully inserted.'];
    }

}
