<?php
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

    if ($sortby == "price") {
        $sql = "SELECT p.psu_id, rf.vendorname ,p.wattage, p.efficiency, p.price
            FROM powersupplies p
            JOIN ref_vendors rf ON rf.mbid=p.vendorcode
            WHERE p.vendorcode='$brand'
            ORDER BY p.price ASC;";
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a PSU</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['psu_id'] . "'>" . $row['vendorname'] . " " . 
                                         $row['wattage'] . " " . $row['efficiency'] . 
                                         " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No PSUs match filter</option>";
        }
    } elseif ($sortby == "popularity") {
        $sql = "SELECT p.psu_id, rf.vendorname ,p.wattage, p.efficiency, p.price, COUNT(b.psu_id) AS popularity
                FROM powersupplies p
                JOIN ref_vendors rf ON rf.mbid=p.vendorcode
                LEFT JOIN builds b ON b.psu_id = p.psu_id
                WHERE p.vendorcode='$brand'
                GROUP BY p.psu_id, p.price
                ORDER BY popularity DESC;";
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a PSU</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['psu_id'] . "'>" . $row['vendorname'] . " " . 
                                         $row['wattage'] . " " . $row['efficiency'] . 
                                         " -  Used by " . $row['popularity'] . " build/s" . "</option>";
            }
        }
    }

    $conn->close();
?>