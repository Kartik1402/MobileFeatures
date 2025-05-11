<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Device Reviews</title>
    <link rel="stylesheet" href="./css/reviews.css">
</head>
<body>
<header class="header">
    <h1 class="logos">Mobile Device Reviews</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><button id="showModalBtn" class="nav-button review-button">Give Review</button></li>
        </ul>
    </nav>
</header>

<section class="reviews-section">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mobile_features";
    $port = 3380;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
        $user_name = $conn->real_escape_string($_POST['user_name']);
        $review_text = $conn->real_escape_string($_POST['review_text']);
        $model_name = $conn->real_escape_string($_POST['model_name']);
        $rating = (int)$_POST['rating'];

        $sql_insert = "INSERT INTO reviews (user_name, review_text, model_name, rating) VALUES ('$user_name', '$review_text', '$model_name', '$rating')";

        if ($conn->query($sql_insert) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?review_added=true");
            exit();
        } else {
            echo "<p class='error'>Error: " . $sql_insert . "<br>" . $conn->error . "</p>";
        }
    }

    $sql = "SELECT user_name, review_text, model_name, rating FROM reviews ORDER BY id DESC";
    $result = $conn->query($sql);

    // Display reviews
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='review-card'>";
            echo "<h3 class='model-name'>" . htmlspecialchars($row["model_name"]) . "</h3>";
            echo "<p class='user-name'><strong>Review by:</strong> " . htmlspecialchars($row["user_name"]) . "</p>";
            echo "<div class='rating'>" . str_repeat("⭐", intval($row["rating"])) . "</div>";
            echo "<p class='review-text'>" . htmlspecialchars($row["review_text"]) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p class='no-reviews'>No reviews available yet.</p>";
    }

    $conn->close();

    if (isset($_GET['review_added']) && $_GET['review_added'] == 'true') {
        echo "<p class='success-message'>Review added successfully!</p>";
    }
    ?>
</section>

<!-- Modal for Review Form -->
<div id="reviewModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
        <h2 class="modal-header">Submit a Review</h2>
        <form method="POST" action="">
            <label for="user_name">Your Name:</label>
            <input type="text" id="user_name" name="user_name" required>

            <label for="model_name">Device Model:</label>
            <input type="text" id="model_name" name="model_name" required>

            <label for="rating">Rating (1 to 5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>

            <label for="review_text">Review:</label>
            <textarea id="review_text" name="review_text" rows="4" required></textarea>

            <button type="submit" name="submit_review" class="submit-button">Submit Review</button>
        </form>
    </div>
</div>

<script src =./javascript/reviews.js>
</script>

</body>
</html>
