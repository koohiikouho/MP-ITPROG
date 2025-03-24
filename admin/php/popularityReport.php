<?php
header("Content-Type: application/json"); // Ensure JSON response

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$components = [
    "Processors" => "SELECT p.name, p.vendorCode, p.cpu_id, COUNT(b.cpu_id) AS popularity, p.price
                     FROM processors p
                     LEFT JOIN builds b ON b.cpu_id = p.cpu_id
                     WHERE p.isDeleted = '0'
                     GROUP BY p.name, p.cpu_id, p.price
                     ORDER BY popularity DESC;",
                     
    "Motherboards" => "SELECT m.name, m.vendorCode, m.mob_id, COUNT(b.mobo_id) AS popularity, m.price
                       FROM motherboards m
                       LEFT JOIN builds b ON b.mobo_id = m.mob_id
                       WHERE m.isDeleted = '0'
                       GROUP BY m.name, m.mob_id, m.price
                       ORDER BY popularity DESC;",
    /*             
    "Memory Sticks" => "SELECT m.mem_id, rf.vendorname, m.size, m.price, COUNT(b.mem_id) AS popularity
                        FROM ref_vendors rf
                        JOIN memorysticks m ON m.vendorcode = rf.mbid
                        LEFT JOIN builds b ON b.mem_id = m.mem_id
                        WHERE m.isDeleted = '0'
                        GROUP BY m.mem_id, rf.vendorname, m.size, m.price
                        ORDER BY popularity DESC;",
                        
    "Video Cards" => "SELECT v.gpu_id, rv.vendorName, v.model, v.price, COUNT(b.gpu_id) AS popularity
                      FROM videocards v
                      JOIN ref_vendors rv ON v.vendorCode = rv.mbid
                      LEFT JOIN builds b ON b.gpu_id = v.gpu_id
                      WHERE v.isDeleted = '0'
                      GROUP BY v.gpu_id, v.price, rv.vendorName, v.model
                      ORDER BY popularity DESC;",
                      
    "Power Supplies" => "SELECT p.psu_id, rf.vendorname, p.wattage, p.efficiency, p.price, COUNT(b.psu_id) AS popularity
                         FROM powersupplies p
                         JOIN ref_vendors rf ON rf.mbid = p.vendorcode
                         LEFT JOIN builds b ON b.psu_id = p.psu_id
                         WHERE p.isDeleted = '0'
                         GROUP BY p.psu_id, rf.vendorname, p.wattage, p.efficiency, p.price
                         ORDER BY popularity DESC;",
   
    "Storage Drives" => "SELECT d.drv_id, COUNT(b.drv_id) AS popularity, d.price, d.capacity
                         FROM drives d
                         LEFT JOIN builds b ON b.drv_id = d.drv_id
                         WHERE d.isDeleted = '0'
                         GROUP BY d.drv_id, d.price, d.capacity
                         ORDER BY popularity DESC;",

    "Cases" => "SELECT c.cse_id, rv.vendorName, c.name, c.price, COUNT(b.cse_id) AS popularity 
                FROM cases c 
                JOIN ref_vendors rv ON rv.mbid = c.vendorCode 
                LEFT JOIN builds b ON b.cse_id = c.cse_id 
                WHERE c.isDeleted = '0' 
                GROUP BY c.cse_id, rv.vendorName, c.name, c.price 
                ORDER BY popularity DESC;"
                
    */
];

$report = "Most Popular Components Report\n\n";

foreach ($components as $category => $query) {
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $report .= "==== $category ====\n";
        $report .= "ID | Vendor | Name | Price | Popularity\n";
        $report .= str_repeat("-", 50) . "\n";

        while ($row = $result->fetch_assoc()) {
            $id = $row["cpu_id"] ?? $row["mob_id"] ?? $row["mem_id"] ?? $row["gpu_id"] ?? "N/A";
            $vendor = $row["vendorCode"] ?? $row["vendorCode"] ?? "N/A";
            $name = $row["name"] ?? $row["model"] ?? ($row["size"] . " GB" ?? "N/A");
            $price = isset($row["price"]) ? "$" . number_format($row["price"], 2) : "N/A";
            $popularity = $row["popularity"] ?? "N/A";

            $report .= "$id | $vendor | $name | $price | $popularity\n";
        }
    }
}

$conn->close();

echo json_encode(["status" => "success", "message" => $report]);
?>
