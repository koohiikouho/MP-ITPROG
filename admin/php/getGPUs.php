<?php
require './dbcred.php';
error_reporting(E_ALL);

// Connect to the database
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT v.GPU_ID, rv.vendorName, v.brandCode, v.model, v.price
        FROM videocards v
        JOIN ref_vendors rv ON v.vendorCode = rv.mbid"; // No sorting

$result = $conn->query($sql);

// Display data in an HTML table
if ($result->num_rows > 0) {
    echo "<table border='1' class='table'>
            <tr>
                <th>GPU_ID</th>
                <th>Brand</th>
                <th>Vendor</th>
                <th>Model</th>
                <th>Price</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['GPU_ID']}</td>";
        echo "<td>{$row['brandCode']}</td>";
        echo "<td>{$row['vendorName']}</td>";
        echo "<td>{$row['model']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No case data found.";
}

$conn->close();
?>
