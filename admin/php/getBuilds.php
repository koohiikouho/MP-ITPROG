<?php
    require './dbcred.php';
    error_reporting( E_ALL );
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM builds WHERE NOT isDeleted = '1'";
    $resultMain = $conn->query($sql);

    // Check if there are results
    if ($resultMain->num_rows > 0) {
        echo "<table class=\"table\">
                    <tr>
                        <th>Name</th>
                        <th>Processor</th>
                        <th>GPU</th>
                        <th>Motherboard</th>
                        <th>Memory</th>
                        <th>Storage</th>
                        <th>Case</th>
                        <th>PSU</th>
                        <th><th>
                    </tr>


                ";
        while ($rowMain = $resultMain->fetch_assoc()) {
            echo ("<tr>");
            
            $cpuID = $rowMain['cpu_id'];
            $moboID = $rowMain['mobo_id'];
            $memQty = $rowMain['memQty'];
            $memID = $rowMain['mem_id'];
            $drv_ID = $rowMain['drv_id'];
            $cseID = $rowMain['cse_id'];
            $psuID = $rowMain['psu_id'];
            $gpuID = $rowMain['gpu_id'];

            echo ("<td>" . $rowMain['name'] . "</td>");

            $query = "SELECT * FROM processors p JOIN ref_vendors rv ON p.vendorCode = rv.mbid WHERE CPU_ID='$cpuID'";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo"<td>";
                echo($row['vendorName'] . " " . $row['name']);
                echo"</td>";
            }
            
            $query = "SELECT * FROM videocards v JOIN ref_vendors rv ON v.brandCode = rv.mbid WHERE GPU_ID='$gpuID' ";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo"<td>";
                echo($row['vendorName'] . " " . $row['model']);
                echo"</td>";
            }
    
            $query = "SELECT * FROM motherboards m JOIN ref_vendors rv ON m.vendorCode = rv.mbid WHERE MOB_ID='$moboID' ";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo"<td>";

                echo($row['vendorName'] . " " . $row['chipset'] . " " . $row['name']);
                echo"</td>";
            }
    
            $query = "SELECT * FROM memorysticks m JOIN ref_vendors rv ON m.vendorCode = rv.mbid WHERE MEM_ID='$memID' ";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo"<td>";
                echo($row['vendorName'] . " " . $row['size'] . "GB DDR" . $row['ddrVersion'] . " x " . $memQty);
                echo"</td>";
            }
    
            $query = "SELECT * FROM drives m JOIN ref_vendors rv ON m.vendorName = rv.mbid WHERE DRV_ID='$drv_ID' ";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo"<td>";
                echo($row['vendorName'] . " " . $row['capacity'] . "GB " . $row['connector'] . " " . $row['storageType']);
                echo"</td>";
            }

            $query = "SELECT * FROM powersupplies m JOIN ref_vendors rv ON m.vendorCode = rv.mbid WHERE PSU_ID='$psuID' ";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo"<td>";
                echo($row['vendorName'] . " " . $row['wattage'] . "W " . $row['efficiency']);
                echo"</td>";
            }

            $query = "SELECT * FROM cases m JOIN ref_vendors rv ON m.vendorCode = rv.mbid WHERE CSE_ID='$cseID' ";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo"<td>";
                echo($row['vendorName'] . " " . $row['name']);
                echo"</td>";
            }
    

    
            echo"<td>";
            echo"<button class=\"btn btn-danger\" onclick=\"delBuild(" . $rowMain['build_id'] . ")\">Delete</button>";
            echo"<td>";
            echo ("</tr>");

        }
        echo ("</table>");
    } else {
        echo "No rows to return";
    }

    $conn->close();

?>