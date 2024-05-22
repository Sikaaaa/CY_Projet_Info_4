<?php

session_start();


// Fonction pour vérifier les informations de connexion
function verif($email, $password) {
    $file = './data/users.csv';

    // Lire le fichier ligne par ligne
    $lines = file($file, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $elem) {
        // Analyser les données de chaque ligne
        list($stored_first_name, $stored_name, $stored_email, $stored_pass) = explode(', ', $elem);
        
        // Nettoyer les données
        $stored_email = trim(str_replace("Email : ", "", $stored_email));
        $stored_pass = trim(str_replace("Mot de passe : ", "", $stored_pass));

        // Vérifier si les données correspondent
        if ($stored_email == $email && $password == $stored_pass) {
            return true;
        }
    }
    return false;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if (verif($email, $pass)) {
        $_SESSION['user'] = array('email'=> $email,'password'=> $pass);
        error_log("Connexion réussie ! Bienvenue, $email.");
        echo "Connexion réussie ! Bienvenue, $email.";
    } else {
        header('Location: accueil.php');
        exit;
    }
} //else {
    //echo "Méthode de requête non autorisée.";
//}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Votre plateforme de conseils</title>
   
</head>
<body>
    <header>
        <h1>CY-conseils</h1>
    </header>
    <nav>
        <a href="accueil.php">Accueil</a>
        <a href="conseils.php">Conseils</a>
        <a href="recherche.php">Page de recherches</a>
        <a href="monespace.html">Inscription - Connexion</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
    <main>
        <h2>Connexion</h2>
        <div class="content-frame">
            <form action="connexion.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="motdepasse">Mot de passe:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Se connecter">
                </div>
            </form>
        </div>
    </main>
</body>
</html>

