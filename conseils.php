<?php
session_start();
// Fonction pour enregistrer l'article dans un fichier CSV
function save_article($title, $author, $content) {
    $file = 'articles.csv';

    // Ouverture du fichier en mode ajout
    $handle = fopen($file, 'a');

    if ($handle) {
        // Écrire l'article dans le fichier
        fputcsv($handle, [$title, $author, $content]);
        fclose($handle);
        return true;
    } else {
        return false;
    }
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    // Enregistrer l'article
    if (save_article($title, $author, $content)) {
        echo "Article soumis avec succès!";
    } else {
        echo "Erreur lors de la soumission de l'article.";
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

        if ($handle) {
            // Lire chaque ligne du fichier
            while (($data = fgetcsv($handle)) !== FALSE) {
                $articles[] = [
                    'title' => $data[0],
                    'author' => $data[1],
                    'content' => $data[2]
                ];
            }
            fclose($handle);
        }
    }
    return $articles;
}

// Récupérer les articles
$articles = get_articles();
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
        <a href="recherche.html">Page de recherches</a>
        <a href="monespace.html">Inscription - Connexion</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
    <main>
        //rajouter la barre de recherche dans les articles
        //rajouter un lien qui amène à un formulaire pour créer des articles 

        <h2>Conseils et ressources</h2>
        <p>Ceci est la page de conseils et de ressources</p>
        <form action="conseils.php" method="post">
        <label for="title">Titre de l'article:</label><br>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="author">Auteur:</label><br>
        <input type="text" id="author" name="author" required><br><br>
        
        <label for="content">Contenu de l'article:</label><br>
        <textarea id="content" name="content" rows="10" cols="50" required></textarea><br><br>
        
        <input type="submit" value="Soumettre">
    </form>
    </main>
</body>
</html>
