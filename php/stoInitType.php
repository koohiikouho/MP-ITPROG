<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    // Get the m2Slots from the request
    $m2Slots = isset($_GET['m2Slots']) ? (int) $_GET['m2Slots'] : 0; // Ensure it's an integer

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Modify SQL query to exclude M.2 if m2Slots is 0
    if ($m2Slots == 0) {
        $sql = "SELECT DISTINCT d.storageType, d.connector FROM drives d WHERE d.connector != 'M.2'";
    } else {
        $sql = "SELECT DISTINCT d.storageType, d.connector FROM drives d";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select storage type</option>";
        while ($row = $result->fetch_assoc()) {
            // Use storageType and connector for both value and display
            echo "<option value='" . $row['storageType'] . " - " . $row['connector'] . "'>" 
                 . $row['storageType'] . " - " . $row['connector'] . "</option>";
        }
    } else {
        echo "<option disabled>No storage options available</option>";
    }

    $conn->close();
?>
