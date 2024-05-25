<?php

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $session_info = $_SESSION['user']; 
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
                // Ajouter chaque article au tableau
                $articles[] = [
                    'title' => $data[0],
                    'author' => $data[1],
                    'categorie' => $data[2],
                    'content' => $data[3]
                ];
            }
            // Fermer le fichier après lecture
            fclose($handle);
        }
    }
    // Retourner le tableau des articles
    return $articles;
}

// Récupérer les articles depuis le fichier CSV
$articles = get_articles();

// Inverser l'ordre des articles pour que le dernier créé soit en premier
$articles = array_reverse($articles);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre plateforme de conseils</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h1>CY-conseils</h1>
    </header>
    <nav>
        <a href="accueil.php">Accueil</a>
        <a href="conseils.php">Conseils</a>
        <a href="recherche.php">Page de recherches</a>
        <a href="profil.php">Profil</a>
        <a href="monespace.html">Inscription - Connexion</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
    <main>
        <h2> ~ Bienvenue sur CY-conseils ~ </h2>
        <!-- Afficher l'email de l'utilisateur connecté, s'il y en a un -->
        <h3><?php if(isset($_SESSION['user'])) echo $session_info['email']; ?></h3>
        <p><h4> ~ C'est une plateforme de partage et de stockage d'astuces de la vie quotidienne ~ </h4></p>
        <p> Voici les dernières astuces postées par les utilisateurs : </p>

        <!-- Afficher les articles s'il y en a, sinon afficher un message alternatif -->
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <h2><?php echo htmlspecialchars($article['title']); ?></h2>
                <p><em>par <?php echo htmlspecialchars($article['author']); ?></em></p>
                <p><?php echo htmlspecialchars($article['categorie']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article n'a été soumis pour le moment.</p>
        <?php endif; ?>
    </main>
</body>
</html>
