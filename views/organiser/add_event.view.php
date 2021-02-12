<?php if (!empty($errors)): ?>
    <p style="color: red"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></p>
<?php endif; ?>

<?php if ($show): ?>
<form action="" method="post">
    <input type="text" name="event_name" id="event_name" placeholder="Event Name" value="<?=$_POST['event_name'] ?? ''?>">

    <br>

    <h2>Organiser Information</h2>

    <input type="checkbox" name="event_already" id="event_already" <?=isset($_POST['event_already']) ? 'checked' : ''?>>
    <label for="event_already">include your information instead</label>

    <br>

    <input type="text" name="organiser_name" id="organiser_name" placeholder="Organiser Name" value="<?=$_POST['organiser_name'] ?? ''?>">
    <br>
    <textarea name="organiser_about" id="organiser_about" placeholder="Organiser About"><?=$_POST['organiser_about'] ?? ''?></textarea>

    <br>

    <h2>Event Information</h2>
    
    <textarea name="event_about" id="event_about" placeholder="Event About"><?=$_POST['event_about'] ?? ''?></textarea>
    <br>
    <input type="datetime-local" name="happen_on" id="happen_on" placeholder="Happening on" value="<?=$_POST['happen_on'] ?? '' ?>">
    <input type="datetime-local" name="ends_on" id="ends_on" placeholder="Ends on" value="<?=$_POST['ends_on'] ?? '' ?>">
    <br>

    <label>Event Location</label>
    <input type="radio" name="location" id="location_v" value="v" <?=isset($_POST['location']) && $_POST['location'] === 'v' ? 'checked' : ''?>><label for="location_v">virtual (online)</label>
    <input type="radio" name="location" id="location_p" value="p" <?=isset($_POST['location']) && $_POST['location'] === 'p' ? 'checked' : ''?>><label for="location_p">physical (onsite)</label>

    <br>

    <select name="country" id="country">
        <?php foreach ($countries as $c): ?>
        <option value="<?=$c['country_iso']?>" <?=(isset($_POST['country'])) ? ($c['country_iso'] === $_POST['country'] ? 'selected' : '') : ($c['country_iso'] === 'PK' ? 'selected' : '')?>><?=$c['country_name']?></option>
        <?php endforeach; ?>
    </select>

    <input type="text" name="address" id="address" placeholder="Address" value="<?=$_POST['address'] ?? '' ?>">

    <br>
    <br>
    
    <button type="submit">Create</button>
</form>
<?php endif; ?>
