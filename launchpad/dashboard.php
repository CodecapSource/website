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

$t = new Teams($db);

$active_participations = $m->get_all_participations_of($user['member_id'], 'A');
if (!$active_participations['status']) {
    $active_participations = [];
} else {
    $active_participations = $active_participations['data'];

    foreach ($active_participations as $i => $participation) {
        $r = $t->get_participants_of_team($participation['team_id']);
        if ($r['status']) {
            $r = $r['data'];
        } else {
            $r = [];
        }
        $participation['members'] = $r;
        $active_participations[$i] = $participation;
    }
}


$header = false;
$member_header = true;

include '../views/layout/public_header.view.php';
include '../views/launchpad/dashboard.view.php';
include '../views/layout/public_footer.view.php';
