<?php
    $brand = isset($_GET['brand']) ? $_GET['brand'] : '';
    $chipset = isset($_GET['chipset']) ? $_GET['chipset'] : '';
    $name = isset($_GET['name']) ? $_GET['name'] : '';

    
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
            WHERE m.name='$name' AND m.chipset= '$chipset' AND m.brand= '$brand' ";
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