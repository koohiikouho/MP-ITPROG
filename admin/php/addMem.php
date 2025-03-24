<?php
if (!isset($_POST['brand'], $_POST['ddr'], $_POST['size'], $_POST['price'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$brand = trim($_POST['brand']);
$ddr = intval($_POST['ddr']);
$size = intval($_POST['size']);
$price = floatval($_POST['price']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$sql = $conn->prepare("INSERT INTO memorysticks (vendorCode, ddrVersion, size, price) 
                       VALUES (?, ?, ?, ?)");


$sql->bind_param("siid", $brand, $ddr, $size, $price);

if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "Memory added successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $sql->error]);
}

$sql->close();
$conn->close();
?>