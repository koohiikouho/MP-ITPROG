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
    !isset($_GET['CPU_ID']) || !isset($_GET['name']) || !isset($_GET['vendorCode']) ||
    !isset($_GET['cores']) || !isset($_GET['threads']) || !isset($_GET['baseClock']) ||
    !isset($_GET['Socket']) || !isset($_GET['price'])
) {
    die("Error: Missing required parameters.");
}

// Fetch and sanitize GET parameters
$cpu_id = intval($_GET['CPU_ID']); // Ensure CPU_ID is an integer
$name = htmlspecialchars($_GET['name']); // Sanitize name
$vendorCode = htmlspecialchars($_GET['vendorCode']); // Sanitize vendor code
$cores = intval($_GET['cores']); // Ensure cores is an integer
$threads = intval($_GET['threads']); // Ensure threads is an integer
$baseClock = floatval($_GET['baseClock']); // Ensure baseClock is a float
$socket = intval($_GET['Socket']); // Ensure Socket is an integer
$price = floatval($_GET['price']); // Ensure price is a float

// Create database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$sql = "UPDATE processors SET name=?, vendorCode=?, cores=?, threads=?, baseClock=?, socketID=?, price=? WHERE CPU_ID=?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssiididi", $name, $vendorCode, $cores, $threads, $baseClock, $socket, $price, $cpu_id);

// Execute statement
if ($stmt->execute()) {
    echo "Update successful!";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Debugging output
error_log("CPU_ID: " . $cpu_id . " name: " . $name . " vendorCode: " . $vendorCode . " cores: " . $cores . " threads: " . $threads . " baseClock: " . $baseClock . " Socket: " . $socket . " price: " . $price);

// Close connections
$stmt->close();
$conn->close();
header("Location:../../../");
?>