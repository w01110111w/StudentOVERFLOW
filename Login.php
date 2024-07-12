<?php
session_start();
$title = 'Log In to <STUDENT OVERFLOW>';
$cookiesAccepted = (isset($_SESSION["CookiesAccepted"]) && $_SESSION["CookiesAccepted"]) || (isset($_COOKIE["CookiesAccepted"]) && $_COOKIE["CookiesAccepted"]);
if (isset($_POST['UsernameOrEmail'])) {
    include ("includes/DatabaseConnection.php");
    $usernameOrEmail = null;
    if (filter_var($_POST['UsernameOrEmail'], FILTER_VALIDATE_EMAIL) == $_POST['UsernameOrEmail']) {
        // User used an email to log in
        $usernameOrEmail = 'Email';
    } else if (ctype_alnum($_POST['UsernameOrEmail'])) {
        // User used an username to log in
        $usernameOrEmail = 'Username';
    }
    if (isset($usernameOrEmail)) {
        $sql = "SELECT UserID, Username, Firstname, Surname, Email, `Password`, IsAdmin FROM USER WHERE $usernameOrEmail = :UsernameOrEmail";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':UsernameOrEmail', strtolower($_POST['UsernameOrEmail']));
        $hasReturnedRows = $stmt->execute();
        $isCorrectPass = false;
        $hasFoundUser = ($hasReturnedRows && $stmt->rowCount() == 1);
        if ($hasFoundUser) {
            $userFromDb = $stmt->fetch();
            $isCorrectPass = password_verify($_POST['Password'], $userFromDb['Password']);
            if ($isCorrectPass) {
                $_SESSION['LoggedIn'] = true;
                $_SESSION['GreetingName'] = $userFromDb['Firstname'];
                $_SESSION['UserID'] = $userFromDb['UserID'];
                $_SESSION['IsAdmin'] = (bool)$userFromDb['IsAdmin'];

                header('Location: MyPosts.php');
                die();
            }
        }
        if (!$hasFoundUser || !$isCorrectPass) {
            ob_start();
            include('templates/Login.html.php');
            $output = ob_get_clean();
            $output = '<p class="error-text">Error: Incorrect credentials, please try again.</p>' . $output;
        }
    } else {
        // Wrong format provided for email/username 
        ob_start();
        include('templates/Login.html.php');
        $output = ob_get_clean();
        $output = '<p class="error-text">Error: Please provide a valid username or email.</p>' . $output;
    }
} else {
    ob_start();
    include('templates/Login.html.php');
    $output = ob_get_clean();
}    

$currentPage = "Account";
include('Layout.php');
?>