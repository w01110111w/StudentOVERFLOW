
<?php if(isset($error)):?>
    <p> <?=$error ?></p>
<?php else: ?>
<script>
function confirmDeletePost(id) {
    var confirmed = confirm("Are you sure you want to delete this post?");
    if (confirmed) {
        window.location.href = 'MyPosts.php?mode=delete&id=' + id;
    }
}

function updatePost(id) {
    window.location.href = 'QuestionAdd.php?mode=edit&id=' + id;
}
</script>
<?php if (isset($_SESSION["QuestionAddError"])) echo $_SESSION["QuestionAddError"]; $_SESSION["QuestionAddError"] = null; ?>
<?php foreach($posts as $post): ?>
<div class="post-entry">
    <div class="post-author">
        <div class="post-author-image"><img src="INCLUDES\OIP-removebg-preview.png" /></div><span><?=htmlspecialchars($usernameTable[$post['UserID']],ENT_QUOTES,'UTF-8')?></span>
        <span class="post-create-date">Posted on <?=htmlspecialchars($post['QuestionCreateDate'],ENT_QUOTES,'UTF-8')?><?php if ($post['QuestionCreateDate'] !== $post['QuestionUpdateDate']): ?>, updated on <?=htmlspecialchars($post['QuestionUpdateDate'],ENT_QUOTES,'UTF-8'); endif;?></span>
    </div>
    <div class="post-title">
        <p>
            <a class="goto-post" href="PostView.php?id=<?= $post['QuestionID'];?>">
                <?=htmlspecialchars($post['QuestionTitle'],ENT_QUOTES,'UTF-8')?>
            </a>
        </P>
        <button class="post-button" onclick="updatePost(<?php echo $post['QuestionID']; ?>)">Edit</button>
        <button class="post-button" onclick="confirmDeletePost(<?php echo $post['QuestionID']; ?>)">Delete</button>
    </div>
    <div class="post-text">
        <p>
            <a class="goto-post" href="PostView.php?id=<?= $post['QuestionID'];?>">
                <?=htmlspecialchars($post['QuestionText'],ENT_QUOTES,'UTF-8')?>
            </a>
        </P>
    </div>
    <div class="post-footer">
        <p>
        Module: <?=htmlspecialchars($moduleTable[$post["ModuleID"]],ENT_QUOTES,'UTF-8')?>
        </P>
    </div>
</div>
<?php endforeach;
endif;
?>	