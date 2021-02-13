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

$errors = [];

if (isset($_POST) && !empty($_POST)) {
    var_dump($_POST);

    if (isset($_POST['name']) && is_string($_POST['name']) && !empty(normal_text($_POST['name']))) {
        $name = normal_text($_POST['name']);
    } else {
        array_push($errors, 'Competition name cannot be empty');
    }

    if (isset($_POST['team_min']) && is_numeric($_POST['team_min']) && !empty(normal_text($_POST['team_min']))) {
        $team_min = normal_text($_POST['team_min']);
        
        if ($team_min < 1) {
            array_push($errors, 'Team min. cannot be less than 1');
        }
    } else {
        array_push($errors, 'Team min. cannot be empty');
    }

    if (isset($_POST['team_max']) && is_numeric($_POST['team_max']) && !empty(normal_text($_POST['team_max']))) {
        $team_max = normal_text($_POST['team_max']);

        if (isset($team_min)) {
            if ($team_max < $team_min) {
                array_push($errors, 'Team max. cannot be less than Team min.');
            }
        }
    } else {
        array_push($errors, 'Team max. cannot be empty');
    }

    if (isset($_POST['cost']) && is_numeric($_POST['cost']) && !empty(normal_text($_POST['cost']))) {
        $cost = normal_text($_POST['cost']);

        if ($cost < 1) {
            array_push($errors, 'Participation cost cannot be less than 1');
        }
    } else {
        array_push($errors, 'Participation cost cannot be empty');
    }

    if (isset($_POST['cost_type']) && is_string($_POST['cost_type']) && !empty(normal_text($_POST['cost_type']))) {
        $cost_type = normal_text($_POST['cost_type']);
    } else {
        array_push($errors, 'Cost type cannot be empty');
    }

    if (isset($_POST['starts_on']) && !empty(normal_text($_POST['starts_on']))) {
        $starts_on = normal_date(normal_text($_POST['starts_on']));
        $d_diff = get_date_difference($starts_on, current_date());
        if (!$d_diff["positive"]) {
            array_push($errors, 'Starts on cannot be passed date');
        } else {
            $l_diff = get_date_difference($starts_on, $event['event_happen_on']);
            $u_diff = get_date_difference($starts_on, $event['event_ends_on']);
            if (!$l_diff["positive"] || $u_diff["positive"]) {
                array_push($errors, 'Starts on should be within event time.');
            }
        }
    } else {
        array_push($errors, 'Starts on cannot be empty');
    }

    if (isset($_POST['ends_on']) && is_string($_POST['ends_on']) && !empty(normal_text($_POST['ends_on']))) {
        $ends_on = normal_date(normal_text($_POST['ends_on']));

        $l_diff = get_date_difference($ends_on, $event['event_happen_on']);
        $u_diff = get_date_difference($ends_on, $event['event_ends_on']);
        if (!$l_diff["positive"] || $u_diff["positive"]) {
            array_push($errors, 'Ends on should be within event time.');
        }

    } else {
        array_push($errors, 'Ends on cannot be empty');
    }

    if (isset($_POST['about']) && !empty(normal_text($_POST['about']))) {
        $about = normal_text($_POST['about']);
    } else {
        $about = "";
    }

    if (isset($_POST['rules']) && !empty(normal_text($_POST['rules']))) {
        $rules = normal_text($_POST['rules']);
    } else {
        $rules = "";
    }

    if (empty($errors)) {

        // check if start and end dates are correctly delayed.
        $d_diff = get_date_difference($ends_on, $starts_on);
        if (!$d_diff["positive"]) {
            array_push($errors, 'Ends on cannot be less than or equal to start time');
        } else {
            $count_hours = ($d_diff['years'] * 8760) + ($d_diff['months'] * 730.001) + ($d_diff['days'] * 24) + $d_diff['hours'];
            if ($d_diff['minutes'] > 0) {
                $count_hours = $count_hours + ($d_diff['minutes'] / 60);
            }
            if ($count_hours < 0.5) {
                array_push($errors, 'Happen on must be 30 minutes from ends on.');
            }
        }

    }

    if (empty($errors)) {

        // adding to db
        $c = new Competitions($db);
        
        $starts_on = normal_to_db_date($starts_on);
        $ends_on = normal_to_db_date($ends_on);
        $result = $c->create($event['event_id'], $name, $team_min, $team_max, $cost, $cost_type, $starts_on, $ends_on, $about, $rules);

        if ($result['status']) {
            $_SESSION['message'] = ['type' => 'success', 'data' => 'Competition successfully added to the event.'];
            go(URL . '/organiser/view_event.php?e='.$event['event_id']);
        }
        array_push($errors, $result['data']);

    }


}

include '../views/layout/header.view.php';
include '../views/organiser/add_competition.view.php';
include '../views/layout/footer.view.php';
