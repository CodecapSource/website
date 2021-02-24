<h1 class="o-title">Settings</h1>

<?php if (isset($s_success) && !empty($s_success)): ?>
    <div class="message success"><?=$s_success?></div>
<?php endif; ?>
<?php if (isset($s_error) && !empty($s_error)): ?>
    <div class="message error"><?=$s_error?></div>
<?php endif; ?>

<h2 class="o-title-sub pt-0">Your Information</h2>

<?php if (!empty($errors)): ?>
    <div class="message error"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></div>
<?php endif; ?>
<form action="" method="post">
    <div class="input input-text organiser-name">
        <label for="organiser_name">Organiser Name</label>
        <input type="text" id="organiser_name" name="organiser_name" placeholder="Organiser Name" value="<?=$_POST['organiser_name'] ?? $user['or_name']?>">
        <br>
    </div>
    <div class="input input-text organiser-about">
        <label for="organiser_about">Organiser About</label>
        <textarea type="text" id="organiser_about" name="organiser_about" placeholder="Organiser About"><?=$_POST['organiser_about'] ?? $user['or_about']?></textarea>
        <br>
    </div>
    <div class="input-submit">
        <button type="submit"><i class="fas fa-check" aria-hidden="true"></i> Save</button>
    </div>
    <input type="hidden" name="information">
</form>
