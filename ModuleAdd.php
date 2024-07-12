<?php
session_start();
$errorText = null;
if(isset($_POST["ModuleName"])){
    if (isset($_GET['id'])) {
        echo $_GET['id'];
    }
    try{
        include ("includes/DatabaseConnection.php");

        if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
            $sql = 'UPDATE stuovfdb.Module SET
                    ModuleName = :ModuleName,
                    ModuleDescription = :ModuleDescription
                    WHERE ModuleID = :id';
        } else {
            $sql = 'INSERT INTO stuovfdb.Module(ModuleName, ModuleDescription)
                    VALUES(:ModuleName, :ModuleDescription)';
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':ModuleName', $_POST['ModuleName']);
        $stmt->bindValue(':ModuleDescription', $_POST['ModuleDescription']);
        if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
            $stmt->bindValue(':id', $_GET['id']);
        }
        $stmt->execute();
        header('location: Modules.php');
        die();
    }catch(PDOException $e){
        $Name = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
    }
} else {
    include ("includes/DatabaseConnection.php");

    $hasModuleData = false;
    if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
        $sql = 'SELECT * FROM Module WHERE ModuleID = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $hasReturnedRows = $stmt->execute();
        if ($hasReturnedRows && $stmt->rowCount() == 1) {
            $post = $stmt->fetch();
            $hasModuleData = true;
        } else {
            echo "An error occurred";
        }
        $Name = 'Edit Module';
    } else {
        $Name = 'Add a new Module';
    }
    $currentPage = "ModuleAdd.php";
    ob_start();
    include ('templates/ModuleAdd.html.php');
    $output = ob_get_clean();
}

include ('Layout.php'); 