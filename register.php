<?php

include "includes/session.php";
include "includes/functions.php";
include "config/database.php";

if (isset($_SESSION["user_id"])) {
    header("Location: home.php");
    exit;
}

$errors = [];
$fullName = "";
$email = "";
$requestMethod = $_SERVER["REQUEST_METHOD"] ?? "GET";

// Run this code when the registration form is submitted.
if ($requestMethod == "POST") {
    $fullName = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if ($fullName == "") {
        $errors[] = "Full name is required.";
    }

    if ($email == "") {
        $errors[] = "Email is required.";
    }

    if ($password == "") {
        $errors[] = "Password is required.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Check if the email already exists.
        $checkUser = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkUser->bind_param("s", $email);
        $checkUser->execute();
        $result = $checkUser->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Email already exists.";
        } else {
            // Hash the password before saving it.
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insertUser = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            $insertUser->bind_param("sss", $fullName, $email, $hashedPassword);
            $insertUser->execute();

            header("Location: login.php?message=registered");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="page auth-layout">
        <section class="card">
            <div class="nav-links">
                <a href="index.php">Landing Page</a>
                <a href="login.php">Login</a>
            </div>

            <h1>Register</h1>
            <p class="intro-text">Create a new account.</p>

            <?php if (!empty($errors)): ?>
                <div class="flash error">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo show($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label>
                    Full Name
                    <input type="text" name="full_name" value="<?php echo show($fullName); ?>" required>
                </label>

                <label>
                    Email
                    <input type="email" name="email" value="<?php echo show($email); ?>" required>
                </label>

                <label>
                    Password
                    <input type="password" name="password" required>
                </label>

                <label>
                    Confirm Password
                    <input type="password" name="confirm_password" required>
                </label>

                <div class="form-actions">
                    <button type="submit">Register</button>
                    <a class="button secondary" href="login.php">Go to Login</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
