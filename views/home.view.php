<section class="main">
    <div class="home-top">
        <div class="home-left">
            <div class="home-left-main">
                <h3>Organise.</h3>
                <h4>Compete.</h4>
                <h5>Win.</h5>    
            </div>
            <div class="home-left-light">
                <h5>Bridging the gap</h5>
                <p>A fully funcation coding competitions platform for programmers and event organisers!</p>
            </div>
            <div class="home-features">
                <div class="home-features-row">
                    <img src="assets/images/features-1.svg">
                    <div class="home-features-row-text">
                        <h5>what organizers can do...</h5>
                        <p>Create, announce, manage events and competitions.</p>
                    </div>
                </div>
                <div class="home-features-row">
                    <img src="assets/images/features-2.svg">
                    <div class="home-features-row-text">
                        <h5>what programmers can do...</h5>
                        <p>Add friends to code with you.</p>
                    </div>
                </div>
                <div class="home-features-row">
                    <img src="assets/images/features-3.svg">
                    <div class="home-features-row-text">
                        <h5>what’s more here...</h5>
                        <p>Buy our currency - <span>Codn</span> and share rewards!</p>
                    </div>
                </div>
                <div class="home-features-row">
                    <img src="assets/images/features-4.svg">
                    <div class="home-features-row-text">
                        <h5>productivity is defined...</h5>
                        <p>Code in our advanced editor and compile!</p>
                    </div>
                </div>
                <div class="home-features-buttons">
                    <a href="<?=URL?>/organiser" class="button button-green">Organise</a>
                    <a href="<?=URL?>/launchpad" class="button button-dark">Participate</a>
                </div>
            </div>
        </div>
        <div class="home-right">
            <img src="assets/images/code-screen.svg" alt="Code">
        </div>
    </div>

    <div class="events">
        <div class="events-title">
            <h3>Currently Active</h3>
            <h2>Events</h2>
        </div>
        <div class="competition-boxes">
        <?php foreach ($active_events as $i => $event): if ($i > 1){break;} ?>
            <div class="competition-box">
                <div class="competition-box-happening">
                    Happening on <span><?=$event['event_happen_on']?></span>
                </div>
                <div class="competition-box-top">
                    <h3><?=$event['event_name']?></h3>
                    <p><?=$event['event_about']?></p>
                    <p class="location"><?=$event['country_name']?> <img src="https://www.countryflags.io/<?=$event['country_iso']?>/shiny/24.png" alt="<?=$event['country_name']?>"></p>
                </div>
                <div class="competition-box-bottom">
                    <div class="competition-box-bottom-left">
                        <div class="competition-box-bottom-left-avatar">IU</div>
                        <div class="competition-box-bottom-left-text">
                            <p>Organised by</p>
                            <h5><?=$event['event_organiser_name']?></h5>
                        </div>
                    </div>
                    <div class="competition-box-bottom-right">
                        <a href="<?=URL?>/launchpad" class="button button-orange">Participate</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
            <div class="competition-boxes-link"><a href="<?=URL?>/competitions.php" class="button">View More</a></div>
        </div>
    </div>
    

    <div class="events">
        <div class="events-title">
            <h3>Stay tuned</h3>
            <h2>Upcoming..</h2>
        </div>
        <div class="competition-boxes">
        <?php foreach ($upcoming_events as $i => $event): if ($i > 2){break;} ?>
            <div class="competition-box">
                <div class="competition-box-happening">
                    Happening on <span><?=$event['event_happen_on']?></span>
                </div>
                <div class="competition-box-top">
                    <h3><?=$event['event_name']?></h3>
                    <p><?=$event['event_about']?></p>
                    <p class="location"><?=$event['country_name']?> <img src="https://www.countryflags.io/<?=$event['country_iso']?>/shiny/24.png" alt="<?=$event['country_name']?>"></p>
                </div>
                <div class="competition-box-bottom">
                    <div class="competition-box-bottom-left">
                        <div class="competition-box-bottom-left-avatar">IU</div>
                        <div class="competition-box-bottom-left-text">
                            <p>Organiser</p>
                            <h5><?=$event['event_organiser_name']?></h5>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</section>
