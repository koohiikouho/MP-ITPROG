<?php
if (!isset($_POST['brand'], $_POST['size'], $_POST['type'], $_POST['connection'], $_POST['price'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$brand = trim($_POST['brand']);
$size = intval($_POST['size']);
$type = trim($_POST['type']);
$connection = trim($_POST['connection']);
$price = floatval($_POST['price']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$sql = $conn->prepare("INSERT INTO drives (vendorName, capacity, storageType, connector, price) 
                       VALUES (?, ?, ?, ?, ?)");

$sql->bind_param("sissd", $brand, $size, $type, $connection, $price);
if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "Storage added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Execution failed: " . $sql->error]);
}

$sql->close();
$conn->close();
?>
