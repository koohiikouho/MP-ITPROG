<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT DISTINCT chipset
            FROM motherboards;";

    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select chipset </option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['cores'] . "'>" . $row['cores']  . "</option>";
        }
    } else {
        echo "<option disabled>No chipset available</option>";
    }

    $conn->close();
    
?>