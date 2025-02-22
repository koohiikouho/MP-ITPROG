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
    $sql = "SELECT c.cse_id, rv.vendorname, c.price, c.name
            FROM cases c
            JOIN ref_vendors rv ON rv.mbid=c.vendorcode
            WHERE c.vendorcode='$brand'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a case</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['cse_id'] . "'>" . $row['vendorname'] . " " .$row['name'] . " -  ₱" . $row['price'] . "</option>";
        }
    } else {
        echo "<option disabled selected>No CPUs match filter</option>";
    }

    $conn->close();
?>