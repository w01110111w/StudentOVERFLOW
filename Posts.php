<?php
session_start();
try {
    include"includes/DatabaseConnection.php";

    if (isset($_GET["Search"])) {
        $sql = "SELECT * FROM QUESTION WHERE QuestionTitle LIKE :SearchTitle OR QuestionText LIKE :SearchText ORDER BY QuestionUpdateDate DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':SearchTitle', '%' . $_GET['Search'] . '%');
        $stmt->bindValue(':SearchText', '%' . $_GET['Search'] . '%');
    } else {
        $sql = 'SELECT * FROM QUESTION ORDER BY QuestionUpdateDate DESC';
        $stmt = $pdo->prepare($sql);
    }

    $wasSuccess = $stmt->execute();
    if ($wasSuccess && $stmt->rowCount() > 0) {
        $posts = $stmt->fetchAll();
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
        if (isset($_GET['Search'])) {
            $error = '<p>No posts were found for your search. What about asking that question now?</p>';
        } else {
            $error = '<p>There are no posts, what about creating the first now?</p>';
        }
    }

    ob_start();
    include'templates/Posts.html.php';
    $output = ob_get_clean();
}catch(PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
$title = 'All Posts';
$currentPage = "Posts.php";
include 'Layout.php';