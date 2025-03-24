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
    !isset($_GET['MEM_ID']) || !isset($_GET['vendorCode']) || !isset($_GET['size']) ||
    !isset($_GET['ddrVersion']) || !isset($_GET['Price'])
) {
    die("Error: Missing required parameters.");
}

// Fetch and sanitize GET parameters
$mem_id = intval($_GET['MEM_ID']); // Ensure MEM_ID is an integer
$vendorCode = htmlspecialchars($_GET['vendorCode']); // Sanitize vendorCode
$size = intval($_GET['size']); // Ensure size is an integer
$ddrVersion = intval($_GET['ddrVersion']); // Ensure ddrVersion is an integer
$price = floatval($_GET['Price']); // Ensure price is a float

// Create database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$sql = "UPDATE memorysticks SET vendorCode=?, size=?, ddrVersion=?, Price=? WHERE MEM_ID=?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("siidi", $vendorCode, $size, $ddrVersion, $price, $mem_id);

// Execute statement
if ($stmt->execute()) {
    echo "Update successful!";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Debugging output
error_log("vendorCode: " . $vendorCode . " size: " . $size . " ddrVersion: " . $ddrVersion . " Price: " . $price . " MEM_ID: " . $mem_id);

// Close connections
$stmt->close();
$conn->close();
header("Location:../../../");
?>