<div class="page">
    <div class="page-title">
        <div class="page-title-left">
            <h1><span>Competitions</span></h1>
            <p>Scroll Through active competitions</p>
        </div>
        <div class="page-title-right">
            <div class="page-title-right-comp">
                <h3><?=$_no_of_competitions?></h3>
                <p>Competitions available</p>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="comp-page">

            <?php if (isset($s_error) && !empty($s_error)): ?>
                <div class="message error"><?=$s_error?></div>
            <?php endif; ?>
            
            <div class="comp-page-info">Showing <?=$_no_of_competitions?> Result out of <?=$_no_of_competitions?></div>

            <?php foreach ($competitions as $competition): ?>
            <div class="comp-page-row">
                <div class="comp-left">
                    <a href="<?=URL?>/launchpad/participate.php?c=<?=$competition['competition_id']?>" class="comp-left-top">
                        <h3><?=$competition['competition_name']?></h3>
                        <p><?=$competition['competition_about']?></p>
                    </a>
                    <div class="comp-left-bottom">
                        <div class="comp-left-bottom-box comp-left-bottom-2">
                            <p>Location</p>
                            <h5 class="text-green"><?=($competition['event_location_type'] === 'V') ? 'Online' : 'Onsite <a href="">Location</a>'?></h5>
                            <p class="location"><?=$competition['country_name']?> <img src="https://www.countryflags.io/<?=$competition['country_iso']?>/shiny/24.png" alt="<?=$competition['country_name']?>"></p>
                        </div>
                        <div class="comp-left-bottom-box comp-left-bottom-1">
                            <p>Cost</p>
                            <h5><?=$competition['competition_cost']?> <span class="codn-icon-text">Codn</span></h5>
                            <p><?=($competition['competition_cost_type'] === 'M')?'Per member':'Per team'?></p>
                        </div>
                        <div class="comp-left-bottom-box comp-left-bottom-1">
                            <p>Team Size</p>
                            <div class="comp-left-line">
                                <div class="comp-left-line-box">
                                    <h5><?=$competition['competition_member_min']?></h5>
                                    <p>min.</p>
                                </div>
                                <div class="comp-left-line-box">
                                    <h5><?=$competition['competition_member_max']?></h5>
                                    <p>max.</p>
                                </div>
                            </div>
                        </div>
                        <div class="comp-left-bottom-box comp-left-bottom-2">
                            <p>Happening on</p>
                            <p><?=normal_date($competition['competition_starts'], 'M d, Y')?></p>
                            <div class="comp-left-line">
                                <div class="comp-left-line-box">
                                    <h5><?=normal_date($competition['competition_starts'], 'h:i A')?></h5>
                                    <p>Starts</p>
                                </div>
                                <div class="comp-left-line-box">
                                    <h5><?=normal_date($competition['competition_ends'], 'h:i A')?></h5>
                                    <p>Ends</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comp-right">
                    <div class="comp-organiser">
                        <h5>Organised by</h5>
                        <div class="comp-organiser-row">
                            <div class="competition-box-bottom-left-avatar">OO</div>
                            <div class="comp-organiser-row-text"><?=$competition['event_organiser_name']?></div>
                        </div>
                        <p><?=$competition['event_about']?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
