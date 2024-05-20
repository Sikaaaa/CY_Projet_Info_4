<?php

// Fonction pour vérifier les informations de connexion
    function verif($email, $password) {
        $file = 'users.csv';

        // Lire le fichier ligne par ligne
        $lines = file($file, FILE_IGNORE_NEW_LINES);

        foreach ($lines as $elem) {
            // Analyser les données de chaque ligne
            list($stored_first_name, $stored_name, $stored_email, $stored_pass) = explode(', ', $elem);
        
            // Extraire les valeurs qui nous intéressent 
            $stored_email = str_replace("Email: ", "", $stored_email);
            $stored_pass = str_replace("Mot de passe: ", "", $stored_pass);

            // Vérifier si le nom d'utilisateur correspond et si le mot de passe est correct
            if ($stored_email === $email && password_verify($password, $stored_pass) == true) {
            return true;
            }
        }
        return false;
        }

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $pass = $_POST['password'];

            if (verif($email, $pass)== true) {
                echo "Connexion réussie ! Bienvenue, $email.";
            } 
            else {
                echo "Nom d'utilisateur ou mot de passe incorrect.";
            } 
        } 
        else {
            echo "Méthode de requête non autorisée.";
        }