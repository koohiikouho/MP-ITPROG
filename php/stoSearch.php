<?php
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $brand = isset($_GET['brand']) ? $_GET['brand'] : '';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ensure $type is properly split into storageType and connector
    if (strpos($type, " - ") !== false) {
        list($storageType, $connector) = explode(" - ", $type, 2);
    } else {
        die("<option disabled selected>Invalid storage type format: " . $type . "</option>");
    }

    // Prepare and execute SQL query
    $sql = $conn->prepare("
        SELECT DRV_ID, vendorName, capacity 
        FROM drives
        WHERE storageType = ? AND connector = ? AND vendorName = ?
    ");
    $sql->bind_param("sss", $storageType, $connector, $brand);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select Storage Size</option>";
        while ($row = $result->fetch_assoc()) {
            $capacity = (int) $row['capacity']; // Ensure capacity is treated as an integer
            
            // Convert to TB if 1000GB or more
            if ($capacity >= 1000) {
                $displayCapacity = number_format($capacity / 1000, 1) . " TB"; // Format to 1 decimal place if needed
            } else {
                $displayCapacity = $capacity . " GB";
            }

            // Store raw capacity in `value` while displaying formatted text
            echo "<option value='" . $capacity . "'>" . $displayCapacity . "</option>";
        }
    } else {
        echo "<option disabled selected>No Storage Drives match filter</option>";
    }

    $sql->close();
    $conn->close();
?>
