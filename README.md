# PHP Learning Notes

This project is a simple PHP app for learning:

- Registration
- Login
- Sessions
- Cookies
- CRUD
- MySQL with `mysqli`

## Study Order

Read the files in this order:

1. `config/database.php`
2. `includes/session.php`
3. `includes/functions.php`
4. `index.php`
5. `register.php`
6. `login.php`
7. `home.php`
8. `logout.php`
9. `assets/css/style.css`

## Explanation Files

Each main file has its own Markdown explanation:

- [config/database.md](config/database.md)
- [includes/session.md](includes/session.md)
- [includes/functions.md](includes/functions.md)
- [index.md](index.md)
- [register.md](register.md)
- [login.md](login.md)
- [home.md](home.md)
- [logout.md](logout.md)
- [assets/css/style.md](assets/css/style.md)

## Run The App

Start the PHP server from this folder:

```bash
php -S localhost:8000
```

Then open:

```text
http://localhost:8000
```

## Database Used

The connection in this project is:

```php
$conn = new mysqli("localhost", "phpuser", "1234", "php_learning");
```

The app uses two tables:

- `users`
- `notes`

## Quick Flow

The user starts at `index.php`, registers in `register.php`, logs in through
`login.php`, works with notes in `home.php`, and leaves the app through
`logout.php`.
