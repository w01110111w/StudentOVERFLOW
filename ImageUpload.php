<?php

echo $_POST['QuestionImage'];
echo $_FILES['QuestionImage'];

// Reference: https://stackoverflow.com/a/27213444/5838198
$maxDim = 600;
$file_name = $_FILES['QuestionImage']['tmp_name'];
list($width, $height, $type, $attr) = getimagesize($file_name);
if ($width > $maxDim || $height > $maxDim) {
    $target_filename = $file_name;
    $ratio = $width / $height;
    if ($ratio > 1) {
        $new_width = $maxDim;
        $new_height = $maxDim / $ratio;
    } else {
        $new_width = $maxDim * $ratio;
        $new_height = $maxDim;
    }
    $src = imagecreatefromstring(file_get_contents($file_name));
    $dst = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagedestroy($src);
    imagejpeg($dst, $target_filename); // adjust format as needed
    imagedestroy($dst);
}
    
move_uploaded_file($_FILES['QuestionImage']['tmp_name'],"questions/".$_FILES['QuestionImage']['name']);
