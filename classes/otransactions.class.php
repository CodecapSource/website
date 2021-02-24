<?php

class Otransactions
{
    private $db;
    private $logs;
    private $type;
    private $organiser;
    private $processor;
    private $batch;
    private $amount;
    private $previous_balance;
    private $current_balance;
    private $info;
    private $status;

    public function __construct(PDO $db) {
        $this->logs = new Logs($db);
        $this->db = $db;
        $this->class_name = "Otransactions";
        $this->class_name_lower = "otransactions_class";
        $this->table_name = "organiser_transactions";
    }

    public function set_values ($type, $organiser, $processor, $batch, $amount, $previous_balance, $current_balance, $info, $status)
    {
        $this->type = $type;
        $this->organiser = $organiser;
        $this->processor = $processor;
        $this->batch = $batch;
        $this->amount = $amount;
        $this->previous_balance = $previous_balance;
        $this->current_balance = $current_balance;
        $this->info = $info;
        $this->status = $status;
    }

    public function get_every ()
    {
        $q = "SELECT * FROM `{$this->table_name}` JOIN `organisers` ON `otransaction_or_id` = `or_id`";
        $s = $this->db->prepare($q);
        if (!$s->execute()) {
            $failure = $this->class_name.'.get_every - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
    }

    public function save ()
    {
        $r = 'otransaction';
        $cols = "`{$r}_type`, `{$r}_or_id`, `{$r}_processor`, `{$r}_batch`, `{$r}_amount`, `{$r}_previous_balance`, `{$r}_current_balance`, `{$r}_info`, `{$r}_status`, `{$r}_created`";
        $vals = ":t, :o, :p, :b, :a, :pb, :cb, :i, :s, :dt";
        $q = "INSERT INTO `".$this->table_name."` ($cols) VALUE ($vals)";

        $s = $this->db->prepare($q);
        $s->bindParam(':t', $this->type);
        $s->bindParam(':o', $this->organiser);
        $s->bindParam(':p', $this->processor);
        $s->bindParam(':b', $this->batch);
        $s->bindParam(':a', $this->amount);
        $s->bindParam(':pb', $this->previous_balance);
        $s->bindParam(':cb', $this->current_balance);
        $s->bindParam(':i', $this->info);
        $s->bindParam(':s', $this->status);
        $dt = current_date();
        $s->bindParam(':dt', $dt);
        if (!$s->execute()) {
            $failure = $this->class_name.'.save - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        return ['status' => true, 'type' => 'success', 'data' => 'data is successfully inserted.'];
    }

    public function get_current_balance ()
    {
        return $this->current_balance;
    }

}
