<?php

// Démarrer la session pour suivre les utilisateurs connectés
session_start();

// Fonction pour vérifier les informations de connexion
function verif($email, $password)
{
    // Chemin vers le fichier contenant les utilisateurs
    $file = './data/users.csv';

    // Lire le fichier ligne par ligne en ignorant les nouvelles lignes
    $lines = file($file, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        // Extraire l'email et le mot de passe de chaque ligne à l'aide d'une expression régulière
        preg_match('/Email : ([^,]+), Mot de passe: ([^\s]+)/', $line, $matches);

        // Vérifier si le format des données correspond
        if (count($matches) == 3) {
            $stored_email = trim($matches[1]);
            $stored_pass = trim($matches[2]);

            // Vérifier si l'email et le mot de passe fournis correspondent aux données stockées
            if ($stored_email == $email && $stored_pass == $password) {
                return true; // Connexion réussie
            }
        }
    }
    return false; // Connexion échouée
}

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'email et le mot de passe du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier les informations de connexion
    if (verif($email, $password)) {
        // Si les informations sont correctes, sauvegarder les infos de l'utilisateur dans la session
        $_SESSION['user'] = array(
            'email' => $email,
            'password' => $password
        );
        // Enregistrer un message de succès dans le journal d'erreurs
        error_log("Connexion réussie ! Bienvenue, $email.");
        // Rediriger l'utilisateur vers la page d'accueil
        header('Location: accueil.php');
        exit();
    } else {
        // Enregistrer un message d'échec dans le journal d'erreurs
        error_log("Vous n'êtes pas connecté");
        // Afficher un message d'erreur
        echo "Erreur : Email ou mot de passe incorrect.";
    }
}
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
        <!-- Menu de navigation du site -->
        <a href="accueil.php">Accueil</a>
        <a href="conseils.php">Conseils</a>
        <a href="recherche.php">Page de recherches</a>
        <a href="profil.php">Profil</a>
        <a href="monespace.html">Inscription - Connexion</a>
                <a class="logout" href="deconnexion.php">Déconnexion</a>    

    </nav>
    <main>
        <h2>Connexion</h2>
        <div class="content-frame">
            <!-- Formulaire de connexion -->
            <form action="connexion.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <!-- Champ de saisie pour l'email -->
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="motdepasse">Mot de passe:</label>
                    <!-- Champ de saisie pour le mot de passe -->
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <!-- Bouton de soumission du formulaire -->
                    <input type="submit" value="Se connecter">
                </div>
            </form>
        </div>
    </main>
</body>
</html>
