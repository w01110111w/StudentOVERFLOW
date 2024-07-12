<?php

session_start();
$errorText = null;
$isAdmin = (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin']);
if (isset($_GET['mode']) && $_GET['mode'] == 'delete') {
    try {
        include("includes/DatabaseConnection.php");
    
        $sql = 'DELETE FROM MODULE WHERE ModuleID = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
        
        header('location: Modules.php');
    } catch (PDOException $e) {
        $title = 'An error has occured';
        $errorText = '<p style="color: red; padding: 5px 10px">Error: Unable to delete module with id ' . $_GET['id'] . ': ' . $e->getMessage() . "</p>";
    }
}

try {
    include("includes/DatabaseConnection.php");

    $sql = 'SELECT * FROM MODULE';
    $modules = $pdo->query($sql);
    $title = 'Modules';
    $currentPage = "Modules.php";
    
    ob_start();
    include('TEMPLATES/Modules.html.php');
    $output = ob_get_clean();
    $output = $errorText . $output;
    $currentPage = "Modules.php";
    include('Layout.php');
} catch (PDOException $e) {
    include('Index.php');
}
