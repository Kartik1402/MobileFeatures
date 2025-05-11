<?php
require_once 'db_connect.php';
$device1Data = [];
$device2Data = [];
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $device1Name = trim($_POST['device1'] ?? '');
    $device2Name = trim($_POST['device2'] ?? '');

    if (!preg_match('/^[a-zA-Z0-9\s\-]+$/', $device1Name)) {
        $errorMessages[] = "Invalid input for Device 1.";
        $device1Name = '';
    }
    if (!preg_match('/^[a-zA-Z0-9\s\-]+$/', $device2Name)) {
        $errorMessages[] = "Invalid input for Device 2.";
        $device2Name = '';
    }

    if (empty($errorMessages)) {
        if ($device1Name) {
            $stmt = $pdo->prepare("SELECT * FROM mobiles WHERE model = :deviceName LIMIT 1");
            $stmt->execute(['deviceName' => $device1Name]);
            $device1Data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$device1Data) {
                $device1Data = ['model' => 'Device not found', 'image_path' => 'default-image.jpg'];
            }
        }

        if ($device2Name) {
            $stmt = $pdo->prepare("SELECT * FROM mobiles WHERE model = :deviceName LIMIT 1");
            $stmt->execute(['deviceName' => $device2Name]);
            $device2Data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$device2Data) {
                $device2Data = ['model' => 'Device not found', 'image_path' => 'default-image.jpg'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Comparison</title>
    <link rel="stylesheet" href="./css/comparison.css">
    <style>
        .device-image {
            width: 200px;
            height: auto;
            object-fit: contain;
        }
        .reset-button {
            margin-top: 20px;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">MobileCompare</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#" onclick="document.getElementById('comparisonForm').submit(); return false;">Compare</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section id="compare" class="comparison-section">
        <h2>Compare Mobile Devices</h2>

        <!-- Display Errors -->
        <?php if (!empty($errorMessages)): ?>
            <div class="error-messages">
                <?php foreach ($errorMessages as $message): ?>
                    <p class="error-message"><?php echo htmlspecialchars($message, ENT_QUOTES); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form id="comparisonForm" method="POST" action="comparison.php" class="comparison-selectors">
            <div class="dropdown">
                <input type="text" name="device1" placeholder="Search Device 1" value="<?php echo htmlspecialchars($device1Name ?? '', ENT_QUOTES); ?>">
                <div id="device1" class="dropdown-content"></div>
            </div>
            <div class="dropdown">
                <input type="text" name="device2" placeholder="Search Device 2" value="<?php echo htmlspecialchars($device2Name ?? '', ENT_QUOTES); ?>">
                <div id="device2" class="dropdown-content"></div>
            </div>
        </form>

        <?php if (!empty($device1Data) && !empty($device2Data)): ?>
            <div id="comparisonTable" class="comparison-table">
                <div class="spec">Specification</div>
                <div class="value"><?php echo htmlspecialchars($device1Data['model'] ?? 'Device 1', ENT_QUOTES); ?></div>
                <div class="value"><?php echo htmlspecialchars($device2Data['model'] ?? 'Device 2', ENT_QUOTES); ?></div>

                <div class="spec">📸 Image</div>
                <div class="value">
                    <img src="<?php echo htmlspecialchars($device1Data['image_path'] ?? 'default-image.jpg', ENT_QUOTES); ?>" class="device-image" alt="Device 1 Image">
                </div>
                <div class="value">
                    <img src="<?php echo htmlspecialchars($device2Data['image_path'] ?? 'default-image.jpg', ENT_QUOTES); ?>" class="device-image" alt="Device 2 Image">
                </div>

                <?php
                $specs = [
                    'processor' => ['icon' => '🖥️', 'label' => 'Processor'],
                    'ram' => ['icon' => '💾', 'label' => 'RAM'],
                    'storage' => ['icon' => '📦', 'label' => 'Storage'],
                    'battery' => ['icon' => '🔋', 'label' => 'Battery'],
                    'camera' => ['icon' => '📷', 'label' => 'Camera'],
                    'price' => ['icon' => '💲', 'label' => 'Price'],
                    'rating' => ['icon' => '⭐', 'label' => 'Rating']
                ];

                foreach ($specs as $key => $spec):
                    $icon = $spec['icon'];
                    $label = $spec['label'];
                    $device1Value = htmlspecialchars($device1Data[$key] ?? 'N/A', ENT_QUOTES);
                    $device2Value = htmlspecialchars($device2Data[$key] ?? 'N/A', ENT_QUOTES);
                ?>
                    <div class="spec"><?php echo $icon . ' ' . $label; ?></div>
                    <div class="value"><?php echo $device1Value; ?></div>
                    <div class="value"><?php echo $device2Value; ?></div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Please select two devices to compare.</p>
        <?php endif; ?>

        <button id="resetButton" class="reset-button" onclick="window.location.href='comparison.php'">Reset Comparison</button>
    </section>

    <footer>
        <p>&copy; 2024 MobileCompare. All rights reserved.</p>
    </footer>
</body>
</html>
