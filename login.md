# login.php

## Purpose

`login.php` logs the user into the system.

## What It Does

- Includes the session file
- Includes the helper file
- Includes the database connection
- Redirects to `home.php` if the user is already logged in
- Reads the remembered email from a cookie
- Shows messages like `registered` or `logout`
- Reads the email and password from the form
- Searches for the user in the `users` table
- Uses `password_verify()` to compare the typed password with the saved hash
- Saves user information into `$_SESSION`
- Saves or clears the email cookie
- Redirects to `home.php`

## Important PHP Ideas

- `$_COOKIE` reads the remembered email
- `password_verify()` checks login passwords
- `$_SESSION["user_id"]` stores the logged-in user
- `setcookie()` creates or removes a cookie

## SQL Used

- `SELECT id, full_name, email, password FROM users WHERE email = ?`

## In Simple Words

This file checks login details. If they are correct, it creates a session and
the user becomes logged in.
