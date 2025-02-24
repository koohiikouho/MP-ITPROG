<?php
    $brand = $_GET['brand'];
    $size = $_GET['size'];
    $ddrversion = $_GET['ddrversion'];
    $sortby = $_GET['sortby'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql;

    if ($sortby == "price") {
        $sql = "SELECT m.mem_id, rf.vendorname, m.size, m.price
                FROM ref_vendors rf
                JOIN memorysticks m ON m.vendorcode=rf.mbid
                WHERE m.vendorcode='$brand' AND m.size='$size' AND m.ddrversion='$ddrversion'
                ORDER BY m.price ASC;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a Memory Stick</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['mem_id'] . "'>" . $row['vendorname'] . " " . $row['size'] . " GB" . " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No Memorys match filter</option>";
        }

    } elseif ($sortby == "popularity") {
        $sql = "SELECT m.mem_id, rf.vendorname, m.size, COUNT(b.mem_id) AS popularity
                FROM ref_vendors rf
                JOIN memorysticks m ON m.vendorcode=rf.mbid
                LEFT JOIN builds b ON m.mem_id = m.mem_id
                WHERE m.vendorcode='$brand' AND m.size='$size' AND m.ddrversion='$ddrversion'
                HAVING COUNT(b.mem_id) > 0
                ORDER BY popularity DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a Memory Stick</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['mem_id'] . "'>" . $row['vendorname'] . " " . $row['size'] . " GB" . " -  Used by " . $row['popularity'] . " build/s" . "</option>";
            }
        } else {
            echo "<option disabled selected>No Memorys match filter</option>";
        }
    }

    $conn->close();
?>