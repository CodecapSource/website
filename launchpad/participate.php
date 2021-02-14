<?php

include '../app/start.php';

// auth check
if (!isset($_SESSION['member_logged']) || empty($_SESSION['member_logged']) || !is_numeric($_SESSION['member_logged'])) {
    $_SESSION['message'] = ['type' => 'error', 'data' => 'You must be logged in to participate.'];
    go (URL . '/launchpad/login.php');
}
if (!isset($_GET['c']) || !is_numeric($_GET['c'])) {
    go (URL . '/competitions.php');
}
$m = new Members($db);
$user = $m->get_one('member_id', $_SESSION['member_logged']);
if (!$user['status'] || $user['data']['member_account_status'] !== 'A') {
    unset($_SESSION['member_logged']);
    go (URL . '/launchpad/login.php');
}
$user = $user['data'];


$c = new Competitions($db);
$competition = $c->get_one_competition_by('competition_id', normal_text($_GET['c']));
if (!$competition['status']) {
    $_SESSION['message'] = ['type' => 'error', 'data' => 'Competition not found!'];
    go (URL . '/competitions.php');
} else if ($competition['data']['event_status'] !== 'A') {
    $d = "Event status seems to have problem";
    if ($competition['data']['event_status'] === 'D') {
        $d = "Event is currently disabled";
    } else if ($competition['data']['event_status'] === 'C') {
        $d = "Event is already finished";
    }
    $_SESSION['message'] = ['type' => 'error', 'data' => $d];
    go (URL . '/competitions.php');
} else if ($competition['data']['competition_status'] !== 'A') {
    $d = "Competition status seems to have problem";
    if ($competition['data']['competition_status'] === 'L') {
        $d = "Competition is currently locked";
    } else if ($competition['data']['event_status'] === 'C') {
        $d = "Competition is already finished";
    }
    $_SESSION['message'] = ['type' => 'error', 'data' => $d];
    go (URL . '/competitions.php');
}
$competition = $competition['data'];

$errors = [];

$transaction = false;

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['confirm'])) {
        // checking for the members
        $confirm_members = [[$user['member_id'], $user['member_name'], true]];
        $to_validate = [];

        if ($competition['competition_member_max'] > 1) {
            if (isset($_POST['members']) && is_array($_POST['members']) && !empty($_POST['members'])) {
                foreach ($_POST['members'] as $i => $member) {
                    $member = normal_text($member);
                    if(!empty($member)) {
                        if (!filter_var($member, FILTER_VALIDATE_EMAIL)) {
                            array_push($errors, "Member " . ($i+2) . " email format is incorrect");
                        } else if ($member === $user['member_email']) {
                            array_push($errors, "Member " . ($i+2) . " email cannot be your email");
                        } else {
                            array_push($to_validate, $member);
                        }
                    }
                }
            }
        }

        if (empty($errors) && !empty($to_validate)) {

            // checking if email exists and account is active
            $old_count = count($to_validate);
            $to_validate = array_unique($to_validate);
            $new_count = count($to_validate);

            if ($old_count !== $new_count) {
                array_push($errors, "Email addresses cannot be repeated");
            } else {
                
                foreach ($to_validate as $i => $email) {
                    $member = $m->get_one("member_email", $email);
                    if (!$member['status']) {
                        array_push($errors, "Member '".$email."' doesn't exists");
                    } else if ($member['data']['member_account_status'] !== 'A') {
                        array_push($errors, "Member '".$email."' account is not active");
                    } else {
                        array_push($confirm_members, [$member['data']['member_id'], $member['data']['member_name'], false]);
                    }
                }
                
            }
        }

        if (empty($errors)) {

            // checking if min max member are satisfied
            if (count($confirm_members) >= $competition['competition_member_min'] && count($confirm_members) <= $competition['competition_member_max']) {
                
                $cost = $competition['competition_cost'];
                if ($competition['competition_cost_type'] === 'M') {
                    $cost = $competition['competition_cost'] * count($confirm_members);
                }

                $transaction = true;

                if (isset($_POST['deduct'])) {

                    // -- TODO: create pdo transaction deduct balance, add participant table
                    $t = new Teams($db);

                    $previous_balance = $user['member_balance'];
                    $current_balance = $previous_balance - $cost;
                    $new_spent = $user['member_spent'] + $cost;
                    $info = "Participation fee deduction for '".$competition['competition_name']."'";
                    $r = $t->create_team($confirm_members, $competition['competition_id'], $cost, $previous_balance, $current_balance, $new_spent, $info, $m);

                    if ($r['status']) {
                        
                        $_SESSION['message'] = ['type' => 'success', 'data' => 'You are successfully registered for <b>'.$competition['competition_name'].'</b>'];
                        go(URL.'/launchpad/dashboard.php');

                    }

                    array_push($errors, $r['data']);
                }

            } else {
                array_push($errors, "You can only add minimum ".($competition['competition_member_min']-1)." and maximum ".($competition['competition_member_max']-1)." members");
            }

        }


    }

}


?>


<?php if ($transaction): ?>

    <h3>Transaction</h3>

    <p>Total Participation cost - <b><?=$cost?></b></p>

    <p>Your Members:</p>
    <ul>
        <?php foreach ($confirm_members as $member): ?>
            <li><?=$member[1]?></li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>

<h3>Participating in <?=$competition['competition_name']?></h3>

<p>Fees - <b><?=$competition['competition_cost']?> codn <?=($competition['competition_cost_type'] === 'M')?'Per member':'Per team'?></b></p>

<p>Team Limit, Min - <b><?=$competition['competition_member_min']?></b> &nbsp; Max - <b><?=$competition['competition_member_max']?></b></p>

<p>Rules - <?=$competition['competition_rules']?></p>

<p>Timing, Start - <b><?=normal_date($competition['competition_starts'])?></b> &nbsp; Ends - <b><?=normal_date($competition['competition_ends'])?></b></p>

<p>Organiser - <?=$competition['event_organiser_name']?></p>


<?php if (!empty($errors)): ?>
    <p style="color: red"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></p>
<?php endif; ?>

<form action="" method="post">
    <input type="hidden" name="confirm" value="">

    <?php if ($transaction): ?>
        <input type="hidden" name="deduct" value="">
    <?php endif; ?>

    <?php if ($competition['competition_member_max'] > 1): ?>
    <h3>Add members</h3>
    <div id="teammembers">
        <?php for ($n = 1; $n < $competition['competition_member_max']; $n++): ?>
            <input type="email" name="members[]" class="members" placeholder="Member <?=$n+1?> email" value="<?=isset($_POST['members'][$n-1]) ? $_POST['members'][$n-1] : ''?>">
        <?php endfor; ?>
    </div>
    <?php endif; ?>

    <?php if ($transaction): ?>
        
        <?php if ($cost <= $user['member_balance']): ?>
            <button type="submit">Complete!</button>
        <?php else: ?>
            <p>You have insufficient balance to confirm the transaction. <a href="<?=URL?>/launchpad/deposit.php">Deposit</a></p>
        <?php endif; ?>

    <?php else: ?>
        <button type="submit">Confirm</button>
    <?php endif; ?>
</form>

