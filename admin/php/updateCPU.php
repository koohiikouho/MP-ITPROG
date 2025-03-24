<?php
include './dbcred.php';

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if (
    isset($_POST['id']) && isset($_POST['name']) && isset($_POST['cores']) &&
    isset($_POST['threads']) && isset($_POST['baseClock']) && 
    isset($_POST['socketID']) && isset($_POST['vendorCode']) && isset($_POST['price'])
) {
    // Validate and sanitize input data
    $cpuId = intval($_POST['id']);
    $cpuName = trim($_POST['name']);
    $cpuCores = intval($_POST['cores']);
    $cpuThreads = intval($_POST['threads']);
    $cpuClock = floatval($_POST['baseClock']);
    $cpuSocket = intval($_POST['socketID']);
    $cpuBrand = trim($_POST['vendorCode']);
    $cpuPrice = floatval($_POST['price']);

    // Check for empty or invalid data
    if (empty($cpuName) || $cpuCores <= 0 || $cpuThreads <= 0 || $cpuClock <= 0 || $cpuSocket <= 0 || empty($cpuBrand) || $cpuPrice <= 0) {
        echo json_encode(["error" => "Invalid or missing data"]);
        exit;
    }

    // Check if the CPU ID exists
    $checkSql = "SELECT CPU_ID FROM processors WHERE CPU_ID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $cpuId);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows === 0) {
        echo json_encode(["error" => "CPU ID does not exist"]);
        exit;
    }
    $checkStmt->close();

    // Prepare the update query
    $sql = "UPDATE processors SET name=?, cores=?, threads=?, baseClock=?, socketID=?, vendorCode=?, price=? WHERE CPU_ID=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("siissssi", $cpuName, $cpuCores, $cpuThreads, $cpuClock, $cpuSocket, $cpuBrand, $cpuPrice, $cpuId);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => "CPU details updated successfully"]);
        } else {
            echo json_encode(["error" => "Failed to update CPU details: " . $stmt->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["error" => "Failed to prepare SQL statement"]);
    }
} else {
    echo json_encode(["error" => "Missing required fields"]);
}

$conn->close();
?>