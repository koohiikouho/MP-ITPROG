<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";
    $id = $_GET['id'];
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $query = "UPDATE motherboards SET isDeleted ='1' WHERE MOB_id=?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute(); 

    $conn->close();

?>