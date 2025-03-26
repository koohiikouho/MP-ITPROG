<?php
require './dbcred.php';
error_reporting(E_ALL);


$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT m.MEM_ID, rv.vendorName, m.size, m.ddrVersion, m.price
        FROM memorysticks m
        JOIN ref_vendors rv ON m.vendorCode = rv.mbid
        WHERE m.isDeleted != '1'";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<table border='1' class='table'>
            <tr>
                <th>MEM_ID</th>
                <th>Vendor</th>
                <th>size</th>
                <th>DDR Version</th>
                <th>Price</th>
                <th>Actions</th>
                <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#updateMemModal'>Update</button>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['MEM_ID']}</td>";;
        echo "<td>{$row['vendorName']}</td>";
        echo "<td>{$row['size']}</td>";
        echo "<td>{$row['ddrVersion']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "<td><button class=\"btn btn-danger\" onclick=\"delMemory(" . $row['MEM_ID'] . ")\">Delete</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No case data found.";
}

$conn->close();
?>
