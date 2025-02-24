<?php

    $name = $_GET['name'];
    $caseId = $_GET['caseID'];
    $driveId = $_GET['drvID'];
    $memId = $_GET['memID'];
    $memQty = $_GET['memQty'];
    $moboId = $_GET['moboID'];
    $psuId = $_GET['psuID'];
    $cpuId = $_GET['cpuID'];
    $gpuId = $_GET['gpuID'];
    


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "INSERT INTO `builds` (`name`, `cse_id`, `drv_id`, `mem_id`, `memQty`, `mobo_id`, `psu_id`, `cpu_id`, `gpu_id`)
            VALUES ('$name', '$caseId', '$driveId', '$memId', '$memQty', '$moboId', '$psuId', '$cpuId', '$gpuId')";
    $result = $conn->query($sql);
    $conn->close();
?>