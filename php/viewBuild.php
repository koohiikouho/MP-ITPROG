<?php

    $buildID = $_GET['buildID'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    
    $query = "SELECT * FROM builds WHERE build_id='$buildID' ";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            
            echo("Build Number: " . $row['build_id']);
            echo("<br>");
            echo("Build Name: " . $row['name']);
            $cpuID = $row['cpu_id'];
            $moboID = $row['mobo_id'];
            $memQty = $row['memQty'];
            $memID = $row['mem_id'];
            $drv_ID = $row['drv_id'];
            $cseID = $row['cse_id'];
            $psuID = $row['psu_id'];
            $gpuID = $row['gpu_id'];
        }


        $query = "SELECT * FROM processors p JOIN ref_vendors rv ON p.vendorCode = rv.mbid WHERE CPU_ID='$cpuID' ";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo("<br>");
            echo("CPU: " . $row['vendorName'] . " " . $row['name']);
        }

        $query = "SELECT * FROM videocards v JOIN ref_vendors rv ON v.brandCode = rv.mbid WHERE GPU_ID='$gpuID' ";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo("<br>");
            echo("GPU: " . $row['vendorName'] . " " . $row['model']);
        }

        $query = "SELECT * FROM motherboards m JOIN ref_vendors rv ON m.vendorCode = rv.mbid WHERE MOB_ID='$moboID' ";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo("<br>");
            echo("Motherboard: " . $row['vendorName'] . " " . $row['chipset'] . " " . $row['name']);
        }

        $query = "SELECT * FROM memorysticks m JOIN ref_vendors rv ON m.vendorCode = rv.mbid WHERE MEM_ID='$memID' ";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo("<br>");
            echo("Memory: " . $row['vendorName'] . " " . $row['size'] . "GB DDR" . $row['ddrVersion'] . " x " . $memQty);
            echo(" ( Total:" . ($row['size'] * 4 ) . "GB )" );
        }

        $query = "SELECT * FROM drives m JOIN ref_vendors rv ON m.vendorName = rv.mbid WHERE DRV_ID='$drv_ID' ";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo("<br>");
            echo("Storage: " . $row['vendorName'] . " " . $row['capacity'] . "GB " . $row['connector'] . " " . $row['storageType']);
        }

        $query = "SELECT * FROM cases m JOIN ref_vendors rv ON m.vendorCode = rv.mbid WHERE CSE_ID='$cseID' ";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo("<br>");
            echo("Case: " . $row['vendorName'] . " " . $row['name']);
        }

        $query = "SELECT * FROM powersupplies m JOIN ref_vendors rv ON m.vendorCode = rv.mbid WHERE PSU_ID='$psuID' ";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo("<br>");
            echo("PSU: " . $row['vendorName'] . " " . $row['wattage'] . "W " . $row['efficiency']);
        }

    } else {
        echo "<h1>Build doesn't exist</h1>";
    }

    $conn ->close();

?>
