<div class="o-page-link">
    <a href="<?=URL?>/organiser/view_event.php?e=<?=$competition['event_id']?>" class="button"><i class="fas fa-arrow-left"></i> Go Back</a>
</div>

<h1 class="o-title">Reviewers</h1>
<h3 class="o-title-sub pt-0"><?=$competition['competition_name']?></h3>

<?php if (isset($s_success) && !empty($s_success)): ?>
    <div class="message success"><?=$s_success?></div>
<?php endif; ?>
<?php if (isset($s_error) && !empty($s_error)): ?>
    <div class="message error"><?=$s_error?></div>
<?php endif; ?>

<div class="reviewer-row">
    <div class="reviewer-table">
        <table>
            <thead>
                <tr>
                    <th>Email Address</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviewers as $reviewer): ?>
                <tr>
                    <td><?=$reviewer['reviewer_email']?></td>
                    <td><?=normal_date($reviewer['reviewer_created'])?></td>
                    <td><a href="<?=URL?>/organiser/reviewers.php?c=<?=$reviewer['competition_id']?>&d=<?=$reviewer['reviewer_id']?>" class="button button-orange">Delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="reviewer-form">
        <?php if (!empty($errors)): ?>
            <div class="message error"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></div>
        <?php endif; ?>
        <h3 class="o-title-sub pt-0 pb-0">Add Reviewer</h3>
        <form action="" method="post">
            <div class="input input-text">
                <label for="email">Reviewer email</label>
                <input type="email" name="email" id="email" placeholder="Reviewer Email" value="<?=$_POST['email']??''?>">
            </div>

            <div class="input-submit">
                <button type="submit"><i class="fas fa-check" aria-hidden="true"></i> Create</button>
            </div>
        </form>

    </div>
</div>
