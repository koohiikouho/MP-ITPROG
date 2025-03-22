<?php
    $brand = $_GET['brand'];
    $sortby = $_GET['sortby'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($sortby == "price") {
        $stmt = $conn->prepare("SELECT v.gpu_id, rv.vendorName, v.model, v.price
                        FROM videocards v
                        JOIN ref_vendors rv ON v.vendorCode = rv.mbid
                        WHERE v.brandCode = ? AND v.isDeleted ='0'
                        ORDER BY v.price ASC");

        $stmt->bind_param("s", $brand);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a GPU</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['gpu_id'] . "'>" 
                    . $row['vendorName'] . " - " 
                    . $row['model'] . 
                    " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No GPUs match filter</option>";
        }
    } elseif ($sortby == "popularity") {
        $stmt = $conn->prepare("SELECT v.gpu_id, rv.vendorName, v.model, v.price, COUNT(b.gpu_id) AS popularity
                FROM videocards v
                JOIN ref_vendors rv ON v.vendorCode = rv.mbid
                LEFT JOIN builds b ON b.gpu_id = v.gpu_id
                WHERE v.brandCode = ? AND v.isDeleted = '0'
                GROUP BY v.gpu_id, v.price
                ORDER BY popularity DESC;");

        $stmt->bind_param("s", $brand);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are results
        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a GPU</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['gpu_id'] . "'>" 
                    . $row['vendorName'] . " - " 
                    . $row['model'] . 
                    " -  Used by " . $row['popularity'] . " build/s" . "</option>";
            }
        } else {
            echo "<option disabled selected>No GPUs match filter</option>";
        }
    }

    $conn->close();
?>
