<?php
    $cpuname = $_GET['name'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT p.cores, p.threads, p.baseClock, p.price
            FROM processors p
            WHERE name='$cpuname' ";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo 
            "Cores: " . $row['cores'] .
            " Threads: " . $row['threads'] .
            " Clock Speed: ". $row['baseClock'] . "GHz";
        }
    } else {
        echo "Error";
    }

    $conn->close();
?>