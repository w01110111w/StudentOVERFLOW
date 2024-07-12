
<?php if(isset($error)):?>
    <p> <?=$error ?></p>
<?php else: ?>
<script>
function confirmDeleteModule(id) {
    var confirmed = confirm("Are you sure you want to delete this module?");
    if (confirmed) {
        window.location.href = 'Modules.php?mode=delete&id=' + id;
    }
}

function updateModule(id) {
    window.location.href = 'ModuleAdd.php?mode=edit&id=' + id;
}
</script>
<?php foreach($modules as $module): ?>
<div class="post-entry">
    <div class="post-title">
        <p>
        <?=htmlspecialchars($module['ModuleName'],ENT_QUOTES,'UTF-8')?>
        </P>
        <?php if ($isAdmin) : ?>
            <button class="post-button" onclick="updateModule(<?php echo $module['ModuleID']; ?>)">Edit</button>
        <?php endif; ?>
        <button class="post-button" onclick="confirmDeleteModule(<?php echo $module['ModuleID']; ?>)">Delete</button>
    </div>
    <div class="post-text">
        <p>
        <?=htmlspecialchars($module['ModuleDescription'],ENT_QUOTES,'UTF-8')?>
        </P>
    </div>
</div>
<?php endforeach;
endif;
?>	