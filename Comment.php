<?php
session_start();

if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
    include ("includes/DatabaseConnection.php");

    $userID = $_SESSION["UserID"];

    if (isset($_GET["mode"]) && $_GET["mode"] == "delete" && isset($_GET['id']) && is_numeric($_GET['id'])) {
        if ($_SESSION["IsAdmin"]) {
            $sql = "DELETE FROM COMMENT WHERE CommentID = :CommentID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':CommentID', $_GET['id']);
        } else {
            $sql = "DELETE FROM COMMENT WHERE CommentID = :CommentID AND UserID = :UserID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':CommentID', $_GET['id']);
            $stmt->bindValue(':UserID', $_SESSION['UserID']);
        }
        $wasSuccess = $stmt->execute();
        if (!$wasSuccess || $stmt->rowCount() == 0) {
            $_SESSION["CommentError"] = '<p class="error-text">Comment could not be deleted.</p>';
        }

        header('Location: PostView.php?id=' . $_GET["questionID"]);
        die();
    } elseif (isset($_POST["QuestionID"])) {
        if (isset($_POST["CommentText"]) && !ctype_space($_POST["CommentText"]) && $_POST["CommentText"] !== '') {
            $sql = 'INSERT INTO COMMENT(CommentText, UserID, QuestionID) VALUES(:CommentText, :UserID, :QuestionID)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':CommentText', $_POST["CommentText"]);
            $stmt->bindValue(':UserID', $_SESSION['UserID']);
            $stmt->bindValue(':QuestionID', $_POST['QuestionID']);
            $wasSuccess = $stmt->execute();
            if (!$wasSuccess) {
                $_SESSION["CommentError"] = '<p class="error-text">There was a problem adding your comment, please try again.</p>';
            }
        } else {
            $_SESSION["CommentError"] = '<p class="error-text">Comment text cannot be empty.</p>';
        }
        header('Location: PostView.php?id=' . $_POST["QuestionID"]);
        die();
    } else {
        $currentPage = "MyPosts.php";
        $output = '<p class="error-text">Question ID was not set!</p>';
        include("Layout.php");
    }
} else {
    $currentPage = "MyPosts.php";
    $output = '<p class="error-text">Log in first to post a comment!</p>';
    include("Layout.php");
}
// ob_start();
// header('Location: PostView.php?id=' . $_POST["QuestionID"]);
// die();
// $output = ob_get_clean();
// $currentPage = "PostView.php";
// include("Layout.php");