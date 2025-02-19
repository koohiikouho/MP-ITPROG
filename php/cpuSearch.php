<?php
    $brand = $_GET['brand'];
    $cores = $_GET['cores'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    $sql = "SELECT p.name
            FROM processors p
            WHERE vendorCode='$brand' && cores='$cores' ";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a CPU</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['name'] . "'>" . $row['name']  . "</option>";
        }
    } else {
        echo "<option disabled>No CPUs available</option>";
    }

    $conn->close();
?>