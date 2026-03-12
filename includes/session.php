<?php

// Start the session so pages can share login information.
if (session_status() === PHP_SESSION_NONE) {
    // This folder stores session files on the computer.
    $sessionFolder = __DIR__ . "/../data/sessions";

    // Create the folder if it does not exist yet.
    if (!is_dir($sessionFolder)) {
        mkdir($sessionFolder, 0777, true);
    }

    // Tell PHP to save session files in that folder.
    session_save_path($sessionFolder);

    // Start the session.
    session_start();
}
