<?php
session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mobile_features";
    $port = 3380;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle login
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query the database to check credentials
        $sql = "SELECT * FROM signup WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {      
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['user_id'];        
            echo "<script>
                    alert('Login successful!');
                    window.location.href = 'index.php';  
                  </script>";
            exit();  
        } else {
            $login_error = "Invalid username or password!";
        }
    }

    // Handle Signup
    if (isset($_POST['signup'])) {
        $new_username = $_POST['new_username'];
        $email = $_POST['email'];
        $new_password = $_POST['new_password'];

        // Check if the username or email already exists in the database
        $check_sql = "SELECT * FROM signup WHERE username = '$new_username' OR email = '$email'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $signup_error = "Username or Email already exists!";
        } else {
            // Insert new user into the database
            $insert_sql = "INSERT INTO signup (username, email, password) VALUES ('$new_username', '$email', '$new_password')";
            if ($conn->query($insert_sql) === TRUE) {
                $_SESSION['user_id'] = $conn->insert_id;  // Store the new user_id in session
                header('Location: index.php');  // Renirect to mobilefeatures.php after successful signup
                exit();
            } else {
                $signup_error = "Error: " . $conn->error;
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
    <title>Mobile Info - Login & Sign Up</title>
    <link rel="stylesheet" href="./css/sign_up.css">
</head>

<body>
    <div class="container">
        <!-- Login Form -->
        <div class="login-container" id="login-container">
            <div class="login-box">
                <h2>Welcome Back</h2>
                <p>Login to stay updated on the latest in mobile technology.</p>
                <form class="login-form" method="POST" action="sign_up.php">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" name="login" class="login-button">Login</button>
                    <?php if (isset($login_error)) echo "<p style='color: red;'>$login_error</p>"; ?>
                </form>
                <p class="switch-text">Don't have an account? <a href="#" onclick="showSignUp()">Sign up here</a></p>
            </div>
        </div>

        <!-- Sign-Up Form -->
        <div class="signup-container" id="signup-container" style="display: none;">
            <div class="login-box">
                <h2>Create Account</h2>
                <p>Sign up to get the latest mobile updates and news.</p>
                <form class="login-form" method="POST" action="sign_up.php">
                    <label for="new-username">Username</label>
                    <input type="text" id="new-username" name="new_username" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="new-password">Password</label>
                    <input type="password" id="new-password" name="new_password" required>

                    <button type="submit" name="signup" class="login-button">Sign Up</button>
                    <?php if (isset($signup_error)) echo "<p style='color: red;'>$signup_error</p>"; ?>
                </form>
                <p class="switch-text">Already have an account? <a href="#" onclick="showLogin()">Log in here</a></p>
            </div>
        </div>
    </div>
    <div id="trail-container"></div>

    <script>
        // Show Sign Up Form
        function showSignUp() {
            document.getElementById("login-container").style.display = "none";
            document.getElementById("signup-container").style.display = "block";
        }

        // Show Login Form
        function showLogin() {
            document.getElementById("signup-container").style.display = "none";
            document.getElementById("login-container").style.display = "block";
        }
    </script>
</body>

</html>
