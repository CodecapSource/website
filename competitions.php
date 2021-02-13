<?php

include 'app/start.php';

$c = new Competitions($db);
$competitions = $c->get_all_competitions_details();

if (!$competitions['status']) {
    $competitions = [];
} else {
    $competitions = $competitions['data'];
}

$_no_of_competitions = count($competitions);

include 'views/layout/public_header.view.php';
include 'views/competitions.view.php';
include 'views/layout/public_footer.view.php';
