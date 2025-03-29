<?php
// Database connection details
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dbpcpartspicker";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if all required GET parameters are set
if (
    !isset($_GET['GPU_ID']) || !isset($_GET['brandCode']) || 
    !isset($_GET['vendorCode']) || !isset($_GET['model']) || 
    !isset($_GET['price'])
) {
    http_response_code(400);
    die("Error: Missing required parameters.");
}

// Fetch and sanitize GET parameters
$gpu_id = intval($_GET['GPU_ID']); // Ensure GPU_ID is an integer
$brandCode = htmlspecialchars($_GET['brandCode']); // Sanitize brand code
$vendorCode = htmlspecialchars($_GET['vendorCode']); // Sanitize vendor code
$model = htmlspecialchars($_GET['model']); // Sanitize model name
$price = floatval($_GET['price']); // Ensure price is a float

// Create database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$sql = "UPDATE videocards SET brandCode=?, vendorCode=?, model=?, price=? WHERE GPU_ID=?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("sssdi", $brandCode, $vendorCode, $model, $price, $gpu_id);

// Execute statement
if ($stmt->execute()) {
    echo "Update successful!";
} else {
    http_response_code(500);
    echo "Error updating record: " . $stmt->error;
}

// Debugging output
error_log("GPU Update - ID: $gpu_id, Brand: $brandCode, Vendor: $vendorCode, Model: $model, Price: $price");

// Close connections
$stmt->close();
$conn->close();
header("Location:../../../");
exit;
?>