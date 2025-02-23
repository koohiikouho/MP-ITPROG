<?php
    $brand = $_GET['brand'];
    $chipset = $_GET['chipset'];
    $name = $_GET['name'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }

    $sql = "SELECT m.chipset, m.m2Slots, m.memSlots, m.ddrversion
            FROM motherboards m
            JOIN ref_vendors rv ON m.vendorCode = rv.mbid 
            WHERE m.name='$name' AND m.chipset= '$chipset' AND rv.vendorname= '$brand'";
    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            "description" => "DDR version {$row['ddrversion']}, {$row['m2Slots']} M.2 Slots",
            "memSlots" => $row['memSlots'],
            "ddrVersion" => $row['ddrversion'],
            "m2Slots" => $row['m2Slots']
        ]);
    } else {
        echo json_encode(["error" => "Motherboard not found"]);
    }

    $conn->close();
?>
