<?php
if (!isset($_POST['name'], $_POST['socketId'], $_POST['brand'], $_POST['ddr'], $_POST['memSlots'], $_POST['m2slots'], $_POST['chipset'], $_POST['price'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$name = trim($_POST['name']);
$socketId = intval($_POST['socketId']);
$brand = trim($_POST['brand']);
$ddr = intval($_POST['ddr']);
$memSlots = intval($_POST['memSlots']);
$m2slots = intval($_POST['m2slots']);
$chipset = trim($_POST['chipset']);
$price = floatval($_POST['price']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = $conn->prepare("INSERT INTO motherboards (name, socketID, vendorCode, ddrVersion, memSlots, m2Slots, chipset, price) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$sql->bind_param("sisiiisd", $name, $socketId, $brand, $ddr, $memSlots, $m2slots, $chipset, $price);

if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "Motherboard added successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $sql->error]);
}


$sql->close();
$conn->close();
?>
