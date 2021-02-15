<?php

include 'app/start.php';

$c = new Competitions($db);
$competitions = $c->get_all_competitions_details();

if (!$competitions['status']) {
    $competitions = [];
} else {
    $competitions = $competitions['data'];
}

$_no_of_competitions = count($competitions);

if (isset($_SESSION['member_logged'])) {
    $m = new Members($db);
    $user = $m->get_one('member_id', $_SESSION['member_logged']);
    if (!$user['status'] || $user['data']['member_account_status'] !== 'A') {
        unset($_SESSION['member_logged']);
        go (URL . '/launchpad/login.php');
    }
    $user = $user['data'];
    
    $header = false;
    $member_header = true;
}
include 'views/layout/public_header.view.php';
include 'views/competitions.view.php';
include 'views/layout/public_footer.view.php';
