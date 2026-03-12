<?php

// Start the session.
include "includes/session.php";

// Load the helper function.
include "includes/functions.php";

// Connect to the database.
include "config/database.php";

// If the user is already logged in, send them to the home page.
if (isset($_SESSION["user_id"])) {
    header("Location: home.php");
    exit;
}

// These variables store page messages, form values, and errors.
$errors = [];
$message = "";
$email = $_COOKIE["remember_email"] ?? "";
$requestMethod = $_SERVER["REQUEST_METHOD"] ?? "GET";

// Show simple messages after register or logout.
if (isset($_GET["message"]) && $_GET["message"] == "registered") {
    $message = "Registration successful. You can now log in.";
}

if (isset($_GET["message"]) && $_GET["message"] == "logout") {
    $message = "You have logged out.";
}

// Run this code only when the login form is submitted.
if ($requestMethod == "POST") {
    // Read the form data.
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Make sure both fields were filled in.
    if ($email == "" || $password == "") {
        $errors[] = "Email and password are required.";
    }

    // Continue only if there are no validation errors.
    if (empty($errors)) {
        // Find the user by email.
        $findUser = $conn->prepare("SELECT id, full_name, email, password FROM users WHERE email = ?");
        $findUser->bind_param("s", $email);
        $findUser->execute();
        $result = $findUser->get_result();
        $user = $result->fetch_assoc();

        // Check that the user exists and the password is correct.
        if ($user && password_verify($password, $user["password"])) {
            // Save user information in the session.
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["full_name"];
            $_SESSION["user_email"] = $user["email"];

            // Save the email in a cookie if the checkbox is selected.
            if (isset($_POST["remember_email"])) {
                setcookie("remember_email", $email, time() + (86400 * 7), "/");
            } else {
                setcookie("remember_email", "", time() - 3600, "/");
            }

            header("Location: home.php");
            exit;
        } else {
            // Show an error if login details are wrong.
            $errors[] = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="page auth-layout">
        <section class="card">
            <div class="nav-links">
                <a href="index.php">Landing Page</a>
                <a href="register.php">Register</a>
            </div>

            <h1>Login</h1>
            <p class="intro-text">Log in with your email and password.</p>

            <?php // Show success messages from registration or logout. ?>
            <?php if ($message != ""): ?>
                <div class="flash success"><?php echo show($message); ?></div>
            <?php endif; ?>

            <?php // Show login errors if they exist. ?>
            <?php if (!empty($errors)): ?>
                <div class="flash error">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo show($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label>
                    Email
                    <input type="email" name="email" value="<?php echo show($email); ?>" required>
                </label>

                <label>
                    Password
                    <input type="password" name="password" required>
                </label>

                <label>
                    <input type="checkbox" name="remember_email" <?php echo $email != "" ? "checked" : ""; ?>>
                    Remember email using cookie
                </label>

                <div class="form-actions">
                    <button type="submit">Login</button>
                    <a class="button secondary" href="register.php">Create Account</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
