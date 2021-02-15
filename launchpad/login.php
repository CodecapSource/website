<?php

include '../app/start.php';

$errors = [];

if (isset($_POST) && !empty($_POST)) {

    $m = new Members($db);

    $check_password = true;
    if ($_POST['email'] && is_string($_POST['email']) && !empty(normal_text($_POST['email']))) {
        $email = normal_text($_POST['email']);
        
        $email_length = 6;
        if (strlen($email) < $email_length) {   
            array_push($errors, "Email length must be minimum $email_length characters");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email format is incorrect");
        } else {
            $member = $m->get_one("member_email", $email);
            if (!$member['status']) {
                array_push($errors, "Email doesn't exists");
                $check_password = false;
            } else if ($member['data']['member_account_status'] !== 'A') {
                if ($member['data']['member_account_status'] === 'U') {
                    array_push($errors, "Your account is unverified");
                    $check_password = false;
                } else {
                    array_push($errors, "Your account has been banned");
                    $check_password = false;
                }
            } else {
                $member = $member['data'];
            }
        }
    } else {
        array_push($errors, "Email cannot be empty");
    }

    if ($check_password) {
        if ($_POST['password'] && is_string($_POST['password']) && !empty(normal_text($_POST['password']))) {
            $password = normal_text($_POST['password']);
    
            if (empty($errors)) {
                $password_length = 4;
                if (strlen($password) < $password_length) {   
                    array_push($errors, "Password length must be minimum $password_length characters");
                } else if (!password_verify($password, $member['member_password'])) {
                    array_push($errors, "Provided password is invalid");
                }
            }
        } else {
            array_push($errors, "Password cannot be empty");
        }
    }

    if (empty($errors)) {
        // successful login
        
        $_SESSION['member_logged'] = $member['member_id'];
        go (URL . '/launchpad/dashboard.php');

    }

}


$header = false;

include '../views/layout/public_header.view.php';
include '../views/launchpad/login.view.php';
include '../views/layout/public_footer.view.php';
