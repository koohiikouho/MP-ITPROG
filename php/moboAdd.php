<?php
    $moboID = $_GET['ID'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";


    // TO FIX THIS IS ASS
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT m.chipset, m.m2Slots, m.price
            FROM motherboards m
            WHERE ID='$moboID' ";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo 
             $row['chipset'] ." Chipset " 
             . $row['m2Slots'] . " M.2 Slots " .
             $row['Price'] . "Price";
        }
    } else {
        echo "Error";
    }

    $conn->close();
?>