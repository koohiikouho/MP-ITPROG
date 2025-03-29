<?php
require './dbcred.php';

    $id = $_GET['id'];
    
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $query  = "UPDATE drives SET isDeleted ='1' WHERE DRV_ID=?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute(); 


    $conn->close();

?>