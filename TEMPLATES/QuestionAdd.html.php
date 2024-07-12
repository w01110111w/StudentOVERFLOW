<!--TO D0: ADD IMAGES DATABASE CONNECTION AND MAKE QUESIONIMAGE WORK,   -->
<form action="" method="post"  enctype="multipart/form-data">
    <p>Image upload works only on localhost (insufficient rights in I Drive).</p>
    <label for="QuestionTitle"><b> * Type your question title here:</b></label>
    <input type="text" name="QuestionTitle" value="<?php echo $hasPostData ? $post['QuestionTitle'] : ''?>" cols="80" rows="10" required minlength="15" maxlength="160"></textarea>
    <label for="QuestionText"><b> * Add the question details here:</b></label>
    <textarea name="QuestionText" cols="40" rows="3" required>
        <?php echo $hasPostData ? $post['QuestionText'] : ''?>
    </textarea>
    <label for="QuestionImage"><b>Add an optional image:</b></label>
    <input type="file" accept="image/*" id="QuestionImage" name="QuestionImage">
    <div>
    <label for="Module"><b> * Choose the module related to your question:</b></label>
    <select name="ModuleID">
            <?php foreach($modules as $module): ?>
                <option <?php if (isset($post["ModuleID"]) && $module["ModuleID"] == $post["ModuleID"]) echo "selected"; ?> value="<?php echo $module["ModuleID"]; ?>"><?php echo $module["ModuleName"];?></option>  
            <?php endforeach;?>
    </select>
    </div>  
    <input type="submit" name="submit" value="<?php echo $hasPostData ? 'Edit' : 'Add' ?>" style="background-color: yellow">
</form>