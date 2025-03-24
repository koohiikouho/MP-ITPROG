<?php
include './dbcred.php';

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get the CPU ID from the query parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["error" => "CPU ID not provided"]);
    exit;
}

$cpuId = intval($_GET['id']); // Ensure it's an integer

// Use a prepared statement to fetch CPU details along with vendor and socket names
$sql = "SELECT p.name, p.cores, p.threads, p.baseClock, p.price, p.socketID, p.vendorCode,
               v.vendorName, s.socketName
        FROM processors p
        LEFT JOIN ref_vendors v ON p.vendorCode = v.mbid
        LEFT JOIN ref_sockets s ON p.socketID = s.socketID
        WHERE p.CPU_ID = ?";

$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind the parameter to the query
    $stmt->bind_param("i", $cpuId); // "i" indicates an integer

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Return the CPU details as JSON
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "CPU not found"]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["error" => "Failed to prepare the SQL statement"]);
}

$conn->close();
?>
