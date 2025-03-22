<?php
    $brand = $_GET['brand'];
    $chipset = $_GET['chipset'];
    $sortby = $_GET['sortby'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql;

    // Change sql query acc to sortby
    if ($sortby == "price") {
        $stmt = $conn->prepare("SELECT m.name, m.mob_id, m.price
                        FROM motherboards m
                        WHERE m.vendorCode = ? 
                        AND m.chipset = ? 
                        AND m.isDeleted = '0'
                        ORDER BY m.price ASC");

        $stmt->bind_param("ss", $brand, $chipset);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a Motherboard</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['mob_id'] . "'>" . $row['name']  . " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No Mobos match filter</option>";
        }

    } elseif ($sortby == "popularity") {
        $stmt = $conn->prepare("SELECT m.name, m.mob_id, COUNT(b.mobo_id) AS popularity, m.price
                FROM motherboards m
                LEFT JOIN builds b ON m.mob_id = m.mob_id
                WHERE m.vendorCode = ? 
                AND m.chipset = ?
                AND m.isDeleted = '0'
                GROUP BY m.name, m.mob_id
                ORDER BY popularity DESC;");

        $stmt->bind_param("ss", $brand, $chipset);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a Motherboard</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['mob_id'] . "'>" . $row['name']  . " -  Used by " . $row['popularity'] . " build/s" . "</option>";
            }
        } else {
            echo "<option disabled selected>No Mobos match filter</option>";
        }
    }

    $conn->close();
?>