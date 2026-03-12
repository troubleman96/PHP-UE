<?php

// Show safe text inside HTML.
function show($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}
