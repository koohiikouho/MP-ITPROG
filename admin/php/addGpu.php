<?php
if (!isset($_POST['brand'], $_POST['vendor'], $_POST['name'], $_POST['price'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$brand = trim($_POST['brand']);
$vendor = trim($_POST['vendor']);
$name = trim($_POST['name']);
$price = floatval($_POST['price']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$sql = $conn->prepare("INSERT INTO videocards (brandCode, vendorCode, model, price) 
                       VALUES (?, ?, ?, ?)");

$sql->bind_param("sssd", $brand, $vendor, $name, $price);
$sql->execute();


$sql->close();
$conn->close();
?>
