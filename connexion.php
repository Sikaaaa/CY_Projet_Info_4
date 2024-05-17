<?php

// Fonction pour vérifier les informations de connexion
    function verif($username, $password) {
        $file = 'users.txt';

        // Lire le fichier ligne par ligne
        $lines = file($file, FILE_IGNORE_NEW_LINES);

        foreach ($lines as $elem) {
            // Analyser les données de chaque ligne
            list($stored_user, $stored_email, $stored_pass) = explode(', ', $elem);
        
            // Extraire les valeurs réelles
            $stored_user = str_replace("Nom d'utilisateur: ", "", $stored_user);
            $stored_pass = str_replace("Mot de passe: ", "", $stored_pass);

            // Vérifier si le nom d'utilisateur correspond et si le mot de passe est correct
            if ($stored_user === $username && password_verify($password, $stored_pass) == true) {
            return true;
            }
        }
        return false;
        }

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST['username'];
        $pass = $_POST['password'];

            if (verif($user, $pass)== true) {
                echo "Connexion réussie ! Bienvenue, $user.";
            } 
            else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
            } 
        } 
        else {
            echo "Méthode de requête non autorisée.";
        }

?>