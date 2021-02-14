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


?>


<?php if (isset($s_success) && !empty($s_success)): ?>
    <p style="color: green"><?=$s_success?></p>
<?php endif; ?>
<?php if (isset($s_error) && !empty($s_error)): ?>
    <p style="color: red"><?=$s_error?></p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <p style="color: red"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></p>
<?php endif; ?>

<form action="" method="post">

    <input type="email" name="email" id="email" placeholder="Email" value="<?=$_POST['email']??''?>">

    <input type="password" name="password" id="password" placeholder="Password">

    <button type="submit">Login</button>
</form>
