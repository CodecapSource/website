<div class="o-page-link">
    <a href="<?=URL?>/organiser/view_event.php?e=<?=$competition['event_id']?>" class="button"><i class="fas fa-arrow-left"></i> Go Back</a>
</div>

<h1 class="o-title">Participants</h1>

<?php if (isset($s_success) && !empty($s_success)): ?>
    <div class="message success"><?=$s_success?></div>
<?php endif; ?>
<?php if (isset($s_error) && !empty($s_error)): ?>
    <div class="message error"><?=$s_error?></div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="message error"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></div>
<?php endif; ?>

<table>
    <thead>
        <th>Team ID</th>
        <th>Member(s)</th>
        <th>Email(s)</th>
        <th>Contact</th>
        <th>Created on</th>
        <th></th>
    </thead>
    <tbody>
        <?php foreach($teams as $team_id => $team): ?>
            <tr>
                <td>ID-<?=$team_id?></td>
                <td><div class="team-members"><ul><?php foreach($team as $member):?><li><i class="fas fa-user" aria-hidden="true"></i> <?=$member['member_name']?></li><?php endforeach;?></ul></div></td>
                <td><div class="team-members"><ul><?php foreach($team as $member):?><li><i class="fas fa-user" aria-hidden="true"></i> <?=$member['member_email']?></li><?php endforeach;?></ul></div></td>
                <td><div class="team-members"><ul><?php foreach($team as $member):?><li><i class="fas fa-user" aria-hidden="true"></i> <?=$member['member_contact']?></li><?php endforeach;?></ul></div></td>
                <td><?=normal_date($team[0]['team_created'])?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

