<?php

include '../app/start.php';

$country = new Country($db);

if (isset($_POST) && !empty($_POST)) {

    $required_fields = ["email", "name", "password", "country"];
    $data =  $_POST;

    $invalid_fields = [];
    foreach ($required_fields as $rfield) {
        if (!array_key_exists($rfield, $data)) {
            array_push($invalid_fields, ["field" => $rfield, "type" => "parameter", "data" => "'$rfield' request parameter missing"]);
        }
    }

    
    if (empty($invalid_fields)) {

        $organiser = new Organiser($db);
        $data_bag = [];

        // Name field
        if (is_string($data["name"]) && !empty(normal_text($data["name"]))) {
            $_name = normal_text($data["name"]);
            $name_length = 3;
            if (strlen($_name) < $name_length) {   
                array_push($invalid_fields, ["field" => "name", "type" => "length", "data" => "Length must be minimum $name_length characters"]);
            } else {
                $data_bag["or_name"] = $_name;
            }
        } else {
            array_push($invalid_fields, ["field" => "name", "type" => "empty", "data" => "Field is empty"]);
        }

        // Email field
        if (is_string($data["email"]) && !empty(normal_text($data["email"]))) {
            $_email = normal_text($data["email"]);
            $email_length = 6;
            if (strlen($_email) < $email_length) {   
                array_push($invalid_fields, ["field" => "email", "type" => "length", "data" => "Length must be minimum $email_length characters"]);
            } elseif (!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
                array_push($invalid_fields, ["field" => "email", "type" => "pattern", "data" => "Email format is incorrect"]);
            } elseif (($organiser->get_one("or_email", $_email))['status']) {
                array_push($invalid_fields, ["field" => "email", "type" => "exists", "data" => "Email already exists"]);
            } else {
                $data_bag["or_email"] = $_email;
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
            } else {
                $_password = password_hash($_password, PASSWORD_BCRYPT, ['cost' => 4]);
                $data_bag["or_password"] = $_password;
            }
        } else {
            array_push($invalid_fields, ["field" => "password", "type" => "empty", "data" => "Field is empty"]);
        }
        
        // Country field
        if (is_string($data["country"]) && !empty(normal_text($data["country"]))) {
            $_country = normal_text($data["country"]);
            $country_length = 2;
            if (strlen($_country) !== $country_length) {   
                array_push($invalid_fields, ["field" => "country", "type" => "length", "data" => "Length must be $country_length characters"]);
            } else {
                $c = $country->get_one("country_iso", $data["country"]);
                if ($c['status']) {
                    $_country = $c['data']['country_iso'];
                    $data_bag["or_country_iso"] = $_country;
                } else {
                    array_push($invalid_fields, ["field" => "country", "type" => "invalid", "data" => "Selected country is invalid"]);
                }
            }
        } else {
            array_push($invalid_fields, ["field" => "country", "type" => "empty", "data" => "Field is empty"]);
        }

        if (empty($invalid_fields)) {
            /**
             * Validation is passed 
             *  inserting data to database
             *  */ 
            $data_bag["or_reg_ip"] = PROJECT_MODE == 'development' ? '203.101.187.19' : get_ip();

            $signup = $organiser->add($data_bag);

            if ($signup['status']) {
                $response = ["status" => true, "type" => "request", "data" => "Successfully signed up."];
            } else {
                $response = ["status" => false, "type" => "request", "data" => "Unable to process data."];
            }
        }
    }

    if (!empty($invalid_fields)) {
        $response = ["status" => false, "type" => "fields", "data" => $invalid_fields];
    }

}

$countries = $country->get_all();
if ($countries['status']) {
    $countries = $countries['data'];
} else {
    $countries = [];
}

$header = false;

include '../views/layout/public_header.view.php';
include '../views/organiser/signup.view.php';
include '../views/layout/public_footer.view.php';
