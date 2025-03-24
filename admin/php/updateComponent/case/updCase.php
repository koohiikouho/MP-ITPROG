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
    !isset($_GET['CSE_ID']) || !isset($_GET['vendorCode']) || 
    !isset($_GET['name']) || !isset($_GET['price'])
) {
    die("Error: Missing required parameters.");
}

// Fetch and sanitize GET parameters
$cse_id = intval($_GET['CSE_ID']); // Ensure cse_id is an integer
$vendorCode = htmlspecialchars($_GET['vendorCode']); // Sanitize vendorCode
$name = htmlspecialchars($_GET['name']); // Sanitize name
$price = floatval($_GET['price']); // Ensure price is a float

// Create database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$sql = "UPDATE cases SET vendorCode=?, name=?, price=? WHERE CSE_ID=?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssdi", $vendorCode, $name, $price, $cse_id);

// Execute statement
if ($stmt->execute()) {
    echo "Update successful!";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Debugging output
error_log("Case Update - ID: $cse_id, Vendor: $vendorCode, Name: $name, Price: $price");

// Close connections
$stmt->close();
$conn->close();
header("Location:../../../");
?>