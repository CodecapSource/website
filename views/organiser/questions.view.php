    <div class="o-page-link">
        <a href="<?=URL?>/organiser/view_event.php?e=<?=$competition['event_id']?>" class="button"><i class="fas fa-arrow-left"></i> Go Back</a>
    </div>

    <h1 class="o-title">Questions</h1>
    <h3 class="o-title-sub"><?=$competition['competition_name']?></h3>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Body</th>
                <th>Points</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
            <tr>
                <td><?=$question['question_title']?></td>
                <td><?=$question['question_body']?></td>
                <td><?=$question['question_points']?></td>
                <td><a href="<?=URL?>/organiser/questions.php?d=<?=$question['question_id']?>" class="button button-orange">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<div class="organiser-right-content">
    <h1 class="o-title">Add Question</h1>

    <?php if (!empty($errors)): ?>
        <div class="message error"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="input input-text">
            <label for="title">Question title</label>
            <input type="text" name="title" id="title" placeholder="Question title" value="<?=$_POST['title']??''?>">
        </div>
        <div class="input input-text">
            <label for="body">Question title</label>
            <textarea name="body" id="body" cols="30" rows="10" placeholder="Question body"><?=$_POST['body']??''?></textarea>
        </div>
        <div class="input input-text">
            <label for="points">Points (score)</label>
            <input type="number" name="points" id="points" placeholder="Points" value="<?=$_POST['points']??''?>">
        </div>

        <div class="input-submit">
            <button type="submit"><i class="fas fa-check" aria-hidden="true"></i> Create</button>
        </div>
    </form>
</div>
