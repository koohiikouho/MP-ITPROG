<?php
require './dbcred.php';
error_reporting(E_ALL);

// Connect to the database
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT c.CSE_ID, rv.vendorName, c.name, c.price 
        FROM cases c 
        JOIN ref_vendors rv ON c.vendorCode = rv.mbid
        WHERE c.isDeleted != '1'";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<table border='1' class='table'>
            <tr>
                <th>CSE_ID</th>
                <th>Vendor</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr id=\"trcse" . $row['CSE_ID'] . "\">";
        echo "<td>{$row['CSE_ID']}</td>";
        echo "<td>{$row['vendorName']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "<td><button class=\"btn btn-danger\" onclick=\"delCases(" . $row['CSE_ID'] . ")\">Delete</button>";
        echo "   ";
        echo "<button class='btn btn-primary ml-2' data-bs-toggle='modal' data-bs-target='#updateCaseModal' onclick=\"helpCase({$row['CSE_ID']});\">Update</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No case data found.";
}

$conn->close();
?>
