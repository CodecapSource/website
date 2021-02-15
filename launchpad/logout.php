<?php

include '../app/start.php';

if (isset($_SESSION['member_logged'])) {
    unset($_SESSION['member_logged']);
}

go (URL . '/launchpad/login.php');
