# home.php

## Purpose

`home.php` is the protected page. It shows CRUD operations for notes.

## What It Does

- Includes the session file
- Includes the helper file
- Includes the database connection
- Checks if the user is logged in
- Redirects to `login.php` if no session exists
- Reads the logged-in user id from `$_SESSION`
- Handles `create`, `update`, and `delete`
- Loads one note into the form when `?edit=id` is used
- Reads all notes for the current user
- Displays the notes in a table

## CRUD In This File

- Create: adds a new note
- Read: shows all notes in a table
- Update: changes an existing note
- Delete: removes a note

## Important PHP Ideas

- Hidden input `action` tells PHP which operation to run
- `$_POST` is used for create, update, and delete
- `$_GET["edit"]` is used to load a note into the update form
- `fetch_assoc()` gets one row as an associative array
- A `while` loop is used to read all notes

## SQL Used

- `INSERT INTO notes (user_id, title, body) VALUES (?, ?, ?)`
- `UPDATE notes SET title = ?, body = ? WHERE id = ? AND user_id = ?`
- `DELETE FROM notes WHERE id = ? AND user_id = ?`
- `SELECT * FROM notes WHERE id = ? AND user_id = ?`
- `SELECT * FROM notes WHERE user_id = ? ORDER BY id DESC`

## In Simple Words

This is the main working page of the project. After login, the user can add,
see, edit, and delete notes here.
