<?php
    $type = $_GET['type'];
    $brand = $_GET['brand'];
    $size = (int)$_GET['size']; // Ensure it's an integer

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (strpos($type, " - ") !== false) {
        list($storageType, $connector) = explode(" - ", $type, 2);
    } else {
        die("Invalid storage type format");
    }

    $sql = "SELECT price 
            FROM drives 
            WHERE storageType = '$storageType' 
            AND connector = '$connector' 
            AND vendorName = '$brand' 
            AND capacity = $size";

    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {
        echo $row['price'];
    } else {
        echo "Error";
    }

    $conn->close();
?>
