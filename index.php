<?php

// Include session support so we can check login status.
include "includes/session.php";

// Include the helper function used to print safe text.
include "includes/functions.php";

// Read the cookie if the user asked the app to remember their email.
$rememberedEmail = $_COOKIE["remember_email"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Learning App</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="page">
        <section class="hero">
            <p class="muted">Simple PHP project</p>
            <h1>Learn registration, login, sessions, cookies, and CRUD.</h1>
            <p>
                This version is kept simple for learning and exam revision.
                Create an account, log in, and manage notes.
            </p>

            <?php // Show the remembered email only if the cookie exists. ?>
            <?php if ($rememberedEmail != ""): ?>
                <div class="flash success">
                    Remembered email from cookie: <?php echo show($rememberedEmail); ?>
                </div>
            <?php endif; ?>

            <div class="actions">
                <?php // If the session exists, the user is already logged in. ?>
                <?php if (isset($_SESSION["user_id"])): ?>
                    <a class="button" href="home.php">Home Page</a>
                    <a class="button secondary" href="logout.php">Logout</a>
                <?php // If there is no session, show register and login links. ?>
                <?php else: ?>
                    <a class="button" href="register.php">Register</a>
                    <a class="button secondary" href="login.php">Login</a>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
