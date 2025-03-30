<?php
    
    include '../../dbcred.php';
    $cpuID = $_GET['cpu_id'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT *
            FROM processors p
            JOIN ref_vendors rf ON rf.mbid = p.vendorCode
            JOIN ref_sockets rs ON rs.socketID=p.socketID
            WHERE CPU_ID='$cpuID';";

    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $mbid = $row['vendorCode'];
            $vendor = $row['vendorName'];
            $cores = $row['cores'];
            $threads = $row['threads'];
            $baseClock = $row['baseClock'];
            $socketId = $row['socketID'];
            $socketName = $row['socketName'];
            $price = $row['price'];
        }
    } else {
        echo "<option disabled>No memory available</option>";
    }

    $conn->close();

?>
<div class="mb-3">

<label class="form-label" id="cpuID">CPU ID</label>
<input type="number" class="form-control" name="CPU_ID" value="<?php echo $cpuID;?>" readonly>
</div>

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" id="updcpuName" name="name" value="<?php echo $name;?>" required>
</div>

<div class="mb-3">
<label class="form-label" for="updmemBrand">Vendor</label>

    <select class="form-control" id="updcpuBrand" name="vendorCode" required> 
    <?php 
            include '../../getVendor.php';
            echo "<option value='" . $mbid . "' selected hidden>" . $vendor . "</option>";
        ?>

    </select>
</div>

<div class="mb-3">
    <label class="form-label">Cores</label>
    <input type="number" class="form-control" id="updmemDDR" name="cores" value="<?php echo $cores;?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Threads</label>
    <input type="number" class="form-control" id="updmemSize" name="threads" value="<?php echo $threads;?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Base Clock</label>
    <input type="number" class="form-control" id="updmemPrice" name="baseClock" value="<?php echo $baseClock;?>" required>
</div>

<div class="mb-3">
        <label class="form-label" for="updmoboSock" >Socket</label> 
        <select class="form-control" id="updmoboSock" name="Socket" required> 
            <?php
                include '../../getSockets.php';
                echo "<option value='" . $socketID . "' selected hidden>" . $socketName . "</option>";
            ?>
        </select>
    </div>

<div class="mb-3">
    <label class="form-label">Price</label>
    <input type="number" class="form-control" id="updmemPrice" name="price" value="<?php echo $price;?>" required>
</div>

<button type="submit" class="btn btn-success w-100">Update Component</button>