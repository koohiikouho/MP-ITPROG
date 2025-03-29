<?php
    
    include '../../dbcred.php';
    $stoID = $_GET['psu_id'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM powersupplies WHERE PSU_ID='$stoID';";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wattage = $row['wattage'];
            $price = $row['price'];
            $efficiency = $row['efficiency'];
        }
    } else {
        echo "<option disabled>No memory available</option>";
    }

    $conn->close();

?>

    <label class="form-label" id="stoID">PSU ID</label>
    <input type="number" class="form-control" name="PSU_ID" value="<?php echo $stoID;?>" readonly>
    </div>
                                
    <div class="mb-3">
        <label class="form-label" for="updBrand">Vendor</label> 
        <select class="form-control" id="updBrand" name="vendor" required> 
            <?php
                include '../../getVendor.php';
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Wattage</label>
        <input type="number" class="form-control" id="updstoSize" name="wattage" value="<?php echo $wattage;?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Efficiency</label>
        <input type="text" class="form-control" id="updstoSize" name="efficiency" value="<?php echo $efficiency;?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" id="updstoPrice" name="price" value="<?php echo $price;?>" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Update Component</button>