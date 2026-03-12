# includes/session.php

## Purpose

`includes/session.php` starts the PHP session.

## What It Does

- Checks if a session has not started yet
- Creates a local folder for session files
- Sets that folder as the session save path
- Starts the session with `session_start()`

## Important PHP Ideas

- `$_SESSION` only works after `session_start()`
- Session data is used to keep the user logged in

## In Simple Words

This file makes sessions available in the project so login can stay active from
page to page.
