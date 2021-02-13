<?php if (isset($s_success) && !empty($s_success)): ?>
    <p style="color: green"><?=$s_success?></p>
<?php endif; ?>
<?php if (isset($s_error) && !empty($s_error)): ?>
    <p style="color: red"><?=$s_error?></p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <p style="color: red"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></p>
<?php endif; ?>

<table border="1">
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
                    <a href="<?=URL?>/organiser/view_event.php?e=<?=$event['event_id']?>">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
