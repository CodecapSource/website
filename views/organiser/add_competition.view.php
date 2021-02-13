<h2>Add competition to - <?=$event['event_name']?> - <?=normal_date($event['event_happen_on'])?> <b>To</b> <?=normal_date($event['event_ends_on'])?></h2>

<?php if (!empty($errors)): ?>
    <p style="color: red"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></p>
<?php endif; ?>

<form action="" method="post">
    <input type="text" name="name" id="name" value="<?=$_POST['name']??''?>" placeholder="Name">
    <br>
    <input type="number" name="team_min" id="team_min" value="<?=$_POST['team_min']??''?>" placeholder="Team Min">
    <input type="number" name="team_max" id="team_max" value="<?=$_POST['team_max']??''?>" placeholder="Team Max">
    <br>
    <input type="number" name="cost" id="cost" value="<?=$_POST['cost']??''?>" placeholder="Participation Cost">
    <select name="cost_type" id="cost_type">
        <option value="" disabled <?=!isset($_POST['cost_type']) ? 'selected' : ''?>>Cost Type</option>
        <option value="M" <?=isset($_POST['cost_type']) && $_POST['cost_type'] === 'M' ? 'selected' : ''?>>Per Member</option>
        <option value="T" <?=isset($_POST['cost_type']) && $_POST['cost_type'] === 'T' ? 'selected' : ''?>>Per Team</option>
    </select>
    <br>
    <input type="datetime-local" name="starts_on" id="starts_on" placeholder="Starts on" value="<?=$_POST['starts_on'] ?? '' ?>">
    <input type="datetime-local" name="ends_on" id="ends_on" placeholder="Ends on" value="<?=$_POST['ends_on'] ?? '' ?>">
    <br>
    <textarea name="about" id="about" cols="30" rows="10" placeholder="about competition"></textarea>
    <br>
    <textarea name="rules" id="rules" cols="30" rows="10" placeholder="rules"></textarea>
    <br>
    <button type="submit">Add</button>
</form>

