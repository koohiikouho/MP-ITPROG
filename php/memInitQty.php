<?php
    $memSlots = $_GET['memSlots'];
    echo "<option value='' disabled selected>Select number of memory sticks</option>";
    
    for ($x = 1; $x <= $memSlots; $x++) {
        echo "<option value='$x'>$x sticks</option>";
    }
?>
