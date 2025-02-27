<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    
    $query = "SELECT MAX(build_id) FROM builds";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            echo("Build Number: " . $row['MAX(build_id)']);
        }

    } else {
        echo "Error";
    }

    $conn ->close();

?>
