<?php
require './dbcred.php';

    $id = $_GET['id'];
    
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $query  = "UPDATE cases SET isDeleted ='1' WHERE CSE_id=?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute(); 
    $conn->close();

?>