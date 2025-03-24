<?php
    include '../dbcred.php';
    $mbid = $_GET['vendorSelect'];
    $new_name = $_GET['vendorName'];

    
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "UPDATE ref_vendors SET vendorName=? WHERE mbid=?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $new_name, $mbid);
    $stmt->execute();
    $conn->close();
    header("Location:../../index.html");
    die();
        
?>