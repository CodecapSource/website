<?php

class Vouchers {
    private $db;
    private $logs;
    private $class_name;
    private $class_name_lower;
    private $table_name;
    
    public function __construct(PDO $db) {
        $this->logs = new Logs($db);
        $this->db = $db;
        $this->class_name = "Vouchers";
        $this->class_name_lower = "vouchers_class";
        $this->table_name = "vouchers";
    }

    public function get_one_by ($col, $val)
    {
        $q = "SELECT * FROM `".$this->table_name."` WHERE `$col` = :v";

        $s = $this->db->prepare($q);
        $s->bindParam(":v", $val);

        if (!$s->execute()) {
            $failure = $this->class_name.'.get_one_by - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        if (!$s->rowCount()) {
            return ['status' => false, 'type' => 'empty', 'data' => 'Voucher not found.'];
        }
        
        return ['status' => true, 'type' => 'success', 'data' => $s->fetch()];
    }

    /*
        $amount - is codn credits
    */
    public function generate_voucher ($amount)
    {
        $it = 0;
        while($it < 15) {
            $random_str = generate_random_string(10);
            $check = $this->get_one_by('voucher_code', $random_str);
            if (!$check['status']) {
                $result = $this->insert($random_str, $amount);
                $result['voucher'] = $random_str;
                return $result;
            }
            $it += 1;
        }
        return ['status' => false, 'type' => 'error', 'data' => 'Unable to generate.'];
    }

    public function insert ($code, $amount)
    {
        $q = "INSERT INTO `{$this->table_name}` (`voucher_code`, `voucher_worth`, `voucher_created`) VALUE (:c, :w, :dt)";
        $s = $this->db->prepare($q);
        $s->bindParam(":c", $code);
        $s->bindParam(":w", $amount);
        $dt = current_date();
        $s->bindParam(":dt", $dt);
        if (!$s->execute()) {
            $failure = $this->class_name.'.insert - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }
        return ['status' => true, 'type' => 'success', 'data' => 'Voucher generated successfully.'];
    }

    public function redeem_voucher ($organiser, $voucher, Otransactions $t, Organiser $o)
    {
        try {
            $this->db->beginTransaction();

            // update balance of organiser
            $r = $o->update_balance($t->get_current_balance(), $organiser);
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'transaction_error', 'data' => 'Transaction step 1 failure'];
            }

            // saving transaction
            $r = $t->save();
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'transaction_error', 'data' => 'Transaction step 2 failure'];
            }
            
            $r = $this->update(['voucher_redeemed' => 'Y'], $voucher['voucher_id']);
            if (!$r['status']) {
                $this->db->rollBack();
                return ['status' => false, 'type' => 'transaction_error', 'data' => 'Transaction step 3 failure'];
            }

            $this->db->commit();
            return ['status' => true, 'type' => 'success', 'data' => 'Transaction successfully added.'];


        } catch(PDOException $e) {
            $this->db->rollBack();
            return ['status' => false, 'type' => 'transaction_error', 'data' => 'Could not complete the transaction'];
        }
    }

    public function update ($data, $voucher_id)
    {
        $vals = "";
        foreach ($data as $c => $v) {
            if (!empty($vals)) {
                $vals .= ", ";
            }
            $vals .= "`$c` = '$v'";
        }

        $q = "UPDATE `{$this->table_name}` SET $vals WHERE `voucher_id` = :v";
        $s = $this->db->prepare($q);
        $s->bindParam(":v", $voucher_id);

        if (!$s->execute()) {
            $failure = $this->class_name.'.update - E.02: Failure';
            $this->logs->create($this->class_name_lower, $failure, json_encode($s->errorInfo()));
            return ['status' => false, 'type' => 'query', 'data' => $failure];
        }

        return ['status' => true, 'type' => 'success', 'data' => 'Updated.'];
    }

}
