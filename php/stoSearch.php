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
        $stmt = $conn->prepare("SELECT drv_id, capacity, price
                        FROM drives
                        WHERE storageType = ? 
                        AND connector = ? 
                        AND vendorName = ? 
                        AND isDeleted = '0'
                        ORDER BY price ASC");

        $stmt->bind_param("sss", $storageType, $connector, $brand);
        $stmt->execute();
        $result = $stmt->get_result();


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
                echo "<option value='" . $row['drv_id'] . "'>" . $displayCapacity . " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No Storage Drives match filter</option>";
        }

    } elseif ($sortby == "popularity") {
        $stmt = $conn->prepare("SELECT d.drv_id, COUNT(b.drv_id) AS popularity, d.price, d.capacity
                FROM drives d
                LEFT JOIN builds b ON b.drv_id = d.drv_id
                WHERE storageType = ? 
                AND connector = ? 
                AND vendorName = ?
                GROUP BY d.drv_id
                ORDER BY popularity DESC;");

                $stmt->bind_param("sss", $storageType, $connector, $brand);
                $stmt->execute();
                $result = $stmt->get_result();

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
                echo "<option value='" . $row['drv_id'] . "'>" . $displayCapacity . " -  Used by " . $row['popularity'] . " build/s" . "</option>";
            }
        } else {
            echo "<option disabled selected>No Storage Drives match filter</option>";
        }

    }

    $conn->close();
?>
