<?php
session_start();

if (isset($_SESSION['user'])) {
    $session_info = $_SESSION['user'];
} 

// Fonction pour récupérer les données de l'utilisateur à partir de l'email
function get_user_data($email)
{
    $file = './data/users.csv';

    // Read the file line by line
    $lines = file($file, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        // Extract the user information from each line
        preg_match('/Prénom : ([^,]+), Nom : ([^,]+), Email : ([^,]+), Mot de passe: ([^\s]+)/', $line, $matches);

        if (count($matches) == 5) {
            $stored_first_name = trim($matches[1]);
            $stored_name = trim($matches[2]);
            $stored_email = trim($matches[3]);
            $stored_pass = trim($matches[4]);

            // Check if the data matches
            if ($stored_email == $email) {
                return [
                    'first_name' => $stored_first_name,
                    'name' => $stored_name,
                    'email' => $stored_email
                ];
            }
        }
    }
    return false;
}



if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    $user_email = $_SESSION['user']['email'];
    $user_data = get_user_data($user_email);

    if ($user_data) {
        $first_name = $user_data['first_name'];
        $name = $user_data['name'];
        $email = $user_data['email'];
    } else {
        echo "Impossible de récupérer les données de l'utilisateur.";
    }
} else {
    echo "Veuillez vous connecter.";
    exit;
}

function get_user_articles($email) {
    $file = './data/articles.csv';
    $articles = [];

    // Vérifier si le fichier existe
    if (file_exists($file)) {
        // Ouverture du fichier en mode lecture
        $handle = fopen($file, 'r');

        if ($handle) {
            // Lire chaque ligne du fichier
            while (($data = fgetcsv($handle)) !== FALSE) {
                // Vérifier si l'auteur de l'article correspond à l'email de l'utilisateur
                if ($data[1] === $email) {
                    $articles[] = [
                        'title' => $data[0],
                        'author' => $data[1],
                        'categorie' => $data[2],
                        'content' => $data[3]
                    ];
                }
            }
            fclose($handle);
        }
    }
    return $articles;
}

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    $user_email = $_SESSION['user']['email'];
    $user_data = get_user_data($user_email);

    if ($user_data) {
        $first_name = $user_data['first_name'];
        $name = $user_data['name'];
        $email = $user_data['email'];

        // Récupérer les articles de l'utilisateur
        $articles = get_user_articles($email);
    } else {
        echo "Impossible de récupérer les données de l'utilisateur.";
    }
} else {
    echo "Veuillez vous connecter.";
    exit;
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
        <a href="profil.php"> Profil</a>
        <a href="monespace.html">Inscription - Connexion</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
    <h2>Votre profil utilisateur</h2>
    <h3><?php if(isset($_SESSION['user'])) 
            echo $session_info['email'] ;?></h3>
    <p> Prénom : <?php echo isset($first_name) ? $first_name : ''; ?></p>
    <p> Nom : <?php echo isset($name) ? $name : ''; ?></p>
    <p> Email : <?php echo isset($email) ? $email : ''; ?></p>


    <h2>Vos articles</h2>
        <?php if (!empty($articles)): ?>
            <ul>
            <?php foreach ($articles as $article): ?>
                <li>
                <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                <p><?php echo htmlspecialchars($article['content']); ?></p>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez écrit aucun article pour l'instant.</p>
        <?php endif; ?>
</body>
</html>
