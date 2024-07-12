<?php
session_start();
$errorText = null;
if (isset($_GET['mode']) && $_GET['mode'] == 'delete' && isset($_SESSION["UserID"])) {
    try {
        include("includes/DatabaseConnection.php");
    
        // Check that the post was created by the logged in UserID
        $sql = 'DELETE FROM QUESTION WHERE QuestionID = :id AND UserID = :UserID';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->bindValue(':UserID', $_SESSION["UserID"]);
        $stmt->execute();
        
        header('location: MyPosts.php');
    } catch (PDOException $e) {
        $title = 'An error has occured';
        $errorText = '<p style="color: red; padding: 5px 10px">Error: Unable to delete question with id ' . $_GET['id'] . ': ' . $e->getMessage() . "</p>";
    }
}

try {
    include("includes/DatabaseConnection.php");

    if (isset($_SESSION['UserID'])) {
        $sql = 'SELECT * FROM QUESTION WHERE UserID = :UserID ORDER BY QuestionUpdateDate DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':UserID', $_SESSION['UserID']);
        if ($stmt->execute()) {
            $posts = $stmt->fetchAll();
            if (count($posts) > 0) {
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
            } else {
                $errorText = '<p>You have not created any posts. Create your first question by clicking <i>New Post</i>!</p>';
            }
        
            $title = 'My Posts';
            $currentPage = "MyPosts.php";
            
            ob_start();
            include('TEMPLATES/MyPosts.html.php');
            $output = ob_get_clean();
            $output = $errorText . $output;
        } else {
            $output = '<p class="error-text">A database errror occured.</p>';
        }
    } else {
        $output = '<p class="error-text">Please log in first!</p>';
    }
    
    $currentPage = "MyPosts.php";
    include('Layout.php');
} catch (PDOException $e) {
    include('Index.php');
}
