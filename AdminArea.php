<?php
session_start();
$errorText = null;
$postsError = null;
$modulesError = null;
$usersError = null;
$navbarClass = "grey-navbar";
$mainClass = "large-main";

if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"] && isset($_SESSION["IsAdmin"]) && $_SESSION["IsAdmin"]) {
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'deletepost') {
            try {
                include("includes/DatabaseConnection.php");
                echo "deleting post";
                // Admins can delete any post
                $sql = 'DELETE FROM QUESTION WHERE QuestionID = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', $_GET['id']);
                $stmt->execute();
                
                header('location: AdminArea.php');
                die();
            } catch (PDOException $e) {
                $title = 'An error has occured';
                $postsError = '<p style="color: red; padding: 5px 10px">Error: Unable to delete post with id ' . $_GET['id'] . ': ' . $e->getMessage() . "</p>";
            }
        } elseif ($_GET['mode'] == 'deletemodule') {
            try {
                include("includes/DatabaseConnection.php");

                // Admins can delete any module
                $sql = 'DELETE FROM MODULE WHERE ModuleID = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', $_GET['id']);
                $stmt->execute();
                
                header('location: AdminArea.php');
                die();
            } catch (PDOException $e) {
                $title = 'An error has occured';
                $modulesError = '<p style="color: red; padding: 5px 10px">Error: Unable to delete module with id ' . $_GET['id'] . ': ' . $e->getMessage() . "</p>";
            }
        } elseif ($_GET['mode'] == 'deleteuser') {
            try {
                include("includes/DatabaseConnection.php");

                // Admins can delete any user
                $sql = 'DELETE FROM USER WHERE UserID = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', $_GET['id']);
                $stmt->execute();
                
                header('location: AdminArea.php');
                die();
            } catch (PDOException $e) {
                $title = 'An error has occured';
                $usersError = '<p style="color: red; padding: 5px 10px">Error: Unable to delete user with id ' . $_GET['id'] . ': ' . $e->getMessage() . "</p>";
            }
        }
    }
    
    try {
        include("includes/DatabaseConnection.php");
    
        $sql = 'SELECT * FROM QUESTION ORDER BY QuestionUpdateDate DESC';
        $posts = $pdo->query($sql);
        // if (isset($posts) && count($posts) == 0) {
        //     $postsError = '<p>There are no posts.</p>';
        // }

        $sql = 'SELECT * FROM MODULE';
        $modules = $pdo->query($sql);
        $modulesCopy = $pdo->query($sql);
        $moduleTable = array();
        foreach($modulesCopy as $module):
            $moduleTable[$module["ModuleID"]]=$module["ModuleName"];
        endforeach;

        $sql = 'SELECT UserID, Username FROM USER';
        $users = $pdo->query($sql);

        $users = $pdo->query($sql);
        $usersCopy = $pdo->query($sql);
        $usernameTable = array();
        foreach($usersCopy as $username):
            $usernameTable[$username["UserID"]]=$username["Username"];
        endforeach;
    
        $title = 'Admin Area';
        $currentPage = "AdminArea.php";
        
        ob_start();
        include('TEMPLATES/AdminArea.html.php');
        $output = ob_get_clean();
        
        include('Layout.php');
    } catch (PDOException $e) {
        include('Index.php');
    }
    
} else {
    $errorText = '<p class="error-text">You must be logged in as an admin to see this page.</p>';
    $output = $errorText;
    $currentPage = "AdminArea.php";
    include("Layout.php");
}