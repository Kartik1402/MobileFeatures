<?php
session_start();

$is_logged_in = isset($_SESSION['user_id']); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Features</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    
    <header>
        <button class="button" data-text="Awesome">
            <span class="actual-text">MobileFeatures</span>
            <span class="hover-text">MobileFeatures</span>
        </button>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="mobile.php">Devices</a></li>
                <li><a href="comparison.php">Comparisons</a></li>
                <li><a href="reviews.php">Reviews</a></li>
                <?php if (!$is_logged_in): ?>
                    <a href="sign_up.php" class="login-signup-btn"><button class="button1">Login / SIGN UP</button></a>
                <?php else: ?>
                    <a href="logout.php" class="logout-btn"><button class="button2">Logout</button></a>
                
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="carousel">
        <div class="carousel-slide">
            <img src = "./images/image 1.png" alt="Carousel Image 1">
            <img src="./images/iphone 16.png" alt="Carousel Image 2">
            <img src="./images/pixel_9.png" alt="Carousel Image 3">
            <img src="./images/samsung s23 fe.png" alt="Carousel Image 4">
        </div>
        <button class="carousel-btn prev" onclick="prevSlide()"></button>
        <button class="carousel-btn next" onclick="nextSlide()">&#10095;</button>
        <div class="carousel-indicators">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
        </div>
    </section>

    <section class="banner"style="text-align: center;" id="home">
        <div class="banner-content">
            <h1>Discover the Latest in Mobile Technology</h1>
            <p>Explore specifications, reviews, comparisons, and deals.</p>
            <button onclick="window.location.href='learn_more.html'">Learn More</button>

        </div>
    </section>

    <section class="features">
        <div class="feature-card">
            <img src="./images/robotic-hand.png" alt="Latest Technology">
            <h2>Latest Technology</h2>
            <p>Explore 5G, AI-powered cameras, and more.</p>
        </div>
        <div class="feature-card">
            <img src="./images/clipboard.png" alt="Specifications">
            <h2>Specifications</h2>
            <p>View detailed specifications for each model.</p>
        </div>
        <div class="feature-card">
            <img src="./images/comparison.png" alt="Price Comparison">
            <h2>Price Comparison</h2>
            <p>Find the best deals on top devices.</p>
        </div>
        <div class="feature-card">
            <img src="./images/customer-review.png" alt="User Reviews">
            <h2>User Reviews</h2>
            <p>See what others are saying.</p>
        </div>
    </section>

    
    <footer>
        <p>&copy; 2024 MobileFeatures</p>
        <div class="footer-links">
            <a href="#tel:+9328177782">Contact Us</a>
        </div>
    </footer>

    <script src="./javascript/script.js"></script>
</body>

</html>