<?php
    $brand = $_GET['brand'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT p.psu_id, rf.vendorname ,p.wattage, p.efficiency
            FROM powersupplies p
            JOIN ref_vendors rf ON rf.mbid=p.vendorcode
            WHERE p.vendorcode='$brand'";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a PSU</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['psu_id'] . "'>" . $row['vendorname'] . " " . $row['wattage'] . " " . $row['efficiency'] . "</option>";
        }
    } else {
        echo "<option disabled selected>No PSUs match filter</option>";
    }

    $conn->close();
?>