<div class="window">
    <div class="window-center">
        <div class="window-logo"><a href="<?=URL?>/"><img src="<?=URL?>/assets/images/logo-dark.svg" alt="Codecap"></a></div>
        <div class="window-title"><small>Become</small> <span>Organiser</span>!</div>
        <div class="window-form">
            <form action="" method="post">
                <?php if (isset($response)): ?>
                    <?php if ($response['status']): ?>
                        <div class="message success">Successfully registered. <a href="<?=URL?>/organiser/login.php">Login now!</a></div>
                    <?php else: ?>
                        <div class="message error">
                        <?php foreach ($response['data'] as $r): ?>
                            <b><?=ucfirst($r['field'])?></b> <?=$r['data'].'. '?>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="input input-text">
                    <label for="fullname">Organiser Name</label>
                    <input type="text" id="fullname" name="name" placeholder="full name" value="<?=$_POST['name']??''?>">
                </div>
                <div class="input input-text">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="email address" value="<?=$_POST['email']??''?>">
                </div>
                <div class="input input-text">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="enter password">
                </div>
                <div class="input input-select input-country">
                    <label for="country">Country</label>
                    <div class="country-preview"><img src="https://www.countryflags.io/pk/shiny/48.png"></div>
                    <select name="country" id="country">
                        <?php foreach ($countries as $c): ?>
                            <option value="<?=$c['country_iso']?>" <?=(isset($_POST['country'])) ? ($c['country_iso'] === $_POST['country'] ? 'selected' : '') : ($c['country_iso'] === 'PK' ? 'selected' : '')?>><?=$c['country_name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-submit">
                    <button type="submit"><i class="fas fa-arrow-right"></i> Start</button>
                </div>
                <div class="input-back">
                    <a href="<?=URL?>/organiser" class="button button-dark"><i class="fas fa-arrow-left"></i> Back</a>
                    <a href="<?=URL?>/organiser/login.php" class="button button-orange">Go to Login <i class="fas fa-arrow-right"></i></a>
                </div>
            </form>
        </div>
    </div>
</div>
