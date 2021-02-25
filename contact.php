<?php

include 'app/start.php';

$errors = [];

if (isset($_POST) && !empty($_POST)) {

    $_SESSION['message'] = ['type' => 'success', 'data' => "Message successfully sent!"];
    go (URL . '/contact.php');

}

include 'views/layout/public_header.view.php';
include 'views/contact.view.php';
include 'views/layout/public_footer.view.php';
