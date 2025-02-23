<?php

    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $brand = isset($_GET['brand']) ? $_GET['brand'] : '';
    $size = isset($_GET['size']) ? (int)$_GET['size'] : 0;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }

    if (strpos($type, " - ") !== false) {
        list($storageType, $connector) = explode(" - ", $type, 2);
    } else {
        die(json_encode(["error" => "Invalid storage type format"]));
    }

    $sql = $conn->prepare("
        SELECT price 
        FROM drives d
        WHERE storageType = ? 
        AND connector = ? 
        AND vendorName = ? 
        AND capacity = ?
    ");

    $sql->bind_param("sssi", $storageType, $connector, $brand, $size);
    $sql->execute();
    $result = $sql->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["price" => number_format($row['price'], 2)]);
    } else {
        echo json_encode(["error" => "No matching storage drive found"]);
    }

    $sql->close();
    $conn->close();
?>
