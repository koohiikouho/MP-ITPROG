<?php
require './dbcred.php';
error_reporting(E_ALL);

// Connect to the database
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT m.MOB_ID, rv.vendorName, m.socketID, m.ddrVersion, m.memslots, m.m2slots, m.chipset,m.name,m.price
        FROM motherboards m
        JOIN ref_vendors rv ON m.vendorCode = rv.mbid
        WHERE m.isDeleted != '1'";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<table border='1' class='table'>
            <tr>
                <th>MOB_ID</th>
                <th>Vendor</th>
                <th>socketID</th>
                <th>DDR Version</th>
                <th>Memory Slots</th>
                <th>M2 Slots</th>
                <th>Chipset</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
                
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['MOB_ID']}</td>";
        echo "<td>{$row['vendorName']}</td>";
        echo "<td>{$row['socketID']}</td>";
        echo "<td>{$row['ddrVersion']}</td>";
        echo "<td>{$row['memslots']}</td>";
        echo "<td>{$row['m2slots']}</td>";
        echo "<td>{$row['chipset']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "<td><button class=\"btn btn-danger\" onclick=\"delMobo(" . $row['MOB_ID'] . ")\">Delete</button>";
        echo "   ";
        echo "<button class='btn btn-primary ml-2' data-bs-toggle='modal' data-bs-target='#updateMoboModal'>Update</button></td>";
        echo "</tr>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No case data found.";
}

$conn->close();
?>
