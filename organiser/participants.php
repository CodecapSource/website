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

if (!isset($_GET['c']) || !is_numeric($_GET['c'])) {
    go (URL . '/organiser/events.php');
}

$c = new Competitions($db);
$competition = $c->get_one_competition_by('competition_id', normal_text($_GET['c']));
if (!$competition['status']) {
    $_SESSION['message'] = ['type' => 'error', 'data' => 'Competition not found!'];
    go (URL . '/organiser/events.php');
} else if ($competition['data']['event_or_id'] !== $user['or_id']) {
    $_SESSION['message'] = ['type' => 'error', 'data' => "You don't have access to that event."];
    go (URL . '/organiser/events.php');
}
$competition = $competition['data'];

$p = new Participants($db);
$participants = $p->get_participants_by('team_competition_id', $competition['competition_id']);
if (!$participants['status']) {
    $participants = [];
} else {
    $participants = $participants['data'];
}

// sorting participants team vise
$teams = [];
foreach ($participants as $p) {
    if (!array_key_exists($p['team_id'], $teams)) {
        $teams[$p['team_id']] = [];
    }
    $teams[$p['team_id']][] = $p;
}

include '../views/layout/header.view.php';
include '../views/organiser/participants.view.php';
include '../views/layout/footer.view.php';
