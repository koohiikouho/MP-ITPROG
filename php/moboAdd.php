<?php
    $mob_id = $_GET['mob_id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }

    $sql = "SELECT chipset, m2Slots, memSlots, ddrversion
            FROM motherboards
            WHERE mob_id=$mob_id";
    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            "description" => "DDR version {$row['ddrversion']}, {$row['m2Slots']} M.2 Slots, {$row['memSlots']} Memory Slots",
            "memSlots" => $row['memSlots'],
            "ddrVersion" => $row['ddrversion'],
            "m2Slots" => $row['m2Slots']
        ]);
    } else {
        echo json_encode(["error" => "Motherboard not found"]);
    }

    $conn->close();
?>
