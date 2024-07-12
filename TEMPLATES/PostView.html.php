
<?php if(isset($error)):?>
    <p> <?=$error ?></p>
<?php else: ?>
<script>
function confirmDeleteComment(id, questionID) {
    var confirmed = confirm("Are you sure you want to delete this comment?");
    if (confirmed) {
        window.location.href = `Comment.php?mode=delete&id=${id}&questionID=${questionID}`;
    }
}
</script>
<div class="postview">
    <div class="post-entry">
        <div class="post-author">
            <div class="post-author-image"><img src="INCLUDES\OIP-removebg-preview.png" /></div><span><?=htmlspecialchars($usernameTable[$post['UserID']],ENT_QUOTES,'UTF-8')?></span>
            <span class="post-create-date">Posted on <?=htmlspecialchars($post['QuestionCreateDate'],ENT_QUOTES,'UTF-8')?><?php if ($post['QuestionCreateDate'] !== $post['QuestionUpdateDate']): ?>, updated on <?=htmlspecialchars($post['QuestionUpdateDate'],ENT_QUOTES,'UTF-8'); endif;?></span>
        </div>
        <div class="post-title">
            <p>
            <?=htmlspecialchars($post['QuestionTitle'],ENT_QUOTES,'UTF-8')?>
            </P>
            <!-- <button class="post-button" onclick="updatePost(<?php echo $post['QuestionID']; ?>)">Edit</button>
            <button class="post-button" onclick="confirmDeletePost(<?php echo $post['QuestionID']; ?>)">Delete</button> -->
        </div>
        <div class="post-text">
            <p>
            <?=nl2br(htmlspecialchars($post['QuestionText'],ENT_QUOTES,'UTF-8'))?>
            </P>
        </div>
        <?php if (file_exists("PostImages/{$post['QuestionID']}.png")): ?>
            <div class="post-image">
                <a href="PostImages/<?= $post['QuestionID']; ?>.png" target="_blank">
                    <img src="PostImages/<?= $post['QuestionID']; ?>.png" />
                </a>
            </div>
        <?php endif; ?>
        <div class="post-footer">
            <p>
            Module: <?=htmlspecialchars($moduleTable[$post["ModuleID"]],ENT_QUOTES,'UTF-8')?>
            </P>
        </div>
    </div>
    <div class="comments">
        <div class="comment-icon">
            <img src="INCLUDES/messageicon.png">
        </div>
        <?php if(isset($_SESSION["CommentError"])):?>
            <div style="text-align: right"> <?=$_SESSION["CommentError"] ?> </div>
        <?php endif; $_SESSION["CommentError"] = null; ?>
        <?php foreach ($comments as $comment): ?>
            <div class="post-comment">
                <div class="comment-title">
                    <div class="post-author-image"><img src="INCLUDES\OIP-removebg-preview.png" /></div><span><?=htmlspecialchars($usernameTable[$comment['UserID']],ENT_QUOTES,'UTF-8')?></span>
                    <span class="comment-date">on <?=htmlspecialchars($comment['CommentCreateDate'],ENT_QUOTES,'UTF-8')?></span>
                    <?php if (isset($_SESSION["UserID"])): ?>
                        <?php if ($_SESSION["UserID"] == $comment["UserID"]): ?>
                            <button class="post-button" onclick="confirmDeleteComment(<?= $comment['CommentID']; ?>, <?= $comment['QuestionID']; ?>)">Delete</button>
                        <?php elseif ($_SESSION["IsAdmin"]): ?>
                            <button class="post-button button-grey" onclick="confirmDeleteComment(<?php echo $comment['CommentID']; ?>, <?= $comment['QuestionID']; ?>)">Delete</button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="comment-text">
                    <p>
                    <?=nl2br(htmlspecialchars($comment["CommentText"],ENT_QUOTES,'UTF-8'))?>
                    </P>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="new-comment">
            <?php if (isset($_SESSION["UserID"])): ?>
                <form class="comment-form" action="Comment.php" method="post">
                    <textarea required placeholder="Type your comment here..." class="comment-text" name="CommentText"><?= isset($_POST["CommentText"]) ? htmlspecialchars($_POST["CommentText"],ENT_QUOTES,'') : ""?></textarea>
                        <div class="reply-button-section">
                            <span class="posting-as">You are commenting as <b><?= $usernameTable[$_SESSION["UserID"]] ?></b>.</span>
                            <input type="hidden" name="QuestionID" value="<?= $post["QuestionID"] ?>">
                            <button class="reply-button">Reply</button>
                        </div>
                    </form>
            <?php else: ?>
                <p><i><a href="Login.php">Log in</a> to comment.</i></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif;
?>	