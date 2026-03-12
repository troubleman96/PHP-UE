# config/database.php

## Purpose

`config/database.php` connects the project to MySQL.

## What It Does

- Creates a new connection with `new mysqli(...)`
- Stops the program with `die()` if the connection fails
- Sets the character set to `utf8mb4`
- Creates the `users` table if it does not exist
- Creates the `notes` table if it does not exist

## Connection Used

```php
$conn = new mysqli("localhost", "phpuser", "1234", "php_learning");
```

## Important PHP Ideas

- `$conn` is the database connection variable
- `$conn->connect_error` checks if MySQL connection failed
- `$conn->query()` runs SQL directly

## Tables Created

### users

Stores registration and login data:

- `id`
- `full_name`
- `email`
- `password`
- `created_at`

### notes

Stores CRUD data:

- `id`
- `user_id`
- `title`
- `body`
- `created_at`
- `updated_at`

## In Simple Words

This file connects PHP to MySQL and makes sure the two required tables exist.
