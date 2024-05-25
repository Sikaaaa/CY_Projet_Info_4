<?php
// Démarrer la session pour suivre les utilisateurs connectés
session_start();

// Si l'utilisateur est connecté, récupérer les informations de session
if (isset($_SESSION['user'])) {
    $session_info = $_SESSION['user'];
}

// Si l'utilisateur n'est pas connecté, afficher un message d'invitation à se connecter
if (!isset($_SESSION['user'])){
    echo "Veuillez vous connecter";
}

// Fonction pour enregistrer l'article dans un fichier CSV
function save_article($title, $author, $categorie, $content) {
    $file = './data/articles.csv';

    // Ouverture du fichier en mode ajout
    $handle = fopen($file, 'a');

    // Si le fichier est ouvert avec succès, écrire l'article dans le fichier
    if ($handle) {
        fputcsv($handle, [$title, $author, $categorie, $content]);
        fclose($handle);
        return true;
    } else {
        return false;
    }
}

// Fonction pour récupérer le prénom de l'utilisateur à partir de son email
function get_user_first_name($email) {
    $file = './data/users.csv';

    // Lire le fichier ligne par ligne
    $lines = file($file, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        // Extraire les informations utilisateur de chaque ligne
        preg_match('/Prénom : ([^,]+), Nom : ([^,]+), Email : ([^,]+), Mot de passe: ([^\s]+)/', $line, $matches);

        // Si le format des données est correct, vérifier si l'email correspond
        if (count($matches) == 5) {
            $stored_first_name = trim($matches[1]);
            $stored_email = trim($matches[3]);

            if ($stored_email == $email) {
                return $stored_first_name; // Retourner le prénom si l'email correspond
            }
        }
    }
    return false; // Retourner false si aucun prénom correspondant n'est trouvé
}

// Si l'utilisateur est connecté et que le formulaire a été soumis
if(isset($_SESSION['user'])){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $author = get_user_first_name($_SESSION['user']['email']);
        $categorie = $_POST['categorie'];
        $content = $_POST['content'];

        // Enregistrer l'article et afficher un message de succès ou d'erreur
        if (save_article($title, $author, $categorie, $content)) {
            echo "Article soumis avec succès!";
        } else {
            echo "Erreur lors de la soumission de l'article.";
        }
    }
}

// Fonction pour lire les articles depuis le fichier CSV
function get_articles() {
    $file = './data/articles.csv';
    $articles = [];

    // Vérifier si le fichier existe
    if (file_exists($file)) {
        // Ouverture du fichier en mode lecture
        $handle = fopen($file, 'r');

        // Lire chaque ligne du fichier et ajouter à la liste des articles
        if ($handle) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $articles[] = [
                    'title' => $data[0],
                    'author' => $data[1],
                    'categorie' => $data[2],
                    'content' => $data[3]
                ];
            }
            fclose($handle);
        }
    }
    return $articles; // Retourner la liste des articles
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
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
    <main>
        <h2>Conseils et ressources</h2>
        <h3>
            <?php 
            // Afficher l'email de l'utilisateur connecté
            if(isset($_SESSION['user'])) 
                echo $session_info['email']; 
            ?>
        </h3>
        <p>Ceci est la page de conseils et de ressources</p>
        <p> Attention, il faut être connecté pour pouvoir poster un article !</p>

        <!-- Formulaire de soumission d'article -->
        <form action="conseils.php" method="post">
            <label for="title">Titre de l'article:</label><br>
            <input type="text" id="title" name="title" required><br><br>
            
            <label for="categorie">Catégorie:</label><br><br>
            <select name="categorie"> 
                <option value="cuisine">Cuisine</option>
                <option value="sport">Sport</option>
                <option value="culture">Culture</option>
                <option value="educatif">Educatif</option>
            </select><br><br>
            
            <label for="content">Contenu de l'article:</label><br>
            <textarea id="content" name="content" rows="10" cols="50" required></textarea><br><br>
            
            <input type="submit" value="Soumettre">
        </form>
    </main>
</body>
</html>
