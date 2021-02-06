
<?php if (isset($response)): ?>
    <?php foreach ($response['data'] as $r): ?>
        <p><b><?=ucfirst($r['field'])?></b> <?=$r['data']?></p>
    <?php endforeach; ?>
<?php endif; ?>

<form action="" method="post">
    <input type="text" name="email" id="email">
    <input type="password" name="password" id="password">
    <button type="submit">Login</button>
</form>
