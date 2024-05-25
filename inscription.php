<?php
//INSCRIPTION
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Vérifie si la méthode de requête est POST
    // Récupérer les données du formulaire
    $first_name = $_POST['first_name'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Hachage du mot de passe, pour des raisons de sécurité
    //$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Créer une ligne avec les données de l'utilisateur dans le fichier users.txt
    $data = "Prénom : $first_name, Nom : $name, Email : $email, Mot de passe: $pass\n";

    // Chemin vers le fichier csv où les données sont enregistrées
    $file = './data/users.csv';

    // Enregistrer les données dans le fichier
    file_put_contents($file, $data, FILE_APPEND | LOCK_EX); //file_put_content permet d'ouvrir un fichier et d'écrire dedans sans rappeler de fonction

    echo "Inscription réussie !"; // Affiche un message de réussite
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
        <a href="profil.php"> Profil</a>
        <a href="monespace.html">Inscription - Connexion</a>
               <a class="logout" href="deconnexion.php">Déconnexion</a>    

    </nav>
    <main>
        <h2>Formulaire d'inscription</h2>
        <div class="content-frame">
            <!-- Formulaire d'inscription -->
            <form action="inscription.php" method="post">
                <h3>Inscription</h3>
                <div class="form-group">
                    <label for="first_name">Prénom:</label>
                    <input type="text" id="first_name" name="first_name" required> <!-- Champs pour le prénom avec validation requise -->
                </div>
                <div class="form-group">
                    <label for="name">Nom:</label>
                    <input type="text" id="name" name="name" required> <!-- Champs pour le nom avec validation requise -->
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required> <!-- Champs pour l'email avec validation requise -->
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" required> <!-- Champs pour le mot de passe avec validation requise -->
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required> <!-- Champs pour la confirmation du mot de passe avec validation requise -->
                </div>
                <div class="form-group">
                    <input type="submit" value="S'inscrire"> <!-- Bouton de soumission du formulaire -->
                </div>
            </form>
        </div>
    </main>
</body>
</html>
