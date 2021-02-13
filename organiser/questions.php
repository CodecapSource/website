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

// getting competition questions
$c = new Questions($db);
$questions = $c->get_all_by_competition($competition['competition_id']);
if (!$questions['status']) {
    $questions = [];
} else {
    $questions = $questions['data'];
}

$errors = [];

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['title']) && is_string($_POST['title']) && !empty(normal_text($_POST['title']))) {
        $title = normal_text($_POST['title']);
    } else {
        array_push($errors, 'Question title cannot be empty');
    }

    if (isset($_POST['body']) && is_string($_POST['body']) && !empty(normal_text($_POST['body']))) {
        $body = normal_text($_POST['body']);
    } else {
        array_push($errors, 'Question body cannot be empty');
    }

    if (isset($_POST['points']) && is_numeric($_POST['points']) && !empty(normal_text($_POST['points']))) {
        $points = normal_text($_POST['points']);

        if ($points < 1) {
            array_push($errors, 'Points cannot be less than 1');
        }
    } else {
        array_push($errors, 'Points cannot be empty');
    }

    if (empty($errors)) {

        $result = $c->insert($competition['competition_id'], $title, $body, $points);
        
        if ($result['status']) {
            go(URL . '/organiser/questions.php?c='.$competition['competition_id']);
        }
        array_push($errors, $result['data']);

    }

}


include '../views/layout/header.view.php';
include '../views/organiser/questions.view.php';
include '../views/layout/footer.view.php';
