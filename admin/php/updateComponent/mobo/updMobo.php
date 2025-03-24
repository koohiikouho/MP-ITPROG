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
    !isset($_GET['moboID']) || !isset($_GET['Name']) || !isset($_GET['Brand']) ||
    !isset($_GET['Socket']) || !isset($_GET['MemSlots']) || !isset($_GET['Chipset']) ||
    !isset($_GET['Price']) || !isset($_GET['DDR']) || !isset($_GET['M2'])
) {
    die("Error: Missing required parameters.");
}

// Fetch and sanitize GET parameters
$moboid = intval($_GET['moboID']); // Ensure MOB_ID is an integer
$name = htmlspecialchars($_GET['Name']); // Sanitize name
$brand = htmlspecialchars($_GET['Brand']); // Sanitize brand
$socket = intval($_GET['Socket']); // Ensure socket is an integer
$MemSlots = intval($_GET['MemSlots']); // Ensure MemSlots is an integer
$chipset = htmlspecialchars($_GET['Chipset']); // Sanitize chipset
$price = floatval($_GET['Price']); // Ensure price is a float
$ddr = intval($_GET['DDR']); // Ensure DDR is an integer
$m2 = intval($_GET['M2']); // Ensure M2 is an integer

// Create database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$sql = "UPDATE motherboards SET vendorCode=?, socketID=?, ddrVersion=?, memSlots=?, m2Slots=?, chipset=?, `name`=?, price=? WHERE MOB_ID=?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("siiiissdi", $brand, $socket, $ddr, $MemSlots, $m2, $chipset, $name, $price, $moboid);

// Execute statement
if ($stmt->execute()) {
    echo "Update successful!";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Debugging output
error_log("brand: " . $brand . " socket: " . $socket . " ddr: " . $ddr . " MemSlots: " . $MemSlots . " M2: " . $m2 . " Chipset: " . $chipset . " Name: " . $name . " Price: " . $price . " MoboID: " . $moboid);

// Close connections
$stmt->close();
$conn->close();
header("Location:../../../");
?>