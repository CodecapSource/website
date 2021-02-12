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


$e = new Events($db);

$events = $e->get_all_by_organiser($user['or_id']);
if ($events['status']) {
    $events = $events['data'];
} else {
    $events = [];
}

include '../views/layout/header.view.php';
include '../views/organiser/events.view.php';
include '../views/layout/footer.view.php';
