<?php

include '../app/start.php';

$errors = [];

$v = new Vouchers($db);

if (isset($_POST) && !empty($_POST)) {
    
    if (isset($_POST['amount']) && !empty($_POST['amount']) && is_numeric($_POST['amount']) && !($_POST['amount'] < 1)) {

        $amount = normal_text($_POST['amount']);

        $result = $v->generate_voucher($amount);

        if ($result['status']) {
            $_SESSION['message'] = ['type' => 'success', 'data' => 'Generated voucher: <b>'.$result['voucher'].'</b>'];
            header('Location: '.URL.'/admin/generate_voucher.php');
        } else {
            array_push($errors, $result['data']);
        }

    } else {
        array_push($errors, "Invalid amount is entered. Amount must be greater than equal to 1");
    }

}

?>

<?php if (isset($s_success) && !empty($s_success)): ?>
    <div class="message success"><?=$s_success?></div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="message error"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></div>
<?php endif; ?>

<form action="" method="post">
    <input type="number" name="amount" id="amount" placeholder="Enter amount" value="<?=$_POST['amount'] ?? ''?>">
    <button type="submit">Generate</button>
</form>