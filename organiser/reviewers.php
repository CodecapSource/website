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

// getting reviewers

$reviewers = $c->get_reviewers_of_competition ($competition['competition_id']);

if ($reviewers['status']) {
    $reviewers = $reviewers['data'];
} else {
    $reviewers = [];
}

$errors = [];

if (isset($_GET['d'])) {

    if (!empty($_GET['d']) && is_numeric($_GET['d'])) {

        $d = normal_text($_GET['d']);
        $found = false;
        foreach ($reviewers as $reviewer) {
            if ($reviewer['reviewer_id'] === $d) {
                $found = $reviewer['reviewer_id'];
                break;
            }
        }

        if ($found) {

            $result = $c->delete_reviewer($found);

            if ($result['status']) {
                $_SESSION['message'] = ['type' => 'success', 'data' => 'Reviewer has been deleted.'];
                go (URL . '/organiser/reviewers.php?c='.$competition['competition_id']);
            }
    
            $_SESSION['message'] = ['type' => 'error', 'data' => $result['data']];
            go (URL . '/organiser/reviewers.php?c='.$competition['competition_id']);

        } else {
            $_SESSION['message'] = ['type' => 'error', 'data' => 'No reviewer found with that ID.'];
            go (URL . '/organiser/reviewers.php?c='.$competition['competition_id']);
        }

    } else {
        $_SESSION['message'] = ['type' => 'error', 'data' => 'Invalid delete parameter defined.'];
        go (URL . '/organiser/reviewers.php?c='.$competition['competition_id']);
    }

}

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['email']) && is_string($_POST['email']) && !empty(normal_text($_POST['email']))) {

        $email = normal_text($_POST['email']);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email format is incorrect.");
        } else {

            $r = $c->get_reviewer_by_in_competition ('reviewer_email', $email, $competition['competition_id']);
            if ($r['status']) {
                array_push($errors, "Reviewer already exists.");
            }
            
        }

    } else {
        array_push($errors, "Email cannot be empty");
    }

    if (empty($errors)) {
        
        $result = $c->insert_reviewer($email, $competition['competition_id']);
        
        if ($result['status']) {
            $_SESSION['message'] = ['type' => 'success', 'data' => 'Reviewer has been added. Email will be sent to reviewer once competition finishes.'];
            go (URL . '/organiser/reviewers.php?c='.$competition['competition_id']);
        }

        array_push($errors, $result['data']);

    }

}

include '../views/layout/header.view.php';
include '../views/organiser/reviewers.view.php';
include '../views/layout/footer.view.php';
