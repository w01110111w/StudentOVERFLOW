<?php
session_start();

$errorText = '';
$template = 'templates/MyAccount.html.php';
$currentPage = "Account";
if (isset($_SESSION["UserID"]) && isset($_SESSION["LoggedIn"]) && $_SESSION['LoggedIn']) {
    try {
        include ("includes/DatabaseConnection.php");

        $userID = $_SESSION["UserID"];
        $sql = "SELECT * FROM USER WHERE UserID = :UserID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':UserID', $userID);
        $stmt->execute();
        $hasReturnedRows = $stmt->execute();
        if ($hasReturnedRows && $stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            if (isset( $_POST['Email'])) {  //The Post value can be of any field as long as a change is noticed
                $email = strtolower($_POST['Email']);
                $sql = 'UPDATE stuovfdb.USER SET
                            Firstname = :Firstname,
                            Surname = :Surname,
                            Email = :Email
                            WHERE UserID = :UserID';
    
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':Firstname', $_POST['Firstname']);
                $stmt->bindValue(':Surname', $_POST['Surname']);
                $stmt->bindValue(':Email', $email);
                $stmt->bindValue(':UserID', $userID);
                $stmt->execute();

                $user['Firstname'] = $_POST['Firstname'];
                $user['Surname'] = $_POST['Surname'];
                $user['Email'] = $email;
            } elseif (isset($_POST['LogOut'])) {
                $_SESSION["LoggedIn"] = false;
                session_destroy();
                $currentPage = "Home";
                $template = 'templates/Home.html.php';
            } elseif (isset($_POST['DeleteAccount'])) {
                $sql = "DELETE FROM USER WHERE UserID = :UserID";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':UserID', $userID);
                $stmt->execute();

                $_SESSION["LoggedIn"] = false;
                session_destroy();
                $currentPage = "Home";
                $template = 'templates/Home.html.php';
            } elseif (isset($_POST["OldPassword"])) {
                $isCorrectPass = password_verify($_POST['OldPassword'], $user['Password']);
                if ($isCorrectPass) {
                    $phash = password_hash($_POST['NewPassword'], PASSWORD_DEFAULT);
                    $sql = 'UPDATE stuovfdb.USER SET
                            `Password` = :Password
                            WHERE UserID = :UserID';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':Password', $phash);
                    $stmt->bindValue(':UserID', $userID);
                    $wasSuccess = $stmt->execute();
                    if ($wasSuccess && $stmt->rowCount() > 0) {
                        $_SESSION["PasswordError"] = '<p>Password was updated.</p>';
                    } else {
                        $_SESSION["PasswordError"] = '<p class="error-text">Could not update password.</p>';
                    }
                } else {
                    $_SESSION["PasswordError"] = '<p class="error-text">Incorrect old password provided.</p>';
                }
            }
        } else {
            $errorText = "Error: An error occurred, please try again.";
        }
    }
    catch (PDOException $e) {
        $errorText = "Error: An error occurred, please try again.";
    }
}

ob_start();
include($template);
$output = $errorText . ob_get_clean();

include('Layout.php');
?>