<h1 class="o-title">Events</h1>

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
        <th>Name</th>
        <th>Happen On</th>
        <th>Ends On</th>
        <th>Type</th>
        <th>Country</th>
        <th>Status</th>
        <th>Created on</th>
        <th></th>
    </thead>
    <tbody>
        <?php foreach($events as $event): ?>
            <tr>
                <td><?=$event['event_name']?></td>
                <td><?=normal_date($event['event_happen_on'])?></td>
                <td><?=normal_date($event['event_ends_on'])?></td>
                <td><?=get_event_type_text($event['event_location_type'])?></td>
                <td><?=$event['country_name']?></td>
                <td><?=get_event_status_text($event['event_status'])?></td>
                <td><?=normal_date($event['event_created'])?></td>
                <td>
                    <a href="<?=URL?>/organiser/view_event.php?e=<?=$event['event_id']?>" class="button button-green">View <i class="fas fa-arrow-right"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="o-page-link">
    <a href="<?=URL?>/organiser/add_event.php" class="button button-dark">Add New <i class="fas fa-plus"></i></a>
</div>
