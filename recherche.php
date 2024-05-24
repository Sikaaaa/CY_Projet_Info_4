<?php

//démarrage de la session
session_start();


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

// Fonction pour filtrer les articles par mot-clé
function search_articles($articles, $mot) {
    $filtered_articles = [];

    foreach ($articles as $article) {
        if (stripos($article['title'], $mot) !== false || 
            stripos($article['author'], $mot) !== false || 
            stripos($article['content'], $mot) !== false) {
            $filtered_articles[] = $article;
        }
    }

    return $filtered_articles;
}

// Récupérer les articles
$articles = get_articles();

// Inverser l'ordre des articles pour que les plus récents soient en derniers
$articles = array_reverse($articles);

// Vérifier s'il y a une recherche
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_keyword = htmlspecialchars($_GET['search']);
    $articles = search_articles($articles, $search_keyword);
}
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
        <a href="monespace.html">Inscription - Connexion</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>

    <main class="main-search">
        <h2>Ceci est la page de recherche</h2>
        <form action="recherche.php" method="get">
            <label for="search">Recherche de conseils :</label>
            <input type="text" id="search" name="search" required>
            <input type="submit" value="Rechercher">
        </form>
        
        <section>
            <h2>Résultats de recherche :</h2>
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                    <p><em>par <?php echo htmlspecialchars($article['author']); ?></em></p>
                    <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun article n'a été trouvé pour votre recherche.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
