<?php

//INSCRIPTION
    // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") { // Récupérer les données du formulaire
            $first_name = $_POST['first_name'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['password'];

            // Hachage du mot de passe, pour des raisons de sécurité
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

            // Créer une ligne avec les données de l'utilisateur dans le fichier users.txt
            $data = "Prénom : $first_name, Nom : $name, Email : $email, Mot de passe: $hashed_pass\n";

            // Chemin vers le fichier texte où les données seront enregistrées
            $file = '/users.txt';

            // Enregistrer les données dans le fichier
            file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

            echo "Inscription réussie !"; } 
        else {
            echo "Inscription non réussie";
        }
?>