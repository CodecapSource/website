<div class="page">
    <div class="page-title">
        <div class="page-title-left">
            <h1><span>Participations</span></h1>
        </div>
        <div class="page-title-right">
            <div class="page-title-right-comp">
                <h3><?=count($active_participations)?></h3>
                <p>Active Participations</p>
            </div>
        </div>
    </div>
    <div class="page-content">

        <div class="dashboard-content">
            <?php if (isset($s_success) && !empty($s_success)): ?>
                <div class="message success"><?=$s_success?></div>
            <?php endif; ?>
            
            <?php if (isset($s_error) && !empty($s_error)): ?>
                <div class="message error"><?=$s_error?></div>
            <?php endif; ?>

            <div class="dashboard-content-title">
                <h2>List</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Competition</th>
                        <th>Starts</th>
                        <th>Members</th>
                        <th>Date registered</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($active_participations as $participation): ?>
                        <tr>
                            <td><?=$participation['competition_name']?></td>
                            <td><?=normal_date($participation['competition_starts'])?></td>
                            <td>
                                <div class="team-members">
                                <ul>
                                    <?php foreach ($participation['members'] as $member): ?>
                                        <li><i class="fas fa-user"></i> <?=$member['member_name']?> <?=($member['member_id'] === $user['member_id'])?'<span>(YOU)</span>':''?></li>
                                    <?php endforeach; ?>
                                </ul>
                                </div>
                            </td>
                            <td><?=normal_date($participation['team_created'])?></td>
                            <td><a href="<?=URL?>/launchpad/compete.php?c=<?=$participation['competition_id']?>" class="button button-green">Compete</a></td>
                        </tr>    
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="dashboard-content-link">
                <a href="<?=URL?>/launchpad/dashboard.php" class="button"><i class="fas fa-arrow-left"></i> Back to dashboard</a>
            </div>
        </div>

    </div>
</div>