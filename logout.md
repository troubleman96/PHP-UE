# logout.php

## Purpose

`logout.php` logs the user out.

## What It Does

- Includes the session file
- Clears session variables using `session_unset()`
- Destroys the session using `session_destroy()`
- Redirects to `login.php?message=logout`

## Important PHP Ideas

- `session_unset()` removes session data
- `session_destroy()` ends the session
- `header("Location: ...")` sends the user away after logout

## In Simple Words

This file ends the login session and sends the user back to the login page.
