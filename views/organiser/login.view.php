<div class="window">
    <div class="window-center">
        <div class="window-logo"><a href="<?=URL?>/"><img src="<?=URL?>/assets/images/logo-dark.svg" alt="Codecap"></a></div>
        <div class="window-title">Login!</div>
        <div class="window-title-sub">Access to your organiser panel</div>
        <div class="window-form">
            <form action="" method="post">
                <?php if (isset($s_success) && !empty($s_success)): ?>
                    <div class="message success"><?=$s_success?></div>
                <?php endif; ?>
                <?php if (isset($s_error) && !empty($s_error)): ?>
                    <div class="message error"><?=$s_error?></div>
                <?php endif; ?>

                <?php if (isset($response)): ?>
                    <div class="message error">
                    <?php foreach ($response['data'] as $r): ?>
                        <b><?=ucfirst($r['field'])?></b> <?=$r['data'].'. '?>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="input input-text">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="email address" value="<?=$_POST['email']??''?>">
                </div>
                <div class="input input-text">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="enter password">
                </div>
                <div class="input-submit">
                    <button type="submit"><i class="fas fa-lock"></i> Authenticate</button>
                </div>
                <div class="input-back">
                    <a href="<?=URL?>/organiser" class="button button-dark"><i class="fas fa-arrow-left"></i> Back</a>
                    <a href="<?=URL?>/organiser/signup.php" class="button button-orange">Make a account <i class="fas fa-arrow-right"></i></a>
                </div>
            </form>
        </div>
    </div>
</div>
