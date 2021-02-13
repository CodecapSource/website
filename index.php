<?php

include 'app/start.php';

$c = new Competitions($db);
$competitions = $c->get_all_competitions();

if (!$competitions['status']) {
    $competitions = [];
} else {
    $competitions = $competitions['data'];
}

$e = new Events($db);
$events = $e->get_all_events_details($competitions);

if (!$events['status']) {
    $events = [];
} else {
    $events = $events['data'];
}

$competition_event = [];
foreach ($competitions as $competition) {
    if (!array_key_exists($competition['competition_event_id'], $competition_event)) {
        $competition_event[$competition['competition_event_id']] = [$competition];
    } else {
        array_push($competition_event['competition_event_id'], $competition);
    }
}

// mapping to events
$active_events = [];
$upcoming_events = [];

foreach ($events as $i => $event) {
    if (array_key_exists($event['event_id'], $competition_event)) {
        $events[$i]['competitions'] = $competition_event[$event['event_id']];
        if ($event['event_status'] === 'A') {
            array_push($active_events, $events[$i]);
        }
    } else {
        $events[$i]['competitions'] = [];
        array_push($upcoming_events, $events[$i]);
    }
}

include 'views/layout/public_header.view.php';
include 'views/home.view.php';
include 'views/layout/public_footer.view.php';
