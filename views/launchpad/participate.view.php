<div class="page">
    <div class="page-title">
        <div class="page-title-left">
            <h1><span>Participate</span></h1>
            <p>Follow the fields to start competeing</p>
        </div>
        <div class="page-title-right">
            <div class="page-title-right-comp">
                <h3><?=$competition['event_name']?></h3>
                <p>Event</p>
                <div class="go-back">
                    <a href="<?=URL?>/competitions.php" class="button"><i class="fas fa-arrow-left"></i> Go Back</a>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">

        <div class="participate-page">
            <div class="participate-info">
                <div class="participate-info-row">
                    <div class="participate-info-row-icon"><i class="fas fa-trophy"></i></div>
                    <div class="participate-info-row-box">Competition Name</div>
                    <div class="participate-info-row-box"><?=$competition['competition_name']?></div>
                </div>
                <div class="participate-info-row">
                    <div class="participate-info-row-icon"><i class="fas fa-coins"></i></div>
                    <div class="participate-info-row-box">Participation Fees</div>
                    <div class="participate-info-row-box"><?=$competition['competition_cost']?> <span class="codn-icon-text">Codn</span> <strong><?=($competition['competition_cost_type'] === 'M')?'Per member':'Per team'?></strong></div>
                </div>
                <div class="participate-info-row">
                    <div class="participate-info-row-icon"><i class="fas fa-users"></i></div>
                    <div class="participate-info-row-box">Team Limit</div>
                    <div class="participate-info-row-box">
                        <div class="row-inline">
                            <h5>Min <span><?=$competition['competition_member_min']?></span></h5>
                            <h5>Max <span><?=$competition['competition_member_max']?></span></h5>
                        </div>
                    </div>
                </div>
                <div class="participate-info-row">
                    <div class="participate-info-row-icon"><i class="fas fa-clock"></i></div>
                    <div class="participate-info-row-box">Timing</div>
                    <div class="participate-info-row-box">
                        <div class="row-inline">
                            <h5>Starts <span><?=normal_date($competition['competition_starts'])?></span></h5>
                            <h5>Ends <span><?=normal_date($competition['competition_ends'])?></span></h5>
                        </div>
                    </div>
                </div>
                <div class="participate-info-row">
                    <div class="participate-info-row-icon"><i class="fas fa-user-tie"></i></div>
                    <div class="participate-info-row-box">Organiser</div>
                    <div class="participate-info-row-box"><?=$competition['event_organiser_name']?></div>
                </div>
                <div class="participate-info-row">
                    <div class="participate-info-row-icon"><i class="fas fa-gavel"></i></div>
                    <div class="participate-info-row-box">Rules</div>
                    <div class="participate-info-row-box">
                        <p><?=empty($competition['competition_rules']) ? '<i>no rules defined.</i>' : $competition['competition_rules']?></p>
                    </div>
                </div>
            </div>

            <div class="participate-form">
                <form action="" method="post">
                <input type="hidden" name="confirm" value="">
                    <?php if ($transaction): ?>
                        <input type="hidden" name="deduct" value="">
                    <?php endif; ?>
        
                    <?php if (!empty($errors)): ?>
                        <div class="message error">
                            <?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
        
                    <?php if ($competition['competition_member_max'] > 1): ?>
                        <?php if ($transaction): ?>

                        <h3>Transaction</h3>

                        <div class="transaction-cost">
                            <p>Total transaction cost</p>
                            <h4><?=$cost?> <span class="codn-icon-text"></span></h4>
                        </div>

                        <div class="team-members">
                            <p>Team Members</p>
                            <ul>
                                <?php foreach ($confirm_members as $member): ?>
                                    <li><i class="fas fa-user"></i> <?=$member[1]?> <span>(<?=$member[3]?>)</span></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <?php endif; ?>

                        <div <?=$transaction ? 'style="display: none;"' : ''?>>
                            <h3>Add members</h3>

                            <?php for ($n = 1; $n < $competition['competition_member_max']; $n++): ?>
                            <div class="input input-text">
                                <label for="email-<?=$n?>">Member <?=$n+1?> email</label>
                                <input type="email" id="email-<?=$n?>" name="members[]" placeholder="Member <?=$n+1?> email" value="<?=isset($_POST['members'][$n-1]) ? $_POST['members'][$n-1] : ''?>">
                            </div>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
        
                    
                    <?php if ($transaction): ?>
                        
                        <?php if ($cost <= $user['member_balance']): ?>
                            <div class="input-submit">
                                <button type="submit"><i class="fas fa-check" aria-hidden="true"></i> Complete</button>
                            </div>
                        <?php else: ?>
                            <div class="message error">You have insufficient balance to confirm the transaction. <a href="<?=URL?>/launchpad/deposit.php">Deposit</a></div>
                        <?php endif; ?>
        
                    <?php else: ?>

                        <div class="input-submit">
                            <button type="submit"><i class="fas fa-arrow-right" aria-hidden="true"></i> Confirm</button>
                        </div>
                    <?php endif; ?>
                </form>
            </div>

        </div>

    </div>
</div>
