<h1>Active Events</h1>
<?php foreach ($active_events as $event): ?>
    <ul>
        <li>
            <h5><?=$event['event_name']?></h5>
            <p><?=$event['event_about']?>
            <br><?=$event['event_happen_on']?> <strong>to</strong> <?=$event['event_ends_on']?>
            <br><?=$event['event_organiser_name']?>
            <br><?=$event['country_name']?> <img src="https://www.countryflags.io/<?=$event['country_iso']?>/shiny/24.png" alt="<?=$event['country_name']?>">
            <br>
            <a href="<?=URL?>/launchpad">Participate</a>
        </li>
    </ul>
<?php endforeach; ?>

<h2>Upcoming Events</h2>
<?php foreach ($upcoming_events as $event): ?>
    <ul>
        <li>
            <h5><?=$event['event_name']?></h5>
            <p><?=$event['event_about']?>
            <br><?=$event['event_happen_on']?> <strong>to</strong> <?=$event['event_ends_on']?>
            <br><?=$event['event_organiser_name']?>
            <br><?=$event['country_name']?> <img src="https://www.countryflags.io/<?=$event['country_iso']?>/shiny/24.png" alt="<?=$event['country_name']?>">
            <br>
        </li>
    </ul>
<?php endforeach; ?>
