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

$transactions = $m->get_member_transactions ($user['member_id']);

if ($transactions['status']) {
    $transactions = $transactions['data'];
} else {
    $transactions = [];
}

$header = false;
$member_header = true;

include '../views/layout/public_header.view.php';
include '../views/launchpad/transactions.view.php';
include '../views/layout/public_footer.view.php';
