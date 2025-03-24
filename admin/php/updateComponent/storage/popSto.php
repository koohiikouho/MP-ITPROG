<?php
    include '../../dbcred.php';

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM drives WHERE isDeleted=0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select memory</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['DRV_ID'] . "'>" . $row['vendorName'] . " ". $row['capacity'] . " ". $row['storageType'] . " ". $row['connector'] ."</option>";
        }
    } else {
        echo "<option disabled>No memory</option>";
    }

    $conn->close();

?>