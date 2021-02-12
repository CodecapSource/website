<?php

include '../app/start.php';

if (isset($_SESSION['organiser_logged'])) {
    unset($_SESSION['organiser_logged']);
}

go (URL . '/organiser/login.php');
