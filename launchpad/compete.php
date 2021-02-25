<?php

include '../app/start.php';

// auth check
if (!isset($_SESSION['member_logged']) || empty($_SESSION['member_logged']) || !is_numeric($_SESSION['member_logged'])) {
    go (URL . '/launchpad/login.php');
}
if (!isset($_GET['c']) || !is_numeric($_GET['c'])) {
    go (URL . '/competitions.php');
}
$m = new Members($db);
$user = $m->get_one('member_id', $_SESSION['member_logged']);
if (!$user['status'] || $user['data']['member_account_status'] !== 'A') {
    unset($_SESSION['member_logged']);
    go (URL . '/launchpad/login.php');
}
$user = $user['data'];

$c = new Competitions($db);
$competition = $c->get_one_competition_by('competition_id', normal_text($_GET['c']));
if (!$competition['status']) {
    $_SESSION['message'] = ['type' => 'error', 'data' => 'Competition not found!'];
    go (URL . '/competitions.php');
} else if ($competition['data']['event_status'] !== 'A') {
    $d = "Event status seems to have problem";
    if ($competition['data']['event_status'] === 'D') {
        $d = "Event is currently disabled";
    } else if ($competition['data']['event_status'] === 'C') {
        $d = "Event is already finished";
    }
    $_SESSION['message'] = ['type' => 'error', 'data' => $d];
    go (URL . '/competitions.php');
} else if ($competition['data']['competition_status'] !== 'A') {
    $d = "Competition status seems to have problem";
    if ($competition['data']['competition_status'] === 'L') {
        $d = "Competition is currently locked";
    } else if ($competition['data']['event_status'] === 'C') {
        $d = "Competition is already finished";
    }
    $_SESSION['message'] = ['type' => 'error', 'data' => $d];
    go (URL . '/competitions.php');
}
$competition = $competition['data'];

// checking if competition time is started and time is not finished.

$start_diff = get_date_difference($competition['competition_starts'], current_date());
$end_diff = get_date_difference($competition['competition_ends'], current_date());

if ($start_diff['positive']) {
    $_SESSION['message'] = ['type' => 'error', 'data' => "Competition is not started yet. Competition will start in ".$start_diff['days'].' days '.$start_diff['hours'].' hours '.$start_diff['minutes'].' minutes '.$start_diff['seconds'].' seconds.'];
    go (URL . '/launchpad/participations.php');
}
if (!$end_diff['positive']) {
    $_SESSION['message'] = ['type' => 'error', 'data' => "Competition is already finished."];
    go (URL . '/launchpad/participations.php');
}

// checking user's particiation 
$t = new Teams($db);
$participation = $c->validate_compete($user['member_id'], $competition['competition_id'], $t);
if (!$participation['status']) {
    $_SESSION['message'] = ['type' => 'error', 'data' => "You are not allowed to access competition that you haven't participated"];
    go (URL . '/launchpad/participations.php');
}
$participation = $participation['data'];

// getting questions of the competition

$q = new Questions($db);

$questions = $q->get_all_by_competition($competition['competition_id']);
if ($questions['status']) {
    $questions = $questions['data'];
} else {
    $_SESSION['message'] = ['type' => 'error', 'data' => "Unable to find any questions in competition."];
    go (URL . '/launchpad/participations.php');
}

// getting submissions of the competition
$submissions = $q->get_submissions_of($participation['team_id'], $competition['competition_id']);
if (!$submissions['status']) {
    // first time visiting competition by participant
    $r = $q->set_blank_submissions($participation['team_id'], $questions);
    if ($r['status']) {
        $_SESSION['message'] = ['type' => 'success', 'data' => "You have started your participation."];
        go (URL . '/launchpad/compete.php?c='.$competition['competition_id']);
    } else {
        $_SESSION['message'] = ['type' => 'error', 'data' => "Unable to start the competition."];
        go (URL . '/launchpad/participations.php');
    }
}
$submissions = $submissions['data'];

// saving submission data

if (isset($_POST) && !empty($_POST)) {

    $s_id = normal_text($_POST['submission']);
    $t_id = normal_text($_POST['team']);
    $q_id = normal_text($_POST['question']);
    $code = normal_text($_POST['code']);

    $dt = current_date();
    $r = $q->update_submission(['submission_text' => $code, 'submission_updated' => $dt], $s_id);
    if ($r['status']) {
        $_SESSION['message'] = ['type' => 'success', 'data' => "Data saved successfully."];
        go (URL . '/launchpad/compete.php?c='.$competition['competition_id']);
    } else {
        $_SESSION['message'] = ['type' => 'error', 'data' => "Unable to save the data. Try again."];
        go (URL . '/launchpad/compete.php?c='.$competition['competition_id']);
    }

}

$default_code = false;
if (empty($_POST) && empty(normal_text($submissions[0]['submission_text']))) {
    $default_code = true;
}

$header = false;
$member_header = true;
$code_mirror = true;

include '../views/layout/public_header.view.php';
include '../views/launchpad/compete.view.php';
include '../views/layout/public_footer.view.php';
