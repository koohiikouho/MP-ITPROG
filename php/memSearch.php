<?php
    $brand = $_GET['brand'];
    $size = $_GET['size'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT m.mem_id, rf.vendorname, m.size
            FROM ref_vendors rf
            JOIN memorysticks m ON m.vendorcode=rf.mbid
            WHERE m.vendorcode='$brand' AND m.size='$size'";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a Memory Stick</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['mem_id'] . "'>" . $row['vendorname'] . " " . $row['size'] . " GB" . "</option>";
        }
    } else {
        echo "<option disabled selected>No Memory Stick matches filter</option>";
    }

    $conn->close();
?>