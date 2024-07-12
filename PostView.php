<?php
session_start();
if (!isset($_SESSION["CommentError"])) {
    $_SESSION["CommentError"] = null;
}
$title = 'Post View';
$currentPage = "PostView.php";
try {
    include"includes/DatabaseConnection.php";

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $sql = 'SELECT * FROM QUESTION WHERE QuestionID = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $wasSuccess = $stmt->execute();
        if ($wasSuccess && $stmt->rowCount() > 0) {
            $post = $stmt->fetch();
    
            $sql = 'SELECT * FROM MODULE';
            $modules = $pdo->query($sql);
            $moduleTable = array();
            foreach($modules as $module ):
                $moduleTable[$module["ModuleID"]]=$module["ModuleName"];
            endforeach;
        
            $sql = 'SELECT UserID, Username FROM USER';
            $usernames = $pdo->query($sql);
            $usernameTable = array();
            foreach($usernames as $username ):
                $usernameTable[$username["UserID"]]=$username["Username"];
            endforeach;

            $sql = 'SELECT * FROM COMMENT WHERE QuestionID = :QuestionID ORDER BY CommentCreateDate ASC';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':QuestionID', $_GET['id']);
            $commentsSuccess = $stmt->execute();
            if ($commentsSuccess) {
                $comments = $stmt->fetchAll();
                ob_start();
                include'templates/PostView.html.php';
                $output = ob_get_clean();
            }
            else {
                $_SESSION["CommentError"] .= '<p class="error-text">Comments could not be obtained.</p>'; 
                ob_start();
                include'templates/PostView.html.php';
                $output = ob_get_clean();
            }
        } else {
            $output = '<p class="error-text">Post not found!</p>';
        }
    } else {
        $output = '<p class="error-text">Missing post ID, check URL!</p>';
    }
}catch(PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include 'Layout.php';