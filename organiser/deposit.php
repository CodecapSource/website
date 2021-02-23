<?php

include '../app/start.php';

// auth check
if (!isset($_SESSION['organiser_logged']) || empty($_SESSION['organiser_logged']) || !is_numeric($_SESSION['organiser_logged'])) {
    go (URL . '/organiser/login.php');
}
$o = new Organiser($db);
$user = $o->get_one('or_id', $_SESSION['organiser_logged']);
if (!$user['status'] || $user['data']['or_account_status'] !== 'A') {
    unset($_SESSION['organiser_logged']);
    go (URL . '/organiser/login.php');
}
$user = $user['data'];
// --- auth check end

$errors = [];

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['voucher_code']) && is_string($_POST['voucher_code']) && !empty($_POST['voucher_code'])) {
        $voucher_code = normal_text($_POST['voucher_code']);
        if (strlen($voucher_code) !== 10) {
            array_push($errors, "Voucher length is invalid");
        } else if (!ctype_alnum($voucher_code)) {
            array_push($errors, "Voucher code can only contain alphanumeric values");
        }
    } else {
        array_push($errors, "Voucher code cannot be empty");
    }

    if (empty($errors)) {

        $v = new Vouchers($db);
        $voucher = $v->get_one_by('voucher_code', $voucher_code);
        if ($voucher['status']) {
            $voucher = $voucher['data'];
            if ($voucher['voucher_redeemed'] === 'Y') {
                array_push($errors, "Voucher has been already redeemed");
            } else {

                // do a transaction
                $t = new Otransactions($db);
                $info = 'Voucher "'.$voucher['voucher_code'].'" redeemed worth '.$voucher['voucher_worth'].'codn';
                $t->set_values('D', $user['or_id'], 'V', '', $voucher['voucher_worth'], $user['or_balance'], $user['or_balance'] + $voucher['voucher_worth'], $info, 'C');

                $result = $v->redeem_voucher($user['or_id'], $voucher, $t, $o);

                if ($result['status']) {
                    $_SESSION['message'] = ['type' => 'success', 'data' => 'Transaction has been saved. Your account has been deposited with <b>'.$voucher['voucher_worth'].'codn</b>'];
                    go(URL . '/organiser/deposit.php');
                } else {
                    array_push($errors, $result['data']);
                }

            }

        } else {
            array_push($errors, "No voucher found");
        }

    }

}

include '../views/layout/header.view.php';
include '../views/organiser/deposit.view.php';
include '../views/layout/footer.view.php';
