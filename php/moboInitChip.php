<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    // Get the socketID from the request
    $socketID = $_GET['socketID'];


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Select chipsets that match the given socketID
    $sql = "SELECT DISTINCT chipset FROM motherboards WHERE socketID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $socketID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select chipset</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['chipset'] . "'>" . $row['chipset']  . "</option>";
        }
    } else {
        echo "<option disabled>No compatible chipset </option>";
    }

    // Close connections
    $stmt->close();
    $conn->close();
?>
