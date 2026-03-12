# Simple PHP Learning App

This version is simplified for revision and exam practice.

## Files

- `config/database.php` for the `mysqli` connection
- `register.php` for registration
- `login.php` for login
- `home.php` for CRUD
- `logout.php` for logout
- `includes/session.php` for sessions
- `includes/functions.php` for safe HTML output

## Database

Create a MySQL database called `school`.

The connection used is:

```php
$conn = new mysqli("localhost", "root", "", "school");
```

## Run

```bash
php -S localhost:8000
```

Then open:

```text
http://localhost:8000
```
