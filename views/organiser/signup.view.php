
<?php if (isset($response)): ?>
    <?php if ($response['status']): ?>
        <p style="color: green">Successfully registered!</p>
    <?php else: ?>
        <?php foreach ($response['data'] as $r): ?>
            <p><b><?=ucfirst($r['field'])?></b> <?=$r['data']?></p>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>


<form action="" method="post">
    <input type="text" name="name" id="name" value="<?=$_POST['name']??''?>">
    <input type="text" name="email" id="email" value="<?=$_POST['email']??''?>">
    <input type="password" name="password" id="password">
    
    <select name="country" id="country">
        <?php foreach ($countries as $c): ?>
        <option value="<?=$c['country_iso']?>" <?=(isset($_POST['country'])) ? ($c['country_iso'] === $_POST['country'] ? 'selected' : '') : ($c['country_iso'] === 'PK' ? 'selected' : '')?>><?=$c['country_name']?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Sign up</button>
</form>
