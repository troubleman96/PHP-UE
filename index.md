# index.php

## Purpose

`index.php` is the landing page of the project.

## What It Does

- Starts access to session data by including `includes/session.php`
- Uses `includes/functions.php` so it can call `show()`
- Reads the cookie `remember_email`
- Shows a welcome message if the cookie exists
- Checks `$_SESSION["user_id"]`
- If the user is logged in, it shows `Home Page` and `Logout`
- If the user is not logged in, it shows `Register` and `Login`

## Important PHP Ideas

- `include` is used to reuse code from another file
- `$_COOKIE` reads data saved in the browser
- `$_SESSION` checks whether the user is logged in
- `<?php if (...) : ?>` is PHP inside HTML

## In Simple Words

This file is the first page. It does not save data. It only shows links and a
small cookie message.
