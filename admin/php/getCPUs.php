<?php
    include './dbcred.php';
    
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT c.CPU_ID, rv.vendorName, c.name, c.cores, c.threads,c.baseClock, c.socketID, c.price
            FROM processors c
            JOIN ref_vendors rv ON c.vendorCode = rv.mbid
            WHERE c.isDeleted = 0;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        echo "<table border='1' class='table'>
        <tr>
            <th>CPU_ID</th>
            <th>Vendor</th>
            <th>Name</th>
            <th>Cores</th>
            <th>Threads</th>
            <th>Base Clock</th>
            <th>Socket ID</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr id=\"trcpu" . $row['CPU_ID'] . "\">";
        echo "<td>{$row['CPU_ID']}</td>";
        echo "<td>{$row['vendorName']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['cores']}</td>";
        echo "<td>{$row['threads']}</td>";
        echo "<td>{$row['baseClock']}</td>";
        echo "<td>{$row['socketID']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "<td><button class=\"btn btn-danger\" onclick=\"delCPUs(" . $row['CPU_ID'] . ")\">Delete</button>";
        echo "   ";
        echo "<button class='btn btn-primary ml-2' data-bs-toggle='modal' data-bs-target='#updateCPUModal' onclick=\"helpSto({$row['CPU_ID']});\" \>Update</button></td>";
        echo "</tr>";
    }

        echo "</table>";
    } else {
        echo "No case data found.";}



        /* echo "<option value='' disabled selected>Select a CPU</option>";
            while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['CPU_ID'] . "'>" . $row['CPU_ID'] . " - " .$row['vendorName'] . " - " . $row['name'] . "</option>";
        }
    } else {

        echo "<option disabled>No CPUs available</option>";
    } */ 

    $conn->close();
?>