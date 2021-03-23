<?php

class Participants
{
    private $db;
    private $logs;
    private $class_name;
    private $class_name_lower;
    private $table_name;
    
    public function __construct(PDO $db) {
        $this->logs = new Logs($db);
        $this->db = $db;
        $this->class_name = "Participants";
        $this->class_name_lower = "participants_class";
        $this->table_name = "participants";
    }

    public function get_participants_by ($col, $val)
    {
        $q = "SELECT * FROM `participants` JOIN `teams` ON `participant_team_id` = `team_id` JOIN `members` ON `participant_member_id` = `member_id` WHERE `$col` = :v";

        $s = $this->db->prepare($q);
        $s->bindParam(":v", $val);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_participants_by - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        
        if ($s->rowCount() > 0) {
            return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
        }
        return ['status' => false, 'type' => 'empty', 'data' => 'no participants not found!'];
    }

    public function get_submissions ($competition)
    {
        $q = "SELECT * FROM `submissions` JOIN `teams` ON `submission_team_id` = `team_id` JOIN `questions` ON `submission_question_id` = `question_id` WHERE `question_competition_id` = :c";
        $s = $this->db->prepare($q);
        $s->bindParam(":c", $competition);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_submissions - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        
        if ($s->rowCount() > 0) {
            return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
        }
        return ['status' => false, 'type' => 'empty', 'data' => 'no submissions not found!'];
    }


}
