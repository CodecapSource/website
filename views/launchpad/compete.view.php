
<div class="page">
    <div class="page-content">
        
        
        <div class="compete">
            <form method="POST" action="" class="compete-l">
                <?php if (isset($s_success) && !empty($s_success)): ?>
                    <div class="message success"><?=$s_success?></div>
                <?php endif; ?>
                <?php if (isset($s_error) && !empty($s_error)): ?>
                    <div class="message error"><?=$s_error?></div>
                <?php endif; ?>
                <input type="hidden" name="question" value="<?=$submissions[0]['question_id']?>">
                <input type="hidden" name="submission" value="<?=$submissions[0]['submission_id']?>">
                <input type="hidden" name="team" value="<?=$submissions[0]['submission_team_id']?>">
                <div class="compete-l-top">
                    <div class="compete-l-top-left">
                        <h3>Ongoing Competition</h3>
                        <h2><?=$competition['competition_name']?></h2>
                    </div>

                    <div class="compete-l-top-right">
                        <div class="compete-l-top-right-box">
                            <h3>Started at</h3>
                            <p><?=normal_date($competition['competition_starts'])?></p>
                        </div>
                        <div class="compete-l-top-right-box">
                            <h3>Ending at</h3>
                            <p><?=normal_date($competition['competition_ends'])?></p>
                        </div>
                    </div>
                    <div class="compete-l-top-button">
                        <button type="submit" class="button button-green">Save</button>
                    </div>
                </div>

                <div class="compete-l-code">
                    <textarea id="code" name="code">
<?php if (!$default_code):?>
<?=$_POST['code']??$submissions[0]['submission_text']?>
<?php else: ?>
# write your code here

def hello ():
    return 'World'

print(hello())
<?php endif; ?>
</textarea>
                </div>
                <div class="compete-l-output">
                    <div class="compete-l-output-top">
                        <button type="button" class="button button-orange" id="run">Run <i class="fas fa-play"></i></button>
                    </div>
                    <div class="compete-l-output-content">
                        <h3>Output</h3>
                        <p id="output"></p>
                    </div>
                </div>
            </form>
            <div class="compete-r">
                <div class="compete-r-box">
                    <h3>Question</h3>
                    <p><?=$submissions[0]['question_title']?></p>
                </div>
                <div class="compete-r-box">
                    <h3>Problem Statement</h3>
                    <p><?=$submissions[0]['question_body']?></p>
                </div>
                <?php if(count($participation['members']) > 0): ?>
                <div class="compete-r-members">
                    <h3>Team Members</h3>
                    <div class="compete-r-members-row">
                        <?php foreach($participation['members'] as $member): ?>
                        <div class="compete-r-members-row-box">
                            <img src="<?=URL?>/assets/images/avatar.png">
                            <h4><?=$member['member_name']?></h4>
                        </div>
                        <?php endforeach?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>


<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>

<script>
    var editor = CodeMirror.fromTextArea(document.querySelector('#code'), {
        theme: 'material-ocean',
        lineNumbers: true,
        mode: {
            name: 'python',
            version: 3,
            singleLineStringErrors: false
        },
        indentUnit: 4,
        matchBrackets: true,
        styleActiveLine: true
    });

    function show_output (paragraph) {
        $('#output').html(paragraph);
        $('.compete-l-output').removeClass('loading');
    }

    $('#run').on('click', (e) => {

        $('.compete-l-output').addClass('loading');
        $.ajax('<?=$compilation_api?>', {
            method: "POST",
            data: {code: editor.getValue()},
            success: function (data) {
                if (data.status) {
                    data = data.data.replace(/\n/g, "<br />");
                    show_output(data);
                } else {
                    show_output('<i class="error">Error while compiling</i>');
                }
            }, error: function (data) {
                show_output('<i class="error">Unable to reach the API</i>');
            }
        });

    })
    
</script>
