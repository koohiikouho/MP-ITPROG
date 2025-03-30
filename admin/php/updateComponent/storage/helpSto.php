<?php
    
    include '../../dbcred.php';
    $stoID = $_GET['sto_id'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT d.*, rf.vendorName AS venName
            FROM drives d
            JOIN ref_vendors rf ON rf.mbid = d.vendorName
            WHERE DRV_ID='$stoID';";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mbid = $row['vendorName'];
            $vendor = $row['venName'];
            $capacity = $row['capacity'];
            $storageType = $row['storageType'];
            $connector = $row['connector'];
            $price = $row['price'];
        }
    } else {
        echo "<option disabled>No memory available</option>";
    }

    $conn->close();

?>

    <label class="form-label" id="stoID">DRV ID</label>
    <input type="number" class="form-control" name="STO_ID" value="<?php echo $stoID;?>" readonly>
    </div>
                                
    <div class="mb-3">
        <label class="form-label" for="updBrand">Vendor</label> 
        <select class="form-control" id="updBrand" name="vendor" required> 
            <?php
                include '../../getVendor.php';
                echo "<option value='" . $mbid . "' selected hidden>" . $vendor . "</option>";
            ?>
        
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Capacity</label>
        <input type="number" class="form-control" id="updstoSize" name="capacity" value="<?php echo $capacity;?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="updstoType">Storage Type</label> 
        <select class="form-control" id="updstoType" name="stoType" required> 
            <option value="HDD">HDD</option>
            <option value="HDD">SSD</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label" for="updstoConn">Connector Type</label> 
        <select class="form-control" id="updstoConn" name="connType" required> 
            <option value="M.2">M.2</option>
            <option value="SATA">SATA</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" id="updstoPrice" name="price" value="<?php echo $price;?>" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Update Component</button>