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

if (isset($_POST) && !empty($_POST)) {
    
    if (isset($_POST['information'])) {

        $to_update = [];
        if (!isset($_POST['organiser_name']) || !is_string($_POST['organiser_name']) || empty(normal_text($_POST['organiser_name']))) {
            array_push($errors, "Organiser name cannot be empty");
        } else {
            $name = normal_text($_POST['organiser_name']);

            if ($name !== $user['or_name']) {
                $to_update['or_name'] = $name;
            }
        }
        if (!isset($_POST['organiser_about']) || !is_string($_POST['organiser_about']) || empty(normal_text($_POST['organiser_about']))) {
            array_push($errors, "Organiser about cannot be empty");
        } else {
            $about = normal_text($_POST['organiser_about']);

            if ($name !== $user['or_about']) {
                $to_update['or_about'] = $about;
            }
        }
        
        if (empty($errors)) {

            if (empty($to_update)) {
                $s_success = "No changes made";
            } else {
                
                $result = $o->update($to_update, $user['or_id']);

                if ($result['status']) {
                    $_SESSION['message'] = ['type' => 'success', 'data' => 'Your information updated successfully'];
                    go(URL . '/organiser/settings.php');    
                }
                array_push($errors, $result['data']);

            }

        }

    }

}

include '../views/layout/header.view.php';
include '../views/organiser/settings.view.php';
include '../views/layout/footer.view.php';
