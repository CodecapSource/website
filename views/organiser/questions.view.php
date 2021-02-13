<h1>Questions in <?=$competition['competition_name']?></h1>

<a href="<?=URL?>/organiser/view_event.php?=<?=$competition['competition_event_id']?>">Go back</a>

<h3>Add Question</h3>

<?php if (!empty($errors)): ?>
    <p style="color: red"><?php foreach($errors as $error): ?> <?=$error . '. '?> <?php endforeach; ?></p>
<?php endif; ?>

<form action="" method="post">
    <input type="text" name="title" id="title" placeholder="Question title" value="<?=$_POST['title']??''?>">
    <textarea name="body" cols="30" rows="10" placeholder="Question body"><?=$_POST['body']??''?></textarea>
    <input type="number" name="points" id="points" placeholder="Points" value="<?=$_POST['points']??''?>">
    <button type="submit">Add</button>
</form>

<hr>

<h3>Questions</h3>

<table border="1">
    <?php foreach ($questions as $question): ?>
    <tr>
        <td><?=$question['question_title']?></td>
        <td><?=$question['question_body']?></td>
        <td><?=$question['question_points']?></td>
        <td><a href="<?=URL?>/organiser/questions.php?d=<?=$question['question_id']?>">Delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>
