<?php
session_start();
$errorText = null;


if (! (isset($_SESSION["UserID"]) && isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]))  {
    $output = '<p>>Be me</p>
    <p>>Be a first time user</p>
    <p>>Try to make a post</p>
    <p>>Realise I haven\'t even <a href="Login.php">signed in</a> yet...</p>';
    $currentPage = 'QuestionAdd.php';
    include('Layout.php');
    die();
}

if(isset($_POST["QuestionText"])){
    try{
        include ("includes/DatabaseConnection.php");

        if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
            $sql = 'UPDATE stuovfdb.QUESTION SET
                    QuestionTitle = :QuestionTitle,
                    QuestionText = :QuestionText,
                    QuestionUpdateDate = NOW(),
                    ModuleID = :ModuleID
                    WHERE QuestionID = :id';
        } else {
            $sql = 'INSERT INTO stuovfdb.QUESTION(QuestionTitle, QuestionText, QuestionCreateDate, QuestionUpdateDate, UserID, ModuleID)
                    VALUES(:QuestionTitle, :QuestionText, NOW(), NOW(), :UserID, :ModuleID)';
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':QuestionTitle', $_POST['QuestionTitle']);
        $stmt->bindValue(':QuestionText', $_POST['QuestionText']);
        $stmt->bindValue(':ModuleID', $_POST['ModuleID']);
        if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
            $stmt->bindValue(':id', $_GET['id']);
        } else {
            $stmt->bindValue(':UserID', $_SESSION['UserID']);
        }
        $wasSuccess = $stmt->execute();
        if ($wasSuccess) {
            $questionID = null;
            if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
                $questionID = $_GET['id'];
            } else {
                $questionID = $pdo->lastInsertId();	
            }

            // echo "QuestionID is $questionID";

            # Check if user submitted file
            if(file_exists($_FILES['QuestionImage']['tmp_name']) && is_uploaded_file($_FILES['QuestionImage']['tmp_name'])) {
                // echo "Uploading question image";
                # Check file size is not exceeded
                if($_FILES['QuestionImage']['size'] <= 3145728) { // 3 MB
                    // echo "File size is right";
                    # Check the file is an actual image and the right dimensions. If not the right dimensions, resize.
                    // Reference: https://stackoverflow.com/a/27213444/5838198
                    $maxDim = 600;
                    $imageFilename = $_FILES['QuestionImage']['tmp_name'];
                    try {
                        list($width, $height, $type, $attr) = getimagesize($imageFilename);
                        // echo "It's an image";
                        $wasSuccessUpload = move_uploaded_file($imageFilename, "PostImages/$questionID.png");
                        // echo "Uploaded file";
                        if (! $wasSuccessUpload )  {
                            $_SESSION["QuestionAddError"] = '<p class="error-text">Your post was created but the image could not be uploaded. Please go to and edit the post to retry!</p>';
                        }
                    } catch (Exception $e) {
                        $_SESSION["QuestionAddError"] = '<p class="error-text">Please make sure you are uploading an image and retry by going to Edit the post.</p>';
                    }
                } else {
                    $_SESSION["QuestionAddError"] = '<p class="error-text">The chosen image was too big, please go to Edit the post and choose another image that is less than 3 MB.</p>';
                }	
            }
        }

        // ob_start();
        // include ('templates/QuestionAdd.html.php');
        // $output = ob_get_clean();
        header("Location: MyPosts.php");
        die();
    }catch(PDOException $e){
        $title = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
    }
} else {
    include ("includes/DatabaseConnection.php");

    // Get modules
    $sql = 'SELECT * FROM MODULE';
    $modules = $pdo->query($sql);

    $hasPostData = false;
    if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
        $sql = 'SELECT * FROM QUESTION WHERE UserID = :UserID AND QuestionID = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->bindValue(':UserID', $_SESSION['UserID']);
        $hasReturnedRows = $stmt->execute();
        if ($hasReturnedRows && $stmt->rowCount() == 1) {
            $post = $stmt->fetch();
            $hasPostData = true;
        } else {
            $errorText = '<p class="error-text">Invalid request, was this post previously deleted?</p>';
        }
        $title = 'Edit my question';
    } else {
        $title = 'Add a new question';
    }
    $currentPage = "QuestionAdd.php";
    ob_start();
    include ('templates/QuestionAdd.html.php');
    $output = ob_get_clean();
    if (isset($errorText)) {
        $output = $errorText . $output;
    }
}

include ('Layout.php'); 