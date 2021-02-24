<div class="o-page-link">
    <a href="<?=URL?>/organiser/view_event.php?e=<?=$event['event_id']?>" class="button"><i class="fas fa-arrow-left"></i> Go Back</a>
</div>

<h1 class="o-title">Add competition</h1>
<h3 class="o-title-sub pt-0"><?=$event['event_name']?> - (<small><?=normal_date($event['event_happen_on'])?></small> <b>To</b> <small><?=normal_date($event['event_ends_on'])?></small>)</h3>

<?php if (!empty($errors)): ?>
    <div class="message error"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></div>
<?php endif; ?>

<form action="" method="post">
    <div class="input input-text">  
        <label for="title">Competition Name</label>
        <input type="text" name="name" id="name" value="<?=$_POST['name']??''?>" placeholder="Name">
    </div>

    <div class="inputs-row">
        <div class="input input-text">  
            <label for="team_min">Team Min.</label>
            <input type="number" name="team_min" id="team_min" value="<?=$_POST['team_min']??''?>" placeholder="Team Min">
        </div>
        <div class="input input-text">  
            <label for="team_max">Team Max.</label>
            <input type="number" name="team_max" id="team_max" value="<?=$_POST['team_max']??''?>" placeholder="Team Max">
        </div>
    </div>

    <div class="inputs-row">
        <div class="input input-text">  
            <label for="cost">Participation Cost</label>
            <input type="number" name="cost" id="cost" value="<?=$_POST['cost']??''?>" placeholder="Participation Cost">
        </div>
        <div class="input input-select">  
            <label for="cost_type">Cost Type</label>
            <select name="cost_type" id="cost_type">
                <option value="" disabled <?=!isset($_POST['cost_type']) ? 'selected' : ''?>></option>
                <option value="M" <?=isset($_POST['cost_type']) && $_POST['cost_type'] === 'M' ? 'selected' : ''?>>Per Member</option>
                <option value="T" <?=isset($_POST['cost_type']) && $_POST['cost_type'] === 'T' ? 'selected' : ''?>>Per Team</option>
            </select>
        </div>
    </div>

    <div class="input input-range">
        <label>Competition Timing (From TO) - <i>within event timing</i></label>
        <div class="input-range-row">
            <input type="datetime-local" name="starts_on" id="starts_on" placeholder="Starts on" value="<?=$_POST['starts_on'] ?? '' ?>">
            <input type="datetime-local" name="ends_on" id="ends_on" placeholder="Ends on" value="<?=$_POST['ends_on'] ?? '' ?>">
        </div>
    </div>

    <div class="input input-text">  
        <label for="about">About Competition</label>
        <textarea name="about" id="about" cols="30" rows="10" placeholder="about competition"><?=$_POST['about'] ?? '' ?></textarea>
    </div>

    <div class="input input-text">  
        <label for="rules">Competition Rules</label>
        <textarea name="rules" id="rules" cols="30" rows="10" placeholder="competition rules"><?=$_POST['rules'] ?? '' ?></textarea>
    </div>

    
    <div class="input-submit">
        <button type="submit"><i class="fas fa-check" aria-hidden="true"></i> Add</button>
    </div>
</form>

