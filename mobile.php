<?php

include 'db_connect.php';
function fetchDevices($pdo, $filters)
{
    $sql = "SELECT * FROM mobiles";
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

    if (!empty($filters['display'])) {
        $sql .= " AND display_size >= :display";
        $params[':display'] = $filters['display'];
    }

    if (!empty($filters['rating'])) {
        $sql .= " AND rating >= :rating";
        $params[':rating'] = $filters['rating'];
    }

    if (!empty($filters['camera'])) {
        $sql .= " AND camera >= :camera";
        $params[':camera'] = $filters['camera'];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$filters = [
    'search' => $_POST['searchBar'] ?? '',
    'brand' => $_POST['brandFilter'] ?? '',
    'price' => $_POST['priceFilter'] ?? '',
    'battery' => $_POST['batteryFilter'] ?? '',
    'os' => $_POST['osFilter'] ?? '',
    'display' => $_POST['displayFilter'] ?? '',
    'rating' => $_POST['starFilter'] ?? '',
    'camera' => $_POST['cameraFilter'] ?? '',
];

$devices = fetchDevices($pdo, $filters);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Specifications</title>
    <link rel="stylesheet" href="./css/mobile.css">
</head>

<body>
    <header>
        <h1>Mobile Specifications</h1>
        <input type="text" id="searchBar" placeholder="Search by model or brand..." oninput="filterDevices()">
        <button class="filter-toggle" onclick="toggleFilterMenu()">Filters</button>
    </header>

    <div class="filter-menu">
        <div class="filters">
            <label for="brandFilter">Brand:</label>
            <select id="brandFilter" onchange="filterDevices()">
                <option value="">All</option>
                <option value="Apple">Apple</option>
                <option value="Samsung">Samsung</option>
                <option value="Google">Google</option>
            </select>

            <label for="priceFilter">Price:</label>
            <select id="priceFilter" onchange="filterDevices()">
                <option value="">All</option>
                <option value="0-500">$0 - $500</option>
                <option value="500-1000">$500 - $1000</option>
                <option value="1000-1500">$1000 - $1500</option>
                <option value="1500-2000">$1500 - $2000</option>
            </select>

            <label for="batteryFilter">Battery Capacity (mAh):</label>
            <select id="batteryFilter" onchange="filterDevices()">
                <option value="">All</option>
                <option value="3000">3000+</option>
                <option value="4000">4000+</option>
                <option value="5000">5000+</option>
            </select>

            <label for="osFilter">Operating System:</label>
            <select id="osFilter" onchange="filterDevices()">
                <option value="">All</option>
                <option value="iOS">iOS</option>
                <option value="Android">Android</option>
            </select>

            <label for="displayFilter">Display Size:</label>
            <select id="displayFilter" onchange="filterDevices()">
                <option value="">All</option>
                <option value="6.0">6.0 inches+</option>
                <option value="6.5">6.5 inches+</option>
                <option value="7.0">7.0 inches+</option>
            </select>

            <label for="starFilter">Minimum Star Rating:</label>
            <select id="starFilter" onchange="filterDevices()">
                <option value="">All Ratings</option>
                <option value="4.5">4.5 Stars & Up</option>
                <option value="4">4 Stars & Up</option>
                <option value="3.5">3.5 Stars & Up</option>
                <option value="3">3 Stars & Up</option>
            </select>

            <label for="cameraFilter">Camera:</label>
            <select id="cameraFilter" onchange="filterDevices()">
                <option value="">All</option>
                <option value="12">12MP+</option>
                <option value="50">50MP+</option>
                <option value="108">108MP+</option>
            </select>
        </div>
    </div>

    <main id="deviceList">
        <?php if ($devices): ?>
            <?php foreach ($devices as $device): ?>
                <div class="device-card">
                    <div class="device-image">
                        <img src="<?php echo htmlspecialchars($device['image_path']); ?>" alt="<?php echo htmlspecialchars($device['brand'] . ' ' . $device['model']); ?> Image">
                    </div>
                    <div class="device-info">
                        <h3><?php echo htmlspecialchars($device['brand'] . ' ' . $device['model']); ?></h3>
                        
                        <p><strong>Price:</strong> $<?php echo htmlspecialchars($device['price']); ?></p>
                        <p><strong>Display:</strong> <?php echo htmlspecialchars($device['display_size']); ?> inches</p>
                        <p><strong>Camera:</strong> <?php echo htmlspecialchars($device['camera']); ?> MP</p>
                        <p><strong>Battery:</strong> <?php echo htmlspecialchars($device['battery']); ?> mAh</p>
                        <p><strong>Operating System:</strong> <?php echo htmlspecialchars($device['os']); ?></p>
                        <p><strong>Rating:</strong> <span class="stars"><?php echo str_repeat('★', $device['rating']); ?></span></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No devices found matching the criteria.</p>
        <?php endif; ?>
    </main>

    <script src="./javascript/mobile.js"></script>
</body>

</html>
