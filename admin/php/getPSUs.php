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
        JOIN ref_vendors rv ON p.vendorCode = rv.mbid
        WHERE p.isDeleted != '1'";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<table border='1' class='table'>
            <tr>
                <th>PSU_ID</th>
                <th>Vendor</th>
                <th>Wattage</th>
                <th>Efficiency</th>
                <th>Price</th>
                <th>Actions</th>

            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr id=\"trpsu" . $row['PSU_ID'] . "\">";
        echo "<td>{$row['PSU_ID']}</td>";
        echo "<td>{$row['vendorName']}</td>";
        echo "<td>{$row['wattage']}</td>";
        echo "<td>{$row['efficiency']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "<td><button class=\"btn btn-danger\" onclick=\"delPSUs(" . $row['PSU_ID'] . ")\">Delete</button>";
        echo "   ";
        echo "<button class='btn btn-primary ml-2' data-bs-toggle='modal' data-bs-target='#updatePSUModal' onclick=\"helpPSU({$row['PSU_ID']});\" \">Update</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No case data found.";
}

$conn->close();
?>
