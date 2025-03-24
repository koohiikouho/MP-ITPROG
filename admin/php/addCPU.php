<?php
if (!isset($_POST['cpuName'], $_POST['cpuBrand'], $_POST['cpuCores'], $_POST['cpuThreads'], $_POST['cpuClock'], $_POST['cpuSocket'], $_POST['cpuPrice'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$cpuName = trim($_POST['cpuName']);
$cpuBrand = trim($_POST['cpuBrand']);
$cpuCores = intval($_POST['cpuCores']);
$cpuThreads = intval($_POST['cpuThreads']);
$cpuClock = floatval($_POST['cpuClock']);
$cpuSocket = trim($_POST['cpuSocket']);
$cpuPrice = floatval($_POST['cpuPrice']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$sql = $conn->prepare("INSERT INTO processors (name, vendorCode, cores, threads, baseClock, socketID, price) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)");

$sql->bind_param("ssiiisd", $cpuName, $cpuBrand, $cpuCores, $cpuThreads, $cpuClock, $cpuSocket, $cpuPrice);
if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "CPU added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Execution failed: " . $sql->error]);
}

$sql->close();
$conn->close();
?>