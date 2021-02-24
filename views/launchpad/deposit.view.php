<div class="page">
    <div class="page-title">
        <div class="page-title-left">
            <h1><span>Deposit Currency</span></h1>
        </div>
    </div>
    <div class="page-content">

        <form action="" method="post" style="margin: 0 auto;">
            <?php if (isset($s_success) && !empty($s_success)): ?>
                <div class="message success"><?=$s_success?></div>
            <?php endif; ?>
            <?php if (isset($s_error) && !empty($s_error)): ?>
                <div class="message error"><?=$s_error?></div>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
                <div class="message error"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></div>
            <?php endif; ?>

            <div class="input input-text mt-2">
                <label for="voucher_code">Enter Voucher Code</label>
                <input type="text" id="voucher_code" name="voucher_code" placeholder="Voucher Code" value="<?=$_POST['voucher_code'] ?? ''?>" maxlength="10">
            </div>
            <div class="input-submit">
                <button type="submit"><i class="fas fa-check" aria-hidden="true"></i> Validate</button>
            </div>

            <div class="divider mt-2"></div>
            <h2 class="o-title-sub">Voucher can be purchased from <a href="" style="font-weight:700">support</a></h2>

        </form>

    </div>
</div>
