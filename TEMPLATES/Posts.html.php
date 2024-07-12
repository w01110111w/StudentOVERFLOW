<div class="search-area">
    <form action="">
        <label>
            <input class="search-bar" type="text" name="Search" value="<?= isset($_GET['Search']) ? $_GET['Search'] : ''; ?>" placeholder="Search in post title or text..." cols="80" rows="10" minlength="2" maxlength="50">
        </label>
        <button type="submit">
            <span><img src="INCLUDES/search.png"></span>
        </button>
    </form>
</div>
<?php if(isset($error)):?>
    <p> <?=$error ?></p>
<?php else:
foreach($posts as $post): ?>
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
