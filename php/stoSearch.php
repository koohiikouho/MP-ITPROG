<?php
    $type = $_GET['type'];
    $brand = $_GET['brand'];
    $sortby = $_GET['sortby'];

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

    $sql;

    if ($sortby == "price") {
        $sql = "SELECT drv_id, capacity, price
                FROM drives
                WHERE storageType = '$storageType' AND connector = '$connector' AND vendorName = '$brand'
                ORDER BY price ASC;";

        $result = $conn->query($sql);

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
                echo "<option value='" . $capacity . "'>" . $displayCapacity . " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No Storage Drives match filter</option>";
        }

    } elseif ($sortby == "popularity") {
        $sql = "SELECT d.drv_id, COUNT(b.drv_id) AS popularity, d.price, d.capacity
                FROM drives d
                LEFT JOIN builds b ON b.drv_id = d.drv_id
                WHERE storageType = '$storageType' AND connector = '$connector' AND vendorName = '$brand'
                GROUP BY d.drv_id
                HAVING COUNT(b.mem_id) > 0
                ORDER BY popularity DESC;";

        $result = $conn->query($sql);

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
                echo "<option value='" . $capacity . "'>" . $displayCapacity . " -  Used by " . $row['popularity'] . " build/s" . "</option>";
            }
        } else {
            echo "<option disabled selected>No Storage Drives match filter</option>";
        }

    }

    $conn->close();
?>
