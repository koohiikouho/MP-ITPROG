<?php
    $moboID = $_GET['moboID'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT m.price
            FROM motherboards m
            WHERE name='$moboID' ";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['price'];
        }
    } else {
        echo "Error";
    }

    $conn->close();
?>