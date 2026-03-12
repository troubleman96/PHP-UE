<?php

// This function makes output safe before showing it in HTML.
// It helps prevent broken HTML and unsafe user input display.
function show($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}
