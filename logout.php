<?php

// Start the session
session_start();

// Log user out of the session
$_SESSION = array();
session_destroy();

// Redirect to the home page
header("Location: index.php");

?>