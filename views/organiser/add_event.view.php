<h1 class="o-title">Add Event</h1>

<?php if (!empty($errors)): ?>
    <div class="message error"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></div>
<?php endif; ?>

<?php if ($show): ?>
<form action="" method="post">

    <div class="input input-text">
        <label for="event_name">Event Name</label>
        <input type="text" id="event_name" name="event_name" placeholder="Event Name" value="<?=$_POST['event_name'] ?? ''?>">
    </div>

    <h2 class="o-title-sub">Organiser Information</h2>

    
    <div class="input input-check">
        <input type="checkbox" name="event_already" id="event_already" <?=isset($_POST['event_already']) ? 'checked' : ''?>>
        <label for="event_already">include your information instead</label>
    </div>
    <br>
    <div class="input input-text organiser-name">
        <label for="organiser_name">Organiser Name</label>
        <input type="text" id="organiser_name" name="organiser_name" placeholder="Organiser Name" value="<?=$_POST['organiser_name'] ?? ''?>">
        <br>
    </div>
    <div class="input input-text organiser-about">
        <label for="organiser_about">Organiser About</label>
        <textarea type="text" id="organiser_about" name="organiser_about" placeholder="Organiser About"><?=$_POST['organiser_about'] ?? ''?></textarea>
        <br>
    </div>

    <h2 class="o-title-sub">Event Information</h2>

    
    <div class="input input-text">
        <label for="event_about">Event About</label>
        <textarea type="text" id="event_about" name="event_about" placeholder="Event About"><?=$_POST['event_about'] ?? ''?></textarea>
    </div>
    
    <br>

    <div class="input input-range">
        <label>Event Timing (From TO)</label>
        <div class="input-range-row">
            <input type="datetime-local" name="happen_on" id="happen_on" placeholder="Happening on" value="<?=$_POST['happen_on'] ?? '' ?>">
            <input type="datetime-local" name="ends_on" id="ends_on" placeholder="Ends on" value="<?=$_POST['ends_on'] ?? '' ?>">
        </div>
    </div>
    <br>
    
    <div class="input input-radio">
        <label>Event Location</label>
        <div class="input-radio-row">
            <div class="input-radio-row-box">
                <input type="radio" name="location" id="location_v" value="v" <?=isset($_POST['location']) && $_POST['location'] === 'v' ? 'checked' : ''?>><label for="location_v">virtual (online)</label>
            </div>
            <div class="input-radio-row-box">
                <input type="radio" name="location" id="location_p" value="p" <?=isset($_POST['location']) && $_POST['location'] === 'p' ? 'checked' : ''?>><label for="location_p">physical (onsite)</label>
            </div>
        </div>
    </div>
    <br>
    <div class="input input-select">
        <label for="country">Country</label>
        <select name="country" id="country">
            <?php foreach ($countries as $c): ?>
            <option value="<?=$c['country_iso']?>" <?=(isset($_POST['country'])) ? ($c['country_iso'] === $_POST['country'] ? 'selected' : '') : ($c['country_iso'] === 'PK' ? 'selected' : '')?>><?=$c['country_name']?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    <div class="input input-text organiser-address">
        <label for="address">Phyical address</label>
        <input type="text" name="address" id="address" placeholder="Address" value="<?=$_POST['address'] ?? '' ?>">
        <br>
    </div>

    <div class="input-submit">
        <button type="submit"><i class="fas fa-check" aria-hidden="true"></i> Create</button>
    </div>
</form>
<?php endif; ?>

<script>
    
    function event_already_auto () {
        let or_name = document.querySelector('.organiser-name').classList;
        let or_about = document.querySelector('.organiser-about').classList;

        if (!document.querySelector('#event_already').checked) {
            or_name.remove('remove');
            or_about.remove('remove');
        } else {
            or_name.add('remove');
            or_about.add('remove');
        }
    }
    document.querySelector('#event_already').addEventListener('change', (e) => {
        event_already_auto()
    })
    event_already_auto()

    function location_address_auto () {
        let address = document.querySelector('.organiser-address').classList;

        if (!document.querySelector('#location_p').checked) {
            address.remove('remove');
        } else {
            address.add('remove');
        }
    }
    document.querySelector('#location_p').addEventListener('change', (e) => {
        location_address_auto()
    })
    document.querySelector('#location_v').addEventListener('change', (e) => {
        location_address_auto()
    })
    location_address_auto()

</script>
