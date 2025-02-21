<?php
    $brand = $_GET['brand'];
    $chipset = $_GET['chipset'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT m.mob_id, m.moboname
            FROM motherboards m
            WHERE m.vendorCode='$brand' AND m.chipset='$chipset'";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a Motherboard</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['mob_id'] . "'>" . $row['moboname'] . "</option>";
        }
    } else {
        echo "<option disabled selected>No Motherboards match filter</option>";
    }

    $conn->close();
?>
