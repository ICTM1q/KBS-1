<?php
// Sessie starten.
session_start();

// Alle variabelen leegmaken .
$_SESSION = array();

// Session vernietigen.
session_destroy();

// Terug naar login.
header ( "location:index.php" );
?>

