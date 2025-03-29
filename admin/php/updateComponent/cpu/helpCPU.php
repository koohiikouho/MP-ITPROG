<?php
    
    include '../../dbcred.php';
    $moboID = $_GET['cpu_id'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM processors WHERE CPU_ID='$moboID';";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $cores = $row['cores'];
            $threads = $row['threads'];
            $baseClock = $row['baseClock'];
            $socketID = $row['socketID'];
            $price = $row['price'];
        }
    } else {
        echo "<option disabled>No memory available</option>";
    }

    $conn->close();

?>
<div class="mb-3">

<label class="form-label" id="cpuID">CPU ID</label>
<input type="number" class="form-control" name="CPU_ID" value="<?php echo $moboID;?>" readonly>
</div>

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="number" class="form-control" id="updcpuName" name="Name" value="<?php echo $name;?>" required>
</div>

<div class="mb-3">
<label class="form-label" for="updmemBrand">Vendor</label>

    <select class="form-control" id="updcpuBrand" name="vendorCode" required> 
    <?php 
            include '../../getVendor.php';
        ?>

    </select>
</div>

<div class="mb-3">
    <label class="form-label">DDR Version</label>
    <input type="number" class="form-control" id="updmemDDR" name="ddrVersion" value="<?php echo $ddr;?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Size</label>
    <input type="number" class="form-control" id="updmemSize" name="size" value="<?php echo $size;?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Price</label>
    <input type="number" class="form-control" id="updmemPrice" name="Price" value="<?php echo $price;?>" required>
</div>

<button type="submit" class="btn btn-success w-100">Update Component</button>