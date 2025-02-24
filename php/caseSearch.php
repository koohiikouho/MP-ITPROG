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

    $sql;

    if ($sortby == "price") {
        $sql = "SELECT c.cse_id, rv.vendorName, c.name, c.price
                FROM cases c
                JOIN ref_vendors rv ON rv.mbid = c.vendorCode
                WHERE c.vendorCode = '$brand'
                ORDER BY c.price ASC;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a case</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['cse_id'] . "'>" . $row['vendorName'] . " " .$row['name'] . " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No case matches filter</option>";
        }
    } elseif ($sortby == "popularity") {
        $sql = "SELECT c.cse_id, rv.vendorName, c.name, c.price, COUNT(b.cse_id) AS popularity
                FROM cases c
                JOIN ref_vendors rv ON rv.mbid = c.vendorCode
                LEFT JOIN builds b ON b.cse_id = c.cse_id
                WHERE c.vendorCode = '$brand'
                GROUP BY c.cse_id, rv.vendorName, c.name, c.price
                ORDER BY popularity DESC;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a case</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['cse_id'] . "'>" . $row['vendorName'] . " " .$row['name'] . " -  Used by " . $row['popularity'] . " build/s" . "</option>";
            }
        } else {
            echo "<option disabled selected>No case matches filter</option>";
        }
    }

    $conn->close();
?>