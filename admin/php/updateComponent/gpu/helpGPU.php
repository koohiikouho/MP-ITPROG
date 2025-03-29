<?php
    
    include '../../dbcred.php';
    $stoID = $_GET['gpu_id'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM videocards WHERE GPU_ID='$stoID';";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $model = $row['model'];
            $price = $row['price'];
        }
    } else {
        echo "<option disabled>No memory available</option>";
    }

    $conn->close();

?>

    <label class="form-label" id="stoID">PSU ID</label>
    <input type="number" class="form-control" name="GPU_ID" value="<?php echo $stoID;?>" readonly>
    </div>
                                
    <div class="mb-3">
        <label class="form-label" for="updBrand">Brand Code</label> 
        <select class="form-control" id="updBrand" name="brandCode" required> 
            <?php
                include '../../getVendor.php';
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label" for="updBrand">Vendor Code</label> 
        <select class="form-control" id="updBrand" name="vendorCode" required> 
            <?php
                include '../../getVendor.php';
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Model</label>
        <input type="text" class="form-control" id="updstoSize" name="model" value="<?php echo $model;?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" id="updstoPrice" name="price" value="<?php echo $price;?>" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Update Component</button>