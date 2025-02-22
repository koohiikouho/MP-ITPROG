<?php
    $brand = $_GET['brand'];
    $size = $_GET['size'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }

    $sql = "SELECT m.ddrversion
            FROM memorysticks m
            JOIN ref_vendors rv ON m.vendorcode = rv.mbid 
            WHERE m.size= '$size' AND rv.vendorName= '$brand'";
    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            "description" => "DDR{$row['ddrversion']}"
        ]);
    } else {
        echo json_encode(["error" => "Memory Stick not found"]);
    }

    $conn->close();
?>
