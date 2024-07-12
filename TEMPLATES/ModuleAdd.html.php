<form action="" method="post">
    <label for="ModuleName"><b> * Type module name here:</b></label>
    <input type="text" name="ModuleName" value="<?php echo $hasModuleData ? $post['ModuleName'] : ''?>" cols="80" rows="10" required minlength="3" maxlength="50"></textarea>
    <label for="ModuleDescription"><b> * Add the module description here:</b></label>
    <textarea name="ModuleDescription" cols="40" rows="3" required>
        <?php echo $hasModuleData ? $post['ModuleDescription'] : ''?>
    </textarea>
    <input type="submit" name="submit" value="<?php echo $hasModuleData ? 'Edit' : 'Add' ?>" style="background-color: yellow">
</form>