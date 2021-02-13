<h1>Competitions - <small><small>total available - <?=$_no_of_competitions?></small></small></h1>

<ul>
<?php foreach ($competitions as $competition): ?>
    <li>
        <h5><?=$competition['competition_name']?></h5>
        <p>
            <?=$competition['competition_about']?>
            <br><?=$competition['event_name']?>
            <br><?=$competition['event_about']?>
            <br>Costs <b><?=$competition['competition_cost']?> <?=($competition['competition_cost_type'] === 'M')?'Per member':'Per team'?></b>
            <br>Team members -> Min <b><?=$competition['competition_member_min']?></b> - <b><?=$competition['competition_member_max']?></b>
            <br>Round time - 
            <br>Starts on - <b><?=normal_date($competition['competition_starts'])?></b>
            <br><?=$competition['event_organiser_name']?>
            <br><?=$competition['event_organiser_about']?>
            <br><?=($competition['event_location_type'] === 'V') ? 'Online' : 'Onsite <a href="">Location</a>'?>
            <br><?=$competition['country_name']?> <img src="https://www.countryflags.io/<?=$competition['country_iso']?>/shiny/24.png" alt="<?=$competition['country_name']?>">
            <br>
            <a href="<?=URL?>/launchpad">Participate</a>
        </p>
    </li>
<?php endforeach; ?>
</ul>
