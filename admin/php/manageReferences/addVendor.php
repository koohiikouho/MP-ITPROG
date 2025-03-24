<?php
    include '../dbcred.php';
    $id = $_GET['venID'];
    $name = $_GET['venName'];

    $id = strtoupper($id);
    
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT * FROM ref_vendors WHERE mbid=? OR vendorName=?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $id, $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo("vendor name or mbid is not unique");
    } else {
        $sql = "INSERT INTO ref_vendors (mbid, vendorName) VALUES (?,?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $id, $name);
        $stmt->execute();
        $result = $stmt->get_result();
        header("Location:../../index.html");
    }

    $conn->close();

    die();
        
?>