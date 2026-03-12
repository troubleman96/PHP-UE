<?php

include "includes/session.php";

// Remove all session data and send the user back to the login page.
session_unset();
session_destroy();

header("Location: login.php?message=logout");
exit;
