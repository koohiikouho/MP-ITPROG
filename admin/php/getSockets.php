<?php
    require './checkValidSession.php';
    require './dbcred.php';

    checkValidSession();

   
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM ref_sockets";
    $result = $conn->query($sql);
    
    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a Socket for the CPU</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['socketID'] . "'>" . $row['socketName']  . "</option>";
        }
    } else {
        echo "<option disabled>Error: No socket found CHECK DB</option>";
    }

    $conn->close();

?>