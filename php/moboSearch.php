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
        $sql = "SELECT b.name, b.mob_id, b.price
                FROM motherboards b
                WHERE vendorCode='$brand' AND chipset='$chipset'
                ORDER BY b.price ASC;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a Motherboard</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['mob_id'] . "'>" . $row['name']  . " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No Boards match filter</option>";
        }

    } elseif ($sortby == "popularity") {
        $sql = "SELECT m.name, m.mob_id, COUNT(m.mob_id) AS popularity, m.price
                FROM motherboards m
                LEFT JOIN builds b ON m.mob_id = m.mob_id
                WHERE m.vendorCode = '$brand' AND m.chipset = '$chipset'
                GROUP BY m.name, m.mob_id
                ORDER BY popularity DESC;";

        $result = $conn->query($sql);

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