<?php

class Events
{
    
    private $db;
    private $logs;
    private $class_name;
    private $class_name_lower;
    private $table_name;
    
    public function __construct(PDO $db) {
        $this->logs = new Logs($db);
        $this->db = $db;
        $this->class_name = "Events";
        $this->class_name_lower = "events_class";
        $this->table_name = "events";
    }

    public function get_all_by_organiser ($organiser)
    {
        $q = "SELECT * FROM `".$this->table_name."` JOIN `countries` ON `event_country_iso` = `country_iso` WHERE `event_or_id` = :o";
        $s = $this->db->prepare($q);
        $s->bindParam(":o", $organiser);
        if (!$s->execute()) {
            $failure = $this->class_name.'.get_all_by_organiser - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        if ($s->rowCount() > 0) {
            return ['status' => true, 'type' => 'success', 'data' => $s->fetchAll()];
        }
        return ['status' => false, 'type' => 'empty', 'data' => 'no countries not found!'];
    }

    public function insert ($name, $organiser, $organiser_name, $organiser_about, $about, $happen, $ends, $location_type, $country, $address) {
        $cols = "`event_or_id`, `event_name`, `event_organiser_name`, `event_organiser_about`, `event_about`, `event_happen_on`, `event_ends_on`, `event_location_type`, `event_country_iso`, `event_address`, `event_created`";
        $vals = ":oi, :n, :on, :oa, :a, :h, :e, :lt, :c, :ad, :dt";
        $q = "INSERT INTO `".$this->table_name."` ($cols) VALUE ($vals)";

        $s = $this->db->prepare($q);
        $s->bindParam(':n', $name);
        $s->bindParam(':oi', $organiser);
        $s->bindParam(':on', $organiser_name);
        $s->bindParam(':oa', $organiser_about);
        $s->bindParam(':a', $about);
        $s->bindParam(':h', $happen);
        $s->bindParam(':e', $ends);
        $s->bindParam(':lt', $location_type);
        $s->bindParam(':c', $country);
        $s->bindParam(':ad', $address);
        $dt = current_date();
        $s->bindParam(':dt', $dt);

        if (!$s->execute()) {
            $failure = $this->class_name.'.insert - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        return ['status' => true, 'type' => 'success', 'data' => 'data is successfully inserted.'];
    }

    public function create ($name, $organiser, $organiser_name, $organiser_about, $about, $happen, $ends, $location_type, $country, $address, Otransactions $t, Organiser $o)
    {
        try {
            
            $this->db->beginTransaction();

            // inserting event
            $r = $this->insert ($name, $organiser, $organiser_name, $organiser_about, $about, $happen, $ends, $location_type, $country, $address);
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'insert_error', 'data' => 'Could not add the event'];
            }
            $event_id = $this->db->lastInsertId();

            // saving transaction
            $r = $t->save();
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'insert_error', 'data' => 'Could not add the event'];
            }

            // updating main account balance
            $r = $o->update_balance($t->get_current_balance(), $organiser);
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'insert_error', 'data' => 'Could not add the event'];
            }

            $this->db->commit();
            return ['status' => true, 'type' => 'success', 'data' => 'Event successfully added.', 'event_id' => $event_id];

        } catch(PDOException $e) {
            $this->db->rollBack();
            return ['status' => false, 'type' => 'transaction_error', 'data' => 'Could not complete the transaction'];
        }

    }
    
}

