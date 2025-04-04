<?php
require './dbcred.php';
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if (!isset($_POST['brand'], $_POST['wattage'], $_POST['efficiency'], $_POST['price'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$brand = trim($_POST['brand']);
$wattage = intval($_POST['wattage']);
$efficiency = trim($_POST['efficiency']);
$price = floatval($_POST['price']);

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$sql = $conn->prepare("INSERT INTO powersupplies (vendorCode, wattage, efficiency, price) 
                       VALUES (?, ?, ?, ?)");

$sql->bind_param("sisd", $brand, $wattage, $efficiency, $price);
if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "PSU added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Execution failed: " . $sql->error]);
}

$sql->close();
$conn->close();
?>
