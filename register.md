# register.php

## Purpose

`register.php` creates a new user account.

## What It Does

- Includes the session file
- Includes the helper file
- Includes the database connection
- Redirects to `home.php` if the user is already logged in
- Reads form data when the request method is `POST`
- Validates the form fields
- Checks whether the email already exists in the `users` table
- Hashes the password with `password_hash()`
- Inserts the new user into the database
- Redirects to `login.php?message=registered`

## Important PHP Ideas

- `$_SERVER["REQUEST_METHOD"]` checks whether the form was submitted
- `trim()` removes spaces from input
- `$conn->prepare()` creates a prepared statement
- `bind_param()` sends values safely to SQL
- `password_hash()` stores the password safely
- `header("Location: ...")` redirects to another page

## SQL Used

- `SELECT id FROM users WHERE email = ?`
- `INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)`

## In Simple Words

This file is responsible for sign up. It receives user data, checks it, saves
the new account, and sends the user to the login page.
