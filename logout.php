<?php
session_start();

// Unset all of the session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the main page or a login page
header('Location: index.php'); // Redirect to index.php or any other appropriate page
exit();
?>
