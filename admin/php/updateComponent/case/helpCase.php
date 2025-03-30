<?php
    
    include '../../dbcred.php';
    $cseID = $_GET['cse_id'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT *
            FROM cases c
            JOIN ref_vendors rf ON rf.mbid = c.vendorCode
            WHERE CSE_ID='$cseID';";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mbid = $row['vendorCode'];
            $vendor = $row['vendorName'];
            $capacity = $row['name'];
            $price = $row['price'];
        }
    } else {
        echo "<option disabled>No memory available</option>";
    }

    $conn->close();

?>

    <label class="form-label" id="caseID">CSE ID</label>
    <input type="number" class="form-control" name="CSE_ID" value="<?php echo $cseID;?>" readonly>
    </div>
                                
    <form id="updCaseForm">
    <div class="mb-3">
        <label class="form-label">Case Name</label>
        <input type="text" class="form-control" id="updCaseName" name="name" value="<?php echo $capacity?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="updCaseBrand">Vendor</label>
        <select class="form-control" id="updCaseBrand" name="vendorCode" required>
            <?php 
                include '../../getVendor.php';
                echo "<option value='" . $mbid . "' selected hidden>" . $vendor . "</option>";
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" id="updCasePrice" name="price"value="<?php echo $price?>"required>
    </div>

    <button type="submit" class="btn btn-success w-100">Update Component</button>