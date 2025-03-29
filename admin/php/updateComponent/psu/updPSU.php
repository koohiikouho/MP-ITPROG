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
    !isset($_GET['PSU_ID']) || !isset($_GET['vendor']) || 
    !isset($_GET['wattage']) || !isset($_GET['efficiency']) || 
    !isset($_GET['price'])
) {
    http_response_code(400);
    die("Error: Missing required parameters.");
}

// Fetch and sanitize GET parameters
$psu_id = intval($_GET['PSU_ID']); // Ensure PSU_ID is an integer
$vendor = htmlspecialchars($_GET['vendor']); // Sanitize vendor name
$wattage = intval($_GET['wattage']); // Ensure wattage is an integer
$efficiency = htmlspecialchars($_GET['efficiency']); // Sanitize efficiency rating
$price = floatval($_GET['price']); // Ensure price is a float

// Create database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$sql = "UPDATE powersupplies SET vendorCode=?, wattage=?, efficiency=?, price=? WHERE PSU_ID=?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("sisdi", $vendor, $wattage, $efficiency, $price, $psu_id);

// Execute statement
if ($stmt->execute()) {
    echo "Update successful!";
} else {
    http_response_code(500);
    echo "Error updating record: " . $stmt->error;
}

// Debugging output
error_log("PSU Update - ID: $psu_id, Vendor: $vendor, Wattage: $wattage, Efficiency: $efficiency, Price: $price");

// Close connections
$stmt->close();
$conn->close();
header("Location:../../../");
exit;
?>