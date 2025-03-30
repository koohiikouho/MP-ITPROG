<?php
    
    include '../../dbcred.php';
    $gpuID = $_GET['gpu_id'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT v.*, 
            rv1.mbid AS mbidVendor, 
            rv1.vendorName AS vendorName, 
            rv2.mbid AS mbidBrand, 
            rv2.vendorName AS brandName
            FROM videocards v
            LEFT JOIN ref_vendors rv1 ON rv1.mbid = v.vendorCode
            LEFT JOIN ref_vendors rv2 ON rv2.mbid = v.brandCode
            WHERE v.GPU_ID = '$gpuID';";

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mbidBrand = $row['mbidBrand'];
            $brand = $row['brandName'];
            $mbidVendor = $row['mbidVendor'];
            $vendor = $row['vendorName'];
            $model = $row['model'];
            $price = $row['price'];
        }
    } else {
        echo "<option disabled>No memory available</option>";
    }

    $conn->close();

?>

    <label class="form-label" id="gpuID">GPU ID</label>
    <input type="number" class="form-control" name="GPU_ID" value="<?php echo $gpuID;?>" readonly>
    </div>
                                
    <div class="mb-3">
        <label class="form-label" for="updBrand">Brand Code</label> 
        <select class="form-control" id="updBrand" name="brandCode" required> 
            <?php
                include '../../getVendor.php';
                echo "<option value='" . $mbidBrand . "' selected hidden>" . $brand . "</option>";
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label" for="updBrand">Vendor Code</label> 
        <select class="form-control" id="updBrand" name="vendorCode" required> 
            <?php
                include '../../getVendor.php';
                echo "<option value='" . $mbidVendor . "' selected hidden>" . $vendor . "</option>";
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