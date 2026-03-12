<?php

// This file connects PHP to the MySQL database.
// $conn will be used in register.php, login.php, and home.php.
$conn = new mysqli("localhost", "phpuser", "1234", "php_learning");

// If the connection fails, stop the program and show an error.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set so text is stored and read correctly.
$conn->set_charset("utf8mb4");

// Create the users table if it does not already exist.
// This table stores account information for registration and login.
$conn->query("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
");

// Create the notes table if it does not already exist.
// This table stores notes for CRUD operations.
$conn->query("
    CREATE TABLE IF NOT EXISTS notes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(100) NOT NULL,
        body TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
");
