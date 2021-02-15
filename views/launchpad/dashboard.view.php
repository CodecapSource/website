<div class="dashboard-page">
    <div class="dashboard-row">
        <div class="dashboard-left">
            <div class="dashboard-left-top">
                <div class="dashboard-text">
                    <h4>Welcome!</h4>
                    <h2><?=$user['member_name']?></h2>
                    <p>Member since <span><?=normal_date($user['member_created'], 'M d, Y')?></span></p>
                </div>
                <div class="dashboard-balance">
                    <div class="dashboard-balance-row">
                        <h3><?=$user['member_balance']?> <span class="codn-icon-text">Codn</span></h3>
                        <p>Available</p>
                    </div>
                    <div class="dashboard-balance-row">
                        <h3><?=$user['member_spent']?> <span class="codn-icon-text">Codn</span></h3>
                        <p>Spent</p>
                    </div>
                    <div class="dashboard-balance-row">
                        <h3><?=$user['member_spent']?> <span class="codn-icon-text">Codn</span></h3>
                        <p>Withdrawn</p>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="dashboard-right">
            <div class="dashboard-content">
                <?php if (isset($s_success) && !empty($s_success)): ?>
                    <div class="message success"><?=$s_success?></div>
                <?php endif; ?>
                <div class="dashboard-content-title">
                    <h2>Active Participation</h2>
                </div>
    
                <table>
                    <thead>
                        <tr>
                            <th>Competition</th>
                            <th>Starts</th>
                            <th>Members</th>
                            <th>Date registered</th>
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
                            </tr>    
                        <?php endforeach; ?>
                    </tbody>
                </table>
    
                <div class="dashboard-content-link">
                    <a href="<?=URL?>/launchpad/participations.php" class="button button-green">View participations <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
