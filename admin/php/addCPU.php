<?php
    // Check if all required parameters exist
    if (!isset($_GET['cpuName'], $_GET['cpuBrand'], $_GET['cpuCores'], $_GET['cpuThreads'], $_GET['cpuClock'], $_GET['cpuSocket'], $_GET['cpuPrice'])) {
        die(json_encode(["error" => "Missing required parameters"]));
    }

    // Get values from GET request
    $cpuName = $_GET['cpuName'];
    $cpuBrand = $_GET['cpuBrand'];
    $cpuCores = $_GET['cpuCores'];
    $cpuThreads = $_GET['cpuThreads'];
    $cpuClock = $_GET['cpuClock'];
    $cpuSocket = $_GET['cpuSocket'];
    $cpuPrice = $_GET['cpuPrice'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    // Connect to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }

    $sql = "INSERT INTO processors (name, vendorCode, cores, threads, baseClock, socketID, price) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiidd", $cpuName, $cpuBrand, $cpuCores, $cpuThreads, $cpuClock, $cpuSocket, $cpuPrice);
    $stmt->execute();

    $stmt->close();
    $conn->close();
?>
