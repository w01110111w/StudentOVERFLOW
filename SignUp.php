<?php
session_start();
$cookiesAccepted = (isset($_SESSION["CookiesAccepted"]) && $_SESSION["CookiesAccepted"]) || (isset($_COOKIE["CookiesAccepted"]) && $_COOKIE["CookiesAccepted"]);
if (isset($_POST['Username']) && isset($_POST['Email'])) {
    $usrname = strtolower($_POST['Username']);
    $email = strtolower($_POST['Email']);
    // Username as letters and numbers only and check email format as well
    if (ctype_alnum($usrname) && filter_var($email, FILTER_VALIDATE_EMAIL) == $email) {
        try{
            include ("includes/DatabaseConnection.php");
    
            if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {          //For When Someone edits their account
                $sql = 'UPDATE stuovfdb.USER SET
                        Username = :Username,
                        Firstname = :Firstname,
                        Surname = :Surname,
                        Email = :Email,
                        `Password` = :Password,
                        WHERE UserID = :id';
            } else {
                // Check if the username or email was already used
                $sql = 'SELECT Username, Email FROM stuovfdb.USER WHERE Username = :Username OR Email = :Email';
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':Username', $usrname);
                $stmt->bindValue(':Email', $email);
                $hasReturnedRows = $stmt->execute();
                if ($hasReturnedRows && $stmt->rowCount() > 0) {
                    $error = '<p class="error-text">A user already exists with this username or email.</p>';
    
                    ob_start();
                    include('templates/SignUp.html.php');
                    $output = ob_get_clean();
    
                    $output = $error . $output;
                    // $hasModuleData = true;
                } else {
                    $sql = 'INSERT INTO stuovfdb.USER(Username, Firstname, Surname, Email, `Password`)
                            VALUES(:Username, :Firstname, :Surname, :Email, :Password)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':Username', $usrname);
                    $phash = password_hash($_POST['Password'], PASSWORD_DEFAULT);
                    $stmt->bindValue(':Password', $phash);
                    $stmt->bindValue(':Firstname', $_POST['Firstname']);
                    $stmt->bindValue(':Surname', $_POST['Surname']);
                    $stmt->bindValue(':Email', $email);
                    if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
                        $stmt->bindValue(':id', 1); // Add current user id here
                    }
                    $stmt->execute();

                    header("Location: Login.php");
                    die();
    
                    // ob_start();
                    // include('templates/SignUp.html.php');
                    // $output = ob_get_clean();
                }
            }
            
            // header('location: SignUp.php');
        }catch(PDOException $e){
            $title = 'An error has occured';
            $output = 'Database error: ' . $e->getMessage();
        }
    } else {
        ob_start();
        include('templates/SignUp.html.php');
        $output = ob_get_clean();
        $output = '<p class="error-text">Error: Please use only letters and numbers in the username and make sure the email is in the correct format.</p>'
                    . $output;
    }

    $title = 'Sign up to <STUDENT OVERFLOW>';
    // $currentPage = "Account";
    // ob_start();
    // include('templates/SignUp.html.php');
    // $output = ob_get_clean();
} else {
    ob_start();
    include('templates/SignUp.html.php');
    $output = ob_get_clean();
}    

$currentPage = "Account";
include('Layout.php');
?>