<?php
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
    <title>Votre plateforme de conseils</title>
    <link rel="stylesheet" href="./css/syle.css">
  
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
        <h2> ~ Bienvenue sur CY-conseils ~ </h2>
        <p><h4> ~ C'est une plateforme de partage et de stockage d'astuces de la vie quotidienne ~ </h4></p>
        <p> Voici les 3 astuces les plus populaires : </p>
        <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <h2><?php echo htmlspecialchars($article['title']); ?></h2>
            <p><em>par <?php echo htmlspecialchars($article['author']); ?></em></p>
            <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun article n'a été soumis pour le moment.</p>
    <?php endif; ?>

        <div class="content-frame">
            <h3>Astuce 1</h3>
            <p> # </p>
        </div>
        <div class="content-frame">
            <h3>Astuce 2</h3>
            <p> # </p>
        </div>
        <div class="content-frame">
            <h3>Astuce 3</h3>
            <p> # </p>
        </div>
    </main>
</body>
</html>
