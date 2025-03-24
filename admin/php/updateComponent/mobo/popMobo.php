<?php
    include '../../dbcred.php';

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM motherboards;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a motherboard</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['MOB_ID'] . "'>" . $row['name']  . "</option>";
        }
    } else {
        echo "<option disabled>No sockets available</option>";
    }

    $conn->close();

?>