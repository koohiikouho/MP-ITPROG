<?php
include '../../dbcred.php';
$moboid = $_GET['Mobo_ID'];
$name = $_GET['Name'];
$brand = $_GET['Brand'];
$socket = $_GET['Socket'];
$MemSlots = $_GET['MemSlots'];
$chipset = $_GET['Chipset'];
$price = $_GET['Price'];
$ddr = $_GET['DDR'];
$m2 = $_GET['M2'];

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "UPDATE motherboards SET vendorCode=?,socketID=?,ddrVersion=?,memSlots=?,m2Slots=?,chipset=?,`name`=?,price=? WHERE MOB_ID=?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("siiiisssf", $brand, $socket, $DDR, $MemSlots, $m2, $chipset, $name, $price );
$stmt->execute();
$conn->close();


?>
