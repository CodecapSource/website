<div class="o-page-link">
    <a href="<?=URL?>/organiser/events.php" class="button"><i class="fas fa-arrow-left"></i> Go Back</a>
</div>

<h1 class="o-title">Event - <?=$event['event_name']?></h1>
<h3 class="o-title-sub pt-0 pb-0">Competitions</h3>

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
    <?php if (!empty($competitions)): ?>
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
                <a href="participants.php?c=<?=$competition['competition_id']?>" class="button button-green">Participants <i class="fas fa-arrow-right"></i></a><br>
                <a href="questions.php?c=<?=$competition['competition_id']?>" class="button button-dark">Questions <i class="fas fa-arrow-right"></i></a><br>
                <a href="reviewers.php?c=<?=$competition['competition_id']?>" class="button button-golden">Reviewers <i class="fas fa-arrow-right"></i></a><br>
                <a href="submissions.php?c=<?=$competition['competition_id']?>" class="button button-orange">Submissions <i class="fas fa-arrow-right"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">No competition found. Please add one.</td>
        </tr>
    <?php endif; ?>
</table>

<div class="o-page-link">
    <a href="<?=URL?>/organiser/add_competition.php?e=<?=$event['event_id']?>" class="button button-dark"><i class="fas fa-plus"></i> Add Competition</a>
</div>
