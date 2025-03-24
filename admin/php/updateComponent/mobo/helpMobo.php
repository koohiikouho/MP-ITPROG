<?php
    include '../../dbcred.php';
    $moboID = $_GET['mobo_id'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM motherboards WHERE MOB_ID='$moboID';";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $price = $row['price'];
            $chipset = $row['chipset'];
            $m2slots = $row['m2Slots'];
            $ddrVersion = $row['ddrVersion'];
            $memSlots = $row['memSlots'];
        }
    } else {
        echo "<option disabled>No sockets available</option>";
    }

    $conn->close();

?>
    <div class="mb-3">
    <label class="form-label" id="moboID">Mobo ID</label>
    <input type="number" class="form-control" name="moboID" value="<?php echo $moboID;?>" readonly>
    </div>
    
    <div class="mb-3">
    <label class="form-label" id="editVendorForm" >Mobo Name</label>
        <input type="text" class="form-control" id="updmoboName" name="Name" value="<?php echo $name;?>"required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="updmoboBrand" >Vendor</label> 
        <select class="form-control" id="updmoboBrand" name="Brand" required> 
            <?php
                include '../../getVendor.php';
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label" for="updmoboSock" >Socket</label> 
        <select class="form-control" id="updmoboSock" name="Socket" required> 
            <?php
                include '../../getSockets.php';
            ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">DDR Version</label>
        <input type="number" class="form-control" id="updmoboDDR" name="DDR" value="<?php echo $ddrVersion;?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Memory Slots</label>
        <input type="number" class="form-control" id="updmoboMemSlots" name="MemSlots" value="<?php echo $memSlots;?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">M.2 Slots</label>
        <input type="number" class="form-control" id="updmoboM2Slots" name="M2" value="<?php echo $m2slots;?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Chipsets</label>
        <input type="text" class="form-control" id="updmoboChipset" name="Chipset" value="<?php echo $chipset;?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" id="updmoboPrice" name="Price"value="<?php echo $price;?>" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Update Component</button>