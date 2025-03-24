<?php
require './dbcred.php';
error_reporting(E_ALL);

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT d.DRV_ID, rv.vendorName,d.capacity, d.storageType, d.connector, d.price
        FROM drives d
        JOIN ref_vendors rv ON d.vendorName = rv.mbid";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<table border='1' class='table'>
            <tr>
                <th>DRV_ID</th>
                <th>Vendor</th>
                <th>Capacity</th>
                <th>Storage Type</th>
                <th>Connector</th>
                <th>Price</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['DRV_ID']}</td>";
        echo "<td>{$row['vendorName']}</td>";
        echo "<td>{$row['capacity']}</td>";
        echo "<td>{$row['storageType']}</td>";
        echo "<td>{$row['connector']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No case data found.";
}

$conn->close();
?>
