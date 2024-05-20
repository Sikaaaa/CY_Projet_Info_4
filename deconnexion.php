<?php
// Initialiser la session
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Finalement, détruire la session.
session_destroy();

// Rediriger vers la page de connexion ou d'accueil
header("Location: accueil.html");
exit;

