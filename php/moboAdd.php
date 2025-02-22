<?php
$moboName = $_GET['moboName'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT chipset, m2Slots, price FROM motherboards WHERE m.name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $moboName);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "description" => "{$row['chipset']} Chipset, {$row['m2Slots']} M.2 Slots",
        "price" => number_format($row['price'], 2)
    ]);
} else {
    echo json_encode(["error" => "Motherboard not found"]);
}

$stmt->close();
$conn->close();
?>
