<?php

include '../app/start.php';

$errors = [];

$co = new Country($db);

if (isset($_POST) && !empty($_POST)) {

    $m = new Members($db);

    if ($_POST['name'] && is_string($_POST['name']) && !empty(normal_text($_POST['name']))) {
        $name = normal_text($_POST['name']);

        $name_length = 2;
        if (strlen($name) < $name_length) {   
            array_push($errors, "Name length must be minimum $name_length characters");
        }
    } else {
        array_push($errors, "Name cannot be empty");
    }

    if ($_POST['email'] && is_string($_POST['email']) && !empty(normal_text($_POST['email']))) {
        $email = normal_text($_POST['email']);
        
        $email_length = 6;
        if (strlen($email) < $email_length) {   
            array_push($errors, "Email length must be minimum $email_length characters");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email format is incorrect");
        } elseif (($m->get_one("member_email", $email))['status']) {
            array_push($errors, "Email already exists");
        }
    } else {
        array_push($errors, "Email cannot be empty");
    }

    $password_length = 4;
    if ($_POST['password'] && is_string($_POST['password']) && !empty(normal_text($_POST['password']))) {
        $password = normal_text($_POST['password']);

        if (strlen($password) < $password_length) {   
            array_push($errors, "Password length must be minimum $password_length characters");
        }
    } else {
        array_push($errors, "Password cannot be empty");
    }

    if ($_POST['repassword'] && is_string($_POST['repassword']) && !empty(normal_text($_POST['repassword']))) {
        $repassword = normal_text($_POST['repassword']);
 
        if (strlen($password) > 4 && isset($password) && $repassword !== $password) {   
            array_push($errors, "Confirm password doesn't match with your password");
        }
    } else {
        array_push($errors, "Confirm password cannot be empty");
    }
    
    if (is_string($_POST["country"]) && !empty(normal_text($_POST["country"]))) {
        $country = normal_text($_POST["country"]);
        $country_length = 2;
        if (strlen($country) !== $country_length) {   
            array_push($errors, "Country length must be $country_length characters");
        } else {
            $c = $co->get_one("country_iso", $_POST["country"]);
            if ($c['status']) {
                $_country = $c['data']['country_iso'];
            } else {
                array_push($errors, "Selected country is invalid");
            }
        }
    } else {
        array_push($errors, "Please select country");
    }

    
    if ($_POST['contact'] && is_numeric($_POST['contact']) && !empty(normal_text($_POST['contact']))) {
        $contact = normal_text($_POST['contact']);

        $contact_length = 9;
        if (strlen($contact) < $contact_length) {   
            array_push($errors, "Contact length must be minimum $contact_length digits");
        }
    } else {
        array_push($errors, "Contact cannot be empty and only contain numbers");
    }

    if (empty($errors)) {

        $password = password_hash($password, PASSWORD_BCRYPT);
        
        $ip = PROJECT_MODE == 'development' ? '203.101.187.19' : get_ip();

        $result = $m->insert($name, $email, $password, $country, $contact, $ip);
        

        if ($result['status']) {
            $_SESSION['message'] = ['type' => 'success', 'data' => 'You have successfully registered, Login now.'];
            go(URL . '/launchpad/login.php');
        }

        array_push($errors, "Couldn't register your account.");

    }

}

$countries = $co->get_all();
if ($countries['status']) {
    $countries = $countries['data'];
} else {
    $countries = [];
}

?>


<?php if (!empty($errors)): ?>
    <p style="color: red"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></p>
<?php endif; ?>

<form action="" method="post">
    <input type="text" name="name" id="name" placeholder="Full Name" value="<?=$_POST['name']??''?>">
    <input type="email" name="email" id="email" placeholder="Email" value="<?=$_POST['email']??''?>">
    <input type="password" name="password" id="password" placeholder="Password">
    <input type="password" name="repassword" id="repassword" placeholder="Confirm Password">

    <select name="country" id="country">
        <?php foreach ($countries as $c): ?>
        <option value="<?=$c['country_iso']?>" <?=(isset($_POST['country'])) ? ($c['country_iso'] === $_POST['country'] ? 'selected' : '') : ($c['country_iso'] === 'PK' ? 'selected' : '')?>><?=$c['country_name']?></option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="contact" id="contact" placeholder="Mobile" value="<?=$_POST['contact']??''?>">
    

    <button type="submit">Create</button>
</form>
