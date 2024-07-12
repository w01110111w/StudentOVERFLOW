<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PLUGINS/PHPMailer-6.9.1/src/PHPMailer.php';
require 'PLUGINS/PHPMailer-6.9.1/src/SMTP.php';
require 'PLUGINS/PHPMailer-6.9.1/src/Exception.php';

$name = '';
if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] && isset($_SESSION['UserID'])) {
    include"includes/DatabaseConnection.php";

    $sql = 'SELECT Firstname, Surname, Username FROM USER WHERE UserID = :UserID';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':UserID', $_SESSION['UserID']);
    $returnedSuccess = $stmt->execute();
    if ($returnedSuccess && $stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        $name = "{$user["Firstname"]} {$user['Surname']} ({$user['Username']})";
    }
}

$extraText = '';
if (isset($_POST['Message'])) {
    try {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'firoozbakht.yalda@gmail.com';                     //SMTP username
        $mail->Password   = 'giia vvdt geoy krpa';                               //Temporary app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
    
        $mail->setFrom('firoozbakht.yalda@gmail.com', 'Student Overflow NoReply');
        $mail->addAddress('firoozbakht.yalda@gmail.com', 'Yalda Firoozbakht');
    
        $mail->isHTML(false);
        $mail->Subject = "{$_POST['Nickname']} via Student Overflow - {$_POST['Topic']} - {$_POST['Subject']}";
        $mail->Body    = $_POST['Message'];
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        $extraText = '<p style="text-align: center">Your message has been sent!</p>';
        // echo 'Message has been sent';
    } catch (Exception $e) {
        $extraText = '<p style="text-align: center" class="error-text">Message could not be sent! ' . $mail->ErrorInfo . '</p>';
    }
}

ob_start();
include('TEMPLATES/Contact.html.php');
$output = $extraText . ob_get_clean();
$currentPage = 'Contact.php';
include('Layout.php');
?>