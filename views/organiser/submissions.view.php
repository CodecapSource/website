<div class="o-page-link">
    <a href="<?=URL?>/organiser/view_event.php?e=<?=$competition['event_id']?>" class="button"><i class="fas fa-arrow-left"></i> Go Back</a>
</div>

<h1 class="o-title">Submissions</h1>

<?php if (!empty($submissions)): ?>
<table>
    <thead>
        <tr>
            <th rowspan="2">Team ID</th>
            <th rowspan="2">Question ID</th>
            <th rowspan="2">Member(s)</th>
            <th rowspan="2">Attempt</th>
            <th colspan="3">Review</th>
        </tr>
        <tr>
            <th>Score</th>
            <th>By</th>
            <th>On</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($submissions as $s): ?>
            <tr>
                <td>ID-<?=$s['submission_team_id']?></td>
                <td>ID-<?=$s['submission_question_id']?></td>
                <td><div class="team-members"><ul><?php foreach($teams[$s['submission_team_id']] as $member):?><li><i class="fas fa-user" aria-hidden="true"></i> <?=$member['member_name']?></li><?php endforeach;?></ul></div></td>
                <td><?=normal_date($s['submission_created'])?></td>
                <td><?=!empty($s['submission_reviewer_id']) ? $s['submission_score'] : 'n/a'?>/<?=$s['question_points']?></td>
                <td><?=!empty($s['submission_reviewer_id']) ? $s['submission_reviewer_id'] : 'n/a'?></td>
                <td><?=!empty($s['submission_reviewer_id']) ? $s['submission_graded_on'] : 'n/a'?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <i>No submissions found.</i>
<?php endif; ?>
