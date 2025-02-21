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
    $sql = "SELECT p.name, p.cpu_id
            FROM processors p
            WHERE vendorCode='$brand' AND cores='$cores' ";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a CPU</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['cpu_id'] . "'>" . $row['name']  . "</option>";
        }
    } else {
        echo "<option disabled selected>No CPUs match filter</option>";
    }

    $conn->close();
?>