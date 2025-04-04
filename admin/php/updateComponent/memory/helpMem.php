    <?php
    
    include '../../dbcred.php';
    $memID = $_GET['mem_id'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT *
            FROM memorysticks m
            JOIN ref_vendors rf ON rf.mbid = m.vendorCode
            WHERE MEM_ID='$memID';";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mbid = $row['vendorCode'];
            $vendor = $row['vendorName'];
            $size = $row['size'];
            $ddr = $row['ddrVersion'];
            $price = $row['price'];
        }
    } else {
        echo "<option disabled>No memory available</option>";
    }

    $conn->close();

?>
<div class="mb-3">

<label class="form-label" id="memID">Mem ID</label>
<input type="number" class="form-control" name="MEM_ID" value="<?php echo $memID;?>" readonly>
</div>

<div class="mb-3">
<label class="form-label" for="updmemBrand">Vendor</label>

    <select class="form-control" id="updmemBrand" name="vendorCode" required> 
       
    <?php 

            include '../../getVendor.php';
            echo "<option value='" . $mbid . "' selected hidden>" . $vendor . "</option>";
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