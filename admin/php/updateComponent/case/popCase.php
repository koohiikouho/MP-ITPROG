<?php
    include '../../dbcred.php';

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM cases WHERE isDeleted=0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select memory</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['CSE_ID'] . "'>" . $row['vendorCode'] . " ". $row['name'] ."</option>";
        }
    } else {
        echo "<option disabled>No memory</option>";
    }

    $conn->close();

?>