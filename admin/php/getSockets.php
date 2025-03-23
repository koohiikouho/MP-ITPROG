<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT *
            FROM ref_sockets;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a socket</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['socketID'] . "'>" . $row['socketName']  . "</option>";
        }
    } else {
        echo "<option disabled>No sockets available</option>";
    }

    $conn->close();

?>