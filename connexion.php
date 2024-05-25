<?php

session_start();

// Function to verify login information
function verif($email, $password)
{
    $file = './data/users.csv';

    // Read the file line by line
    $lines = file($file, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        // Extract the email and password from each line
        preg_match('/Email : ([^,]+), Mot de passe: ([^\s]+)/', $line, $matches);

        if (count($matches) == 3) {
            $stored_email = trim($matches[1]);
            $stored_pass = trim($matches[2]);

            // Check if the data matches
            if ($stored_email == $email && $stored_pass == $password) {
                return true;
            }
        }
    }
    return false;
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (verif($email, $password)) {
        $_SESSION['user'] = array(
            'email' => $email,
            'password' => $password
        );
        error_log("Connexion réussie ! Bienvenue, $email.");
        header('Location: accueil.php');
        exit();
    } else {
        error_log("Vous n'êtes pas connecté");
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
        <a href="accueil.php">Accueil</a>
        <a href="conseils.php">Conseils</a>
        <a href="recherche.php">Page de recherches</a>
        <a href="profil.php"> Profil</a>
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