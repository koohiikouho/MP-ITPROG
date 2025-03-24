<?php
    include './dbcred.php';
    
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT c.CPU_ID, rv.vendorName, c.name
            FROM processors c
            JOIN ref_vendors rv ON c.vendorCode = rv.mbid
            WHERE c.isDeleted = 0;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        echo "<option value='' disabled selected>Select a CPU</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['CPU_ID'] . "'>" . $row['CPU_ID'] . " - " .$row['vendorName'] . " - " . $row['name'] . "</option>";
        }
    } else {

        echo "<option disabled>No CPUs available</option>";
    }

    $conn->close();
?>