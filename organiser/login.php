<?php

include '../app/start.php';

if (isset($_POST) && !empty($_POST)) {

    $required_fields = ["email", "password"];
    $data = $_POST;
    
    $invalid_fields = [];
    foreach ($required_fields as $rfield) {
        if (!array_key_exists($rfield, $data)) {
            array_push($invalid_fields, ["field" => $rfield, "type" => "parameter", "data" => "'$rfield' request parameter missing"]);
        }
    }


    if (empty($invalid_fields)) {

        $organiser = new Organiser($db);
        $data_bag = [];
        $found_user = false;

        // Email field
        if (is_string($data["email"]) && !empty(normal_text($data["email"]))) {

            $_email = normal_text($data["email"]);
            $email_length = 6;

            if (strlen($_email) < $email_length) {   
                array_push($invalid_fields, ["field" => "email", "type" => "length", "data" => "Length must be minimum $email_length characters"]);
            } elseif (!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
                array_push($invalid_fields, ["field" => "email", "type" => "pattern", "data" => "Email format is incorrect"]);
            } else {

                $found_user = $organiser->get_one("or_email", $_email);
                if (!$found_user['status']) {
                    array_push($invalid_fields, ["field" => "email", "type" => "invalid", "data" => "Email does not exists"]);
                } else {
                    $data_bag["or_email"] = $_email;
                    $found_user = $found_user['data'];
                }

            }

        } else {
            array_push($invalid_fields, ["field" => "email", "type" => "empty", "data" => "Field is empty"]);
        }

        // Password field
        if (is_string($data["password"]) && !empty(normal_text($data["password"]))) {

            $_password = normal_text($data["password"]);
            $password_length = 4;

            if (strlen($_password) < $password_length) {   
                array_push($invalid_fields, ["field" => "password", "type" => "length", "data" => "Length must be minimum $password_length characters"]);
            } else if (!empty($found_user) && isset($found_user['status']) && $found_user['status']) {
                if(!password_verify($_password, $found_user['or_password'])) {
                    array_push($invalid_fields, ["field" => "password", "type" => "length", "data" => "Password is incorrect"]);
                } else {
                    $data_bag["or_password"] = $_password;
                }
            }

        } else {
            array_push($invalid_fields, ["field" => "password", "type" => "empty", "data" => "Field is empty"]);
        }
        
    }

    if (empty($invalid_fields)) {

        $_SESSION['logged'] = $found_user['or_id'];
        go (URL . '/organiser/dashboard.php');

    } else {
        $response = ["status" => false, "type" => "fields", "data" => $invalid_fields];
    }

}

include '../views/layout/header.view.php';
include '../views/organiser/login.view.php';
include '../views/layout/footer.view.php';
