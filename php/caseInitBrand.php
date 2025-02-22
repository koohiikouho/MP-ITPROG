<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DISTINCT rv.mbid, rv.vendorName
            FROM cases c
            JOIN ref_vendors rv ON c.vendorCode = rv.mbid;";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a brand</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['mbid'] . "'>" . $row['vendorName']  . "</option>";
        }
    } else {
        echo "<option disabled>No brands available</option>";
    }

    $conn->close();

?>