<?php
require './dbcred.php';
error_reporting(E_ALL);

// Connect to the database
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT p.PSU_ID, rv.vendorName,p.wattage, p.efficiency, p.price
        FROM powersupplies p
        JOIN ref_vendors rv ON p.vendorCode = rv.mbid";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<table border='1' class='table'>
            <tr>
                <th>PSU_ID</th>
                <th>Vendor</th>
                <th>Wattage</th>
                <th>Efficiency</th>
                <th>Price</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['PSU_ID']}</td>";
        echo "<td>{$row['vendorName']}</td>";
        echo "<td>{$row['wattage']}</td>";
        echo "<td>{$row['efficiency']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No case data found.";
}

$conn->close();
?>
