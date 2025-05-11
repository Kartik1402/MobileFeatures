<?php
include 'db_connect.php';


function fetchDevices($pdo, $filters)
{
    $sql = "SELECT * FROM mobiles WHERE 1=1";
    $params = [];

    if (!empty($filters['search'])) {
        $sql .= " AND (brand LIKE :search OR model LIKE :search)";
        $params[':search'] = '%' . $filters['search'] . '%';
    }

    if (!empty($filters['brand'])) {
        $sql .= " AND brand = :brand";
        $params[':brand'] = $filters['brand'];
    }

    if (!empty($filters['price'])) {
        list($minPrice, $maxPrice) = explode('-', $filters['price']);
        $sql .= " AND price BETWEEN :minPrice AND :maxPrice";
        $params[':minPrice'] = $minPrice;
        $params[':maxPrice'] = $maxPrice;
    }

    if (!empty($filters['battery'])) {
        $sql .= " AND battery >= :battery";
        $params[':battery'] = $filters['battery'];
    }

    if (!empty($filters['os'])) {
        $sql .= " AND os = :os";
        $params[':os'] = $filters['os'];
    }

    // Debugging: Log to check if display filter is applied correctly
    if (!empty($filters['display'])) {
        $sql .= " AND display_size >= :display_size";
        $params[':display_size'] = $filters['display'];
    } else {
        error_log("No display filter applied.");
    }

    if (!empty($filters['rating'])) {
        $sql .= " AND rating >= :rating";
        $params[':rating'] = $filters['rating'];
    }

    if (!empty($filters['camera'])) {
        $sql .= " AND camera >= :camera";
        $params[':camera'] = $filters['camera'];
    }

    // Debugging: Log SQL and params
    error_log("SQL Query: " . $sql);
    error_log("Parameters: " . print_r($params, true));

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Capture filters from GET request
$filters = [
    'search' => $_GET['search'] ?? '',
    'brand' => $_GET['brand'] ?? '',
    'price' => $_GET['price'] ?? '',
    'battery' => $_GET['battery'] ?? '',
    'os' => $_GET['os'] ?? '',
    'display' => $_GET['display_size'] ?? '',  // Ensure this is set correctly
    'rating' => $_GET['rating'] ?? '',
    'camera' => $_GET['camera'] ?? '',
];

// Debugging: Check incoming GET parameters
error_log("GET Parameters: " . print_r($_GET, true));

$devices = fetchDevices($pdo, $filters);

header('Content-Type: application/json');
echo json_encode($devices);
