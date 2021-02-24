<?php

include '../app/start.php';

// auth check
if (!isset($_SESSION['member_logged']) || empty($_SESSION['member_logged']) || !is_numeric($_SESSION['member_logged'])) {
    go (URL . '/launchpad/login.php');
}
$m = new Members($db);
$user = $m->get_one('member_id', $_SESSION['member_logged']);
if (!$user['status'] || $user['data']['member_account_status'] !== 'A') {
    unset($_SESSION['member_logged']);
    go (URL . '/launchpad/login.php');
}
$user = $user['data'];

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
                $info = 'Voucher "'.$voucher['voucher_code'].'" redeemed worth '.$voucher['voucher_worth'].'codn';

                $t = new Teams($db);

                $result = $v->redeem_member_voucher($user, $voucher, $m, $t, $voucher['voucher_worth'], $user['member_balance'], $user['member_balance'] + $voucher['voucher_worth'], $info);

                if ($result['status']) {
                    $_SESSION['message'] = ['type' => 'success', 'data' => 'Transaction has been saved. Your account has been deposited with <b>'.$voucher['voucher_worth'].'codn</b>'];
                    go(URL . '/launchpad/deposit.php');
                } else {
                    array_push($errors, $result['data']);
                }

            }

        } else {
            array_push($errors, "No voucher found");
        }

    }

}

$header = false;
$member_header = true;

include '../views/layout/public_header.view.php';
include '../views/launchpad/deposit.view.php';
include '../views/layout/public_footer.view.php';
