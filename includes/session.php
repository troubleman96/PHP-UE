<?php

// Start the session so we can store login data.
if (session_status() === PHP_SESSION_NONE) {
    $sessionFolder = __DIR__ . "/../data/sessions";

    if (!is_dir($sessionFolder)) {
        mkdir($sessionFolder, 0777, true);
    }

    session_save_path($sessionFolder);
    session_start();
}
