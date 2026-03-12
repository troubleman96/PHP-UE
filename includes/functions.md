# includes/functions.php

## Purpose

`includes/functions.php` contains a small helper function.

## What It Does

- Defines `show($value)`
- Converts special characters into safe HTML

## Why It Matters

If you print raw user input directly, HTML can break or unsafe content can be
displayed. `show()` helps prevent that.

## Function Used

```php
function show($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}
```

## In Simple Words

This file is only for safe output when showing data on the page.
