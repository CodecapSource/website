<?php if (isset($s_success) && !empty($s_success)): ?>
    <p style="color: green"><?=$s_success?></p>
<?php endif; ?>

<h3>Competitions</h3>
<a href="<?=URL?>/organiser/add_competition.php?e=<?=$event['event_id']?>">Add Competition</a>
<table border="1">
    <?php foreach ($competitions as $competition): ?>
    <tr>
        <td><?=$competition['competition_name']?></td>
        <td><?=$competition['competition_member_min']?></td>
        <td><?=$competition['competition_member_max']?></td>
        <td><?=normal_date($competition['competition_starts'])?></td>
        <td><?=normal_date($competition['competition_ends'])?></td>
        <td><?=$competition['competition_cost']?> /<?=($competition['competition_cost_type'] === 'M')?'member': 'team'?></td>
        <td><?=$competition['competition_status']?></td>
        <td><a href="participants.php?c=<?=$competition['competition_id']?>">Participants</a></td>
        <td><a href="questions.php?c=<?=$competition['competition_id']?>">Questions</a></td>
        <td><a href="submissions.php?c=<?=$competition['competition_id']?>">Submissions</a></td>
    </tr>
    <?php endforeach; ?>
</table>
