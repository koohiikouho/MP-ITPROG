<?php
if (!isset($_POST['brand'], $_POST['wattage'], $_POST['efficiency'], $_POST['price'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$brand = trim($_POST['brand']);
$wattage = intval($_POST['wattage']);
$efficiency = trim($_POST['efficiency']);
$price = floatval($_POST['price']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$sql = $conn->prepare("INSERT INTO powersupplies (vendorCode, wattage, efficiency, price) 
                       VALUES (?, ?, ?, ?)");

$sql->bind_param("sisd", $brand, $wattage, $efficiency, $price);
$sql->execute();

$sql->close();
$conn->close();
?>
