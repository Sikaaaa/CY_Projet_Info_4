<?php
// Initialiser la session
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// détruire la session.
session_destroy();

// Rediriger vers la page d'accueil
//header("Location: accueil.php");
//exit;
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/deconnexion.css">
    <title>Votre plateforme de conseils</title>

</head>
<body>
    <header>
        <h1>CY-conseils</h1>
    </header>
    <nav>
        <a href="accueil.php">Accueil</a>
        <a href="conseils.php">Conseils</a>
        <a href="recherche.html">Page de recherches</a>
        <a href="monespace.html">Inscription - Connexion</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
    <main>
        <h2>Vous vous êtes déconnecté(e)</h2>
        <p>Retour à l' <a href="accueil.php">Accueil</a></p>
    </main>
</body>
</html>

