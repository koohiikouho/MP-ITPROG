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

    $sql = "SELECT v.gpu_id, vv.vendorName AS vendorName, v.model
            FROM videocards v
            JOIN ref_vendors vv ON v.vendorCode = vv.mbid
            WHERE v.brandCode = '$brand'";

    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a GPU</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['gpu_id'] . "'>" 
                . htmlspecialchars($row['vendorName']) . " - " 
                . htmlspecialchars($row['model']) . "</option>";
        }
    } else {
        echo "<option disabled selected>No GPUs match filter</option>";
    }

    $conn->close();
?>
