<?php
    $brand = isset($_GET['brand']) ? $_GET['brand'] : '';
    $chipset = isset($_GET['chipset']) ? $_GET['chipset'] : '';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = $conn->prepare("SELECT mob_id, name FROM motherboards WHERE vendorCode = ? AND chipset = ?");
    $sql->bind_param("ss", $brand, $chipset);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        echo "<option value='' disabled selected>Select a Motherboard</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['mob_id'] . "'>" . $row['name'] . "</option>";
        }
    } else {
        echo "<option disabled selected>No Motherboards match filter</option>";
    }

    $sql->close();
    $conn->close();
?>
