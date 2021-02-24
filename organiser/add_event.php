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

$c = new Country($db);
$countries = $c->get_all();
if ($countries['status']) {
    $countries = $countries['data'];
} else {
    $countries = [];
}

$errors = [];

// checking user balance

$show = true;
$creation_cost = $settings->fetch('event_creation_cost');
if ($user['or_balance'] < $creation_cost) {
    $show = false;
    array_push($errors, 'Insufficient balance for creating the event. Please <a href="'.URL.'/organiser/deposit.php">deposit balance</a>');
} else {

    if (isset($_POST) && !empty($_POST)) {

        if (isset($_POST['event_name']) && is_string($_POST['event_name']) && !empty(normal_text($_POST['event_name']))) {
            $event_name = normal_text($_POST['event_name']);
        } else {
            array_push($errors, 'Event name cannot be empty');
        }

        if (isset($_POST['event_already'])) {
            $organiser_name = $user['or_name'];
            $organiser_about = $user['or_about'];
        } else {
            if (isset($_POST['organiser_name']) && is_string($_POST['organiser_name']) && !empty(normal_text($_POST['organiser_name']))) {
                $organiser_name = normal_text($_POST['organiser_name']);
            } else {
                array_push($errors, 'Organiser name cannot be empty');
            }

            if (isset($_POST['organiser_about']) && is_string($_POST['organiser_about']) && !empty(normal_text($_POST['organiser_about']))) {
                $organiser_about = normal_text($_POST['organiser_about']);
            } else {
                array_push($errors, 'Organiser about cannot be empty');
            }
        }

        if (isset($_POST['event_about']) && is_string($_POST['event_about']) && !empty(normal_text($_POST['event_about']))) {
            $event_about = normal_text($_POST['event_about']);
        } else {
            array_push($errors, 'Event about cannot be empty');
        }

        if (isset($_POST['happen_on']) && is_string($_POST['happen_on']) && !empty(normal_text($_POST['happen_on']))) {
            $happen_on = normal_date(normal_text($_POST['happen_on']));
            $d_diff = get_date_difference($happen_on, current_date());
            if (!$d_diff["positive"]) {
                array_push($errors, 'Happen on cannot be passed date');
            } else {
                $count_days = ($d_diff['years'] * 365) + ($d_diff['months'] * 30) + $d_diff['days'];
                if ($count_days < 1) {
                    array_push($errors, 'Happen on must be 2 days from today.');
                }
            }
        } else {
            array_push($errors, 'Happen on cannot be empty');
        }

        if (isset($_POST['ends_on']) && is_string($_POST['ends_on']) && !empty(normal_text($_POST['ends_on']))) {
            $ends_on = normal_date(normal_text($_POST['ends_on']));
        } else {
            array_push($errors, 'Ends on cannot be empty');
        }

        if (isset($_POST['location']) && is_string($_POST['location']) && !empty(normal_text($_POST['location']))) {
            $location_type = normal_text($_POST['location']);

            if ($location_type === 'p') {
                if (isset($_POST['address']) && is_string($_POST['address']) && !empty(normal_text($_POST['address']))) {
                    $address = normal_text($_POST['address']);
                } else {
                    array_push($errors, 'Event address cannot be empty');
                }
            } else {
                $address = '';
            }
        } else {
            array_push($errors, 'Event location cannot be empty');
        }

        if (isset($_POST['country']) && is_string($_POST['country']) && !empty(normal_text($_POST['country']))) {
            $country = normal_text($_POST['country']);
        } else {
            array_push($errors, 'Event country cannot be empty');
        }

        if (empty($errors)) {
            // checking happen/end date difference
            $d_diff = get_date_difference($ends_on, $happen_on);
            if (!$d_diff["positive"]) {
                array_push($errors, 'Ends on cannot be less than or equal to happen date');
            } else {
                $count_hours = ($d_diff['years'] * 8760) + ($d_diff['months'] * 730.001) + ($d_diff['days'] * 24) + $d_diff['hours'];
                if ($count_hours < 1) {
                    array_push($errors, 'Happen on must be 1 hour from ends on.');
                }
            }
        }

        if (empty($errors)) {

            // inserting event

            $happen_on = normal_to_db_date($happen_on);
            $ends_on = normal_to_db_date($ends_on);
            
            $e = new Events($db);

            $t = new Otransactions($db);

            $new_balance = $user['or_balance'] - $creation_cost;
            $t->set_values('E', $user['or_id'], 'S', '', $creation_cost, $user['or_balance'], $new_balance, 'Event creation cost deduction', 'C');
            $result = $e->create($event_name, $user['or_id'], $organiser_name, $organiser_about, $event_about, $happen_on, $ends_on, $location_type, $country, $address, $t, $o);

            if ($result['status']) {
                $_SESSION['message'] = ['type' => 'success', 'data' => 'Event added successfully. Add competitions to event below.'];
                go(URL . '/organiser/view_event.php?e='.$result['event_id']);
            }
            array_push($errors, $result['data']);

        }


    }

}

include '../views/layout/header.view.php';
include '../views/organiser/add_event.view.php';
include '../views/layout/footer.view.php';
