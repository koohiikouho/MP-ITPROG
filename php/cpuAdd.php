<?php
$cpuname = $_GET['name'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT p.cores, p.threads, p.baseClock, p.price, p.socketID
        FROM processors p
        WHERE p.cpu_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpuname);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are results
if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "description" => "{$row['cores']} Cores {$row['threads']} Threads @{$row['baseClock']}GHz",
        "socketID" => $row['socketID']
    ]);
} else {
    echo json_encode(["error" => "CPU not found"]);
}

$stmt->close();
$conn->close();
?>
