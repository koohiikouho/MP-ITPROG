<?php
    $brand = $_GET['brand'];
    $chipset = $_GET['chipset'];
    $mob_id = $_GET['mob_id'];

    
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
            JOIN ref_vendors rv ON m.vendorCode = rv.mbid 
            WHERE m.mob_id='$mob_id' AND m.chipset= '$chipset' AND rv.vendorName= '$brand' ";
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
