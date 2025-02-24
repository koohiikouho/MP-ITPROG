<?php
 // Ensure it's an integer
    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT price 
            FROM drives 
            WHERE DRV_ID = '$id' ";

    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {
        echo $row['price'];
    } else {
        echo "Error";
    }

    $conn->close();
?>
