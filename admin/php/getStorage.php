<?php
require './dbcred.php';
error_reporting(E_ALL);

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT d.DRV_ID, rv.vendorName,d.capacity, d.storageType, d.connector, d.price
        FROM drives d
        JOIN ref_vendors rv ON d.vendorName = rv.mbid
        WHERE d.isDeleted != '1'";

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
                <th>Actions</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr id=\"trsto" . $row['DRV_ID'] . "\">";
        echo "<td>{$row['DRV_ID']}</td>";
        echo "<td>{$row['vendorName']}</td>";
        echo "<td>{$row['capacity']}</td>";
        echo "<td>{$row['storageType']}</td>";
        echo "<td>{$row['connector']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "<td><button class=\"btn btn-danger\" onclick=\"delStorage(" . $row['DRV_ID'] . ")\">Delete</button>";
        echo "   ";
        echo "<button class='btn btn-primary ml-2' data-bs-toggle='modal' data-bs-target='#updateStoModal' onclick=\"helpSto({$row['DRV_ID']});\" \>Update</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No case data found.";
}

$conn->close();
?>
