<script>
function confirmDelete(type, id) {
    var confirmed = confirm(`Are you sure you want to delete this ${type}? All other related records will be also deleted!`);
    if (confirmed) {
        window.location.href = `AdminArea.php?mode=delete${type}&id=` + id;
    }
}
</script>
<div class="admin-area">
    <section class="section posts-section">
        <h2 class="page-title">Posts</h2>
        <?php if(isset($postsError)):?>
            <p> <?=$postsError ?></p>
        <?php endif; ?>
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
                <button class="post-button" onclick="confirmDelete('post', <?php echo $post['QuestionID']; ?>)">Delete</button>
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
        <?php endforeach; ?>
    </section>
    <section class="section modules-section">
        <h2 class="page-title">Modules</h2>
        <?php if(isset($modulesError)):?>
            <p> <?=$modulesError ?></p>
        <?php else: ?>
            <?php foreach($modules as $module): ?>
            <div class="post-entry">
                <div class="post-title">
                    <p>
                    <?=htmlspecialchars($module['ModuleName'],ENT_QUOTES,'UTF-8')?>
                    </P>
                    <button class="post-button" onclick="confirmDelete('module', <?php echo $module['ModuleID']; ?>)">Delete</button>
                </div>
                <div class="post-text">
                    <p>
                    <?=htmlspecialchars($module['ModuleDescription'],ENT_QUOTES,'UTF-8')?>
                    </P>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif;?>
    </section>
    <section class="section users-section">
        <h2 class="page-title">Users</h2>
        <?php if(isset($usersError)):?>
            <p> <?=$usersError ?></p>
        <?php else: ?>
            <?php foreach($users as $user): ?>
            <div class="post-entry">
                <div class="post-author">
                    <div class="post-author-image"><img src="INCLUDES\OIP-removebg-preview.png" /></div><span><?=htmlspecialchars($user['Username'],ENT_QUOTES,'UTF-8')?> (id <?=htmlspecialchars($user['UserID'],ENT_QUOTES,'UTF-8')?>)</span>
                    <?php if ($user['UserID'] == 1): ?>
                        <button class="post-button disabled-button">Delete</button>
                    <?php else: ?>
                        <button class="post-button" onclick="confirmDelete('user', <?php echo $user['UserID']; ?>)">Delete</button>
                    <?php endif;?>	
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif;?>	
    </section>
</div>