<!-- database connection -->

<?php
    $servername = "localhost";
    $username = "root";     //this both needs to be changed based on the source used for accessing the data
    $password = "";     

    try {
        $pdo = new PDO("mysql:host=$servername", $username, $password);
        // set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $createDbQuery = file_get_contents("INCLUDES/DATASET.sql");   
        $pdo->exec($createDbQuery);
        // echo "New records created successfully";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
