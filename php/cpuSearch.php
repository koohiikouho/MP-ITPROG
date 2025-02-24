<?php
    $brand = $_GET['brand'];
    $cores = $_GET['cores'];
    $sortby = $_GET['sortby'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Change sql query acc to sortby
    if ($sortby == "price") {
        $sql = "SELECT p.name, p.cpu_id, p.price
                FROM processors p
                WHERE vendorCode='$brand' AND cores='$cores'
                ORDER BY p.price ASC;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a CPU</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['cpu_id'] . "'>" . $row['name']  . " -  ₱" . number_format($row['price'], 2) . "</option>";
            }
        } else {
            echo "<option disabled selected>No CPUs match filter</option>";
        }

    } elseif ($sortby == "popularity") {
        $sql = "SELECT p.name, p.cpu_id, COUNT(b.cpu_id) AS popularity, p.price
                FROM processors p
                LEFT JOIN builds b ON b.cpu_id = p.cpu_id
                WHERE p.vendorCode = '$brand' AND p.cores = '$cores'
                GROUP BY p.name, p.cpu_id
                ORDER BY popularity DESC;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<option value='' disabled selected>Select a CPU</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['cpu_id'] . "'>" . $row['name']  . " -  Used by " . $row['popularity'] . " build/s" . "</option>";
            }
        } else {
            echo "<option disabled selected>No CPUs match filter</option>";
        }
    }

    $conn->close();
?>