<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpcpartspicker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$html = '<table class="table table-striped">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>ID</th>
                    <th>Vendor</th>
                    <th>Name/Model</th>
                    <th>Price</th>
                    <th>Popularity</th>
                </tr>
            </thead>
            <tbody>';

$components = [
    "Processors" => "SELECT p.name, rf.vendorname AS vendor, p.cpu_id AS id, COUNT(b.cpu_id) AS popularity, p.price
                     FROM ref_vendors rf
                     JOIN processors p ON p.vendorcode = rf.mbid
                     LEFT JOIN builds b ON b.cpu_id = p.cpu_id
                     WHERE p.isDeleted = '0'
                     GROUP BY p.name, p.cpu_id, p.price, rf.vendorname, p.vendorCode
                     ORDER BY popularity DESC;",
                     
    "Motherboards" => "SELECT m.name, rf.vendorname AS vendor, m.mob_id AS id, COUNT(b.mobo_id) AS popularity, m.price
                       FROM ref_vendors rf
                       JOIN motherboards m ON m.vendorcode = rf.mbid
                       LEFT JOIN builds b ON b.mobo_id = m.mob_id
                       WHERE m.isDeleted = '0'
                       GROUP BY m.name, m.mob_id, m.price, rf.vendorname, m.vendorCode
                       ORDER BY popularity DESC;",
                                    
    "Memory Sticks" => "SELECT m.mem_id AS id, rf.vendorname AS vendor, m.size AS name, m.price, COUNT(b.mem_id) AS popularity
                        FROM ref_vendors rf
                        JOIN memorysticks m ON m.vendorcode = rf.mbid
                        LEFT JOIN builds b ON b.mem_id = m.mem_id
                        WHERE m.isDeleted = '0'
                        GROUP BY m.mem_id, rf.vendorname, m.size, m.price
                        ORDER BY popularity DESC;",
                        
    "Video Cards" => "SELECT v.gpu_id AS id, rv.vendorName AS vendor, v.model AS name, v.price, COUNT(b.gpu_id) AS popularity
                      FROM videocards v
                      JOIN ref_vendors rv ON v.vendorCode = rv.mbid
                      LEFT JOIN builds b ON b.gpu_id = v.gpu_id
                      WHERE v.isDeleted = '0'
                      GROUP BY v.gpu_id, v.price, rv.vendorName, v.model
                      ORDER BY popularity DESC;",
                      
    "Power Supplies" => "SELECT p.psu_id AS id, rf.vendorname AS vendor, CONCAT(p.wattage, 'W ', p.efficiency) AS name, p.price, COUNT(b.psu_id) AS popularity
                         FROM powersupplies p
                         JOIN ref_vendors rf ON rf.mbid = p.vendorcode
                         LEFT JOIN builds b ON b.psu_id = p.psu_id
                         WHERE p.isDeleted = '0'
                         GROUP BY p.psu_id, rf.vendorname, p.wattage, p.efficiency, p.price
                         ORDER BY popularity DESC;",
   
    "Storage Drives" => "SELECT d.drv_id AS id, rf.vendorname AS vendor, CONCAT(d.capacity, 'GB') AS name, d.price, COUNT(b.drv_id) AS popularity
                         FROM ref_vendors rf
                         JOIN drives d ON d.vendorname = rf.mbid
                         LEFT JOIN builds b ON b.drv_id = d.drv_id
                         WHERE d.isDeleted = '0'
                         GROUP BY d.drv_id, d.price, d.capacity
                         ORDER BY popularity DESC;",

    "Cases" => "SELECT c.cse_id AS id, rv.vendorName AS vendor, c.name, c.price, COUNT(b.cse_id) AS popularity 
                FROM cases c 
                JOIN ref_vendors rv ON rv.mbid = c.vendorCode 
                LEFT JOIN builds b ON b.cse_id = c.cse_id 
                WHERE c.isDeleted = '0' 
                GROUP BY c.cse_id, rv.vendorName, c.name, c.price 
                ORDER BY popularity DESC;"
];

foreach ($components as $category => $query) {
    $html .= "<tr class='category-title'>
                <td colspan='6'><strong>{$category}</strong></td>
              </tr>";
    
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'] ?? 'N/A';
            $vendor = $row['vendor'] ?? 'N/A';
            $name = $row['name'] ?? 'N/A';
            $price = isset($row['price']) ? "$" . number_format($row['price'], 2) : 'N/A';
            $popularity = $row['popularity'] ?? '0';
            
            $html .= "<tr>
                        <td></td> <!-- Empty first column for alignment -->
                        <td>{$id}</td>
                        <td>{$vendor}</td>
                        <td>{$name}</td>
                        <td>{$price}</td>
                        <td>{$popularity}</td>
                      </tr>";
        }
    } else {
        $html .= "<tr><td colspan='6'>No data found for {$category}</td></tr>";
    }
}

$html .= "</tbody></table>";

$conn->close();

echo json_encode(["status" => "success", "html" => $html]);
?>