<?php
    if (!isset($_POST['name'], $_POST['brand'], $_POST['ddr'], $_POST['memSlots'], $_POST['m2slots'], $_POST['cpuSocket'], $_POST['price'])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit;
    }

    $name = trim($_POST['name']);
    $socketId = intval($_POST['socketId']);
    $brand = trim($_POST['brand']);
    $ddr = intval($_POST['ddr']);
    $memSlots = intval($_POST['memSlots']);
    $m2slots = intval($_POST['m2slots']);
    $chipset = trim($_POST['cpuSocket']);
    $price = floatval($_POST['price']);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
        exit;
    }

    $sql = $conn->prepare("INSERT INTO motherboards (name, socketID, vendorCode, ddrVersion, memSlots, m2Slots, chipset, price) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$sql) {
        echo json_encode(["error" => "SQL preparation error: " . $conn->error]);
        exit;
    }

    // Bind parameters and execute query
    $sql->bind_param("sisiiisd", $name, $socketId, $brand, $ddr, $memSlots, $m2slots, $chipset, $price);

    if ($sql->execute()) {
        echo json_encode(["success" => "Motherboard added successfully!"]);
    } else {
        echo json_encode(["error" => "Database error: " . $sql->error]);
    }

    // Close resources
    $sql->close();
    $conn->close();
?>
