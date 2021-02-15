<div class="o-page-link">
    <a href="<?=URL?>/organiser/events.php" class="button"><i class="fas fa-arrow-left"></i> Go Back</a>
</div>

<h1 class="o-title">Competitions</h1>
<h3 class="o-title-sub">Event - <?=$event['event_name']?></h3>

<?php if (isset($s_success) && !empty($s_success)): ?>
    <div class="message success"><?=$s_success?></div>
<?php endif; ?>
<?php if (isset($s_error) && !empty($s_error)): ?>
    <div class="message error"><?=$s_error?></div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Starts</th>
            <th>Ends</th>
            <th>Team Min.</th>
            <th>Team Max.</th>
            <th>Fee</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <?php foreach ($competitions as $competition): ?>
    <tr>
        <td><?=$competition['competition_name']?></td>
        <td><?=normal_date($competition['competition_starts'])?></td>
        <td><?=normal_date($competition['competition_ends'])?></td>
        <td><?=$competition['competition_member_min']?></td>
        <td><?=$competition['competition_member_max']?></td>
        <td><?=$competition['competition_cost']?> /<?=($competition['competition_cost_type'] === 'M')?'member': 'team'?></td>
        <td><?=$competition['competition_status'] === 'A' ? 'Active' : 'Completed' ?></td>
        <td>
            <a href="participants.php?c=<?=$competition['competition_id']?>" class="button button-green">Participants</a>
            <a href="questions.php?c=<?=$competition['competition_id']?>" class="button button-dark">Questions</a>
            <a href="submissions.php?c=<?=$competition['competition_id']?>" class="button button-orange">Submissions</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="o-page-link">
    <a href="<?=URL?>/organiser/add_competition.php?e=<?=$event['event_id']?>" class="button button-dark">Add Competition <i class="fas fa-plus"></i></a>
</div>
