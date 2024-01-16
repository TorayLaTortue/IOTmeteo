<?php

session_start();

// Détruit toutes les variables de session
$_SESSION = array();

// Détruit la session
session_destroy();

// Rediriger vers la page de connexion
header("Location: login.php");
exit();
?>
