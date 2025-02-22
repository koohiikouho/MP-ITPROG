<?php
    $brand = $_GET['brand'];
    $size = $_GET['size'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT m.price
            FROM memorysticks m
            JOIN ref_vendors rv ON m.vendorCode = rv.mbid 
            WHERE m.size= '$size' AND rv.vendorName= '$brand'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['price'];
        }
    } else {
        echo "Error";
    }

    $conn->close();
?>
