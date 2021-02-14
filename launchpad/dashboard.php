<?php

include '../app/start.php';

// auth check
if (!isset($_SESSION['member_logged']) || empty($_SESSION['member_logged']) || !is_numeric($_SESSION['member_logged'])) {
    go (URL . '/launchpad/login.php');
}
$o = new Members($db);
$user = $o->get_one('member_id', $_SESSION['member_logged']);
if (!$user['status'] || $user['data']['member_account_status'] !== 'A') {
    unset($_SESSION['member_logged']);
    go (URL . '/launchpad/login.php');
}
$user = $user['data'];

var_dump($user);

?>

<a href="<?=URL?>/competitions.php">Competitions</a>
<a href="<?=URL?>/launchpad/participations.php">Participations</a>
<a href="<?=URL?>/launchpad/transactions.php">Transactions</a>
