<?php
require './dbcred.php';
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if (!isset($_POST['brand'], $_POST['name'], $_POST['price'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$brand = trim($_POST['brand']);
$name = trim($_POST['name']);
$price = floatval($_POST['price']);

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$sql = $conn->prepare("INSERT INTO cases (vendorCode, name, price) 
                       VALUES (?, ?, ?)");

$sql->bind_param("ssd", $brand, $name, $price);
if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "Case added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Execution failed: " . $sql->error]);
}

$sql->close();
$conn->close();
?>
