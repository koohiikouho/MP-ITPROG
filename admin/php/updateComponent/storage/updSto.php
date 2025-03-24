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
    !isset($_GET['STO_ID']) || !isset($_GET['vendor']) || !isset($_GET['capacity']) ||
    !isset($_GET['connType']) ||  !isset($_GET['stoType']) ||  !isset($_GET['price'])
) {
    die("Error: Missing required parameters.");
}

// Fetch and sanitize GET parameters
$sto_id = intval($_GET['STO_ID']); // Ensure MEM_ID is an integer
$vendorCode = htmlspecialchars($_GET['vendor']); // Sanitize vendorCode
$capacity = intval($_GET['capacity']); // Ensure size is an integer
$connType = htmlspecialchars($_GET['connType']); // Ensure ddrVersion is an integer
$stoType = htmlspecialchars($_GET['stoType']); // Ensure ddrVersion is an integer
$price = floatval($_GET['price']); // Ensure price is a float
// Create database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$sql = "UPDATE drives SET vendorName=?, capacity=?, storageType=?, connector=?, price=? WHERE DRV_ID=?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("sissdi", $vendorCode, $capacity, $stoType, $connType, $price, $sto_id);

// Execute statement
if ($stmt->execute()) {
    echo "Update successful!";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
header("Location:../../../");
?>