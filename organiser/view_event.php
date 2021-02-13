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

if (!isset($_GET['e']) || !is_numeric($_GET['e'])) {
    go (URL . '/organiser/events.php');
}

// getting event data
$e = new Events($db);
$event = $e->get_one_details_by_id(normal_text($_GET['e']));
if (!$event['status']) {
    $_SESSION['message'] = ['type' => 'error', 'data' => 'Event not found!'];
    go (URL . '/organiser/events.php');
} else if ($event['data']['event_or_id'] !== $user['or_id']) {
    $_SESSION['message'] = ['type' => 'error', 'data' => "You don't have access to that event."];
    go (URL . '/organiser/events.php');
}
$event = $event['data'];

// getting event competitions
$c = new Competitions($db);
$competitions = $c->get_all_event_competitions($event['event_id']);
if (!$competitions['status']) {
    $competitions = [];
}
$competitions = $competitions['data'];


include '../views/layout/header.view.php';
include '../views/organiser/view_event.view.php';
include '../views/layout/footer.view.php';
