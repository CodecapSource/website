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


$t = new Otransactions($db);

$transactions = $t->get_every();

$page_title = "Transactions";

if ($transactions['status']) {
    $transactions = $transactions['data'];

    // checking page
    $filter = false;
    if (isset($_GET['d'])) {
        $page_title = "Deposit Transactions";
        $filter = "D";
    } else if (isset($_GET['w'])) {
        $page_title = "Withdraw Transactions";
        $filter = "W";
    } else if (isset($_GET['e'])) {
        $page_title = "Event Transactions";
        $filter = "E";
    }

    if ($filter) {
        $tmp = $transactions;
        $transactions = [];
        foreach ($tmp as $t) {
            if ($t['otransaction_type'] === $filter) {
                array_push($transactions, $t);
            }
        }
    }

} else {
    $transactions = [];
}

include '../views/layout/header.view.php';
include '../views/organiser/transactions.view.php';
include '../views/layout/footer.view.php';
