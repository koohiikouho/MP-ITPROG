<?php
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$chipset = isset($_GET['chipset']) ? $_GET['chipset'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT m.ddrversion, m.chipset, m.m2Slots, m.price 
        FROM motherboards m
        WHERE m.name='$name' AND m.chipset= '$chipset' AND m.vendorCode= '$brand' ";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "description" => "DDR version {$row['ddrversion']}, {$row['m2Slots']} M.2 Slots",
    ]);
} else {
    echo json_encode(["error" => "Motherboard not found"]);
}

$stmt->close();
$conn->close();
?>
