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
        $stmt = $conn->prepare("SELECT m.mem_id, rf.vendorname, m.size, m.price
                        FROM ref_vendors rf
                        JOIN memorysticks m ON m.vendorcode = rf.mbid
                        WHERE m.vendorcode = ? 
                        AND m.size = ? 
                        AND m.ddrversion = ? 
                        AND m.isDeleted = '0'
                        ORDER BY m.price ASC");

        $stmt->bind_param("sss", $brand, $size, $ddrversion);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a Memory Stick</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['mem_id'] . "'>" . $row['vendorname'] . " " . $row['size'] . " GB" . " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No Memorys match filter</option>";
        }

    } elseif ($sortby == "popularity") {
        $stmt = $conn->prepare("SELECT m.mem_id, rf.vendorname, m.size, COUNT(b.mem_id) AS popularity
                                FROM ref_vendors rf
                                JOIN memorysticks m ON m.vendorcode=rf.mbid
                                LEFT JOIN builds b ON b.mem_id = m.mem_id
                                WHERE m.vendorcode = ? 
                                AND m.size = ? 
                                AND m.ddrversion =? 
                                AND m.isDeleted = '0'
                                GROUP BY m.mem_id, rf.vendorname, m.size
                                ORDER BY popularity DESC");

                $stmt->bind_param("sss", $brand, $size, $ddrversion);
                $stmt->execute();
                $result = $stmt->get_result();

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