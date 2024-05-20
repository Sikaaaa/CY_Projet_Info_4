<?php

// Détruire toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, effacez également le cookie de session.
//if (ini_get("session.use_cookies")) {
  //  $params = session_get_cookie_params();
    //setcookie(session_name(), '', time() - 42000,
      //  $params["path"], $params["domain"],
        //$params["secure"], $params["httponly"]
   // );
//}

// Supprimer le cookie de l'utilisateur
if (isset($_COOKIE['email'])) {
    setcookie('email', '', time() - 3600, "/"); // Expire immédiatement
}

// Finalement, détruire la session
session_destroy();

echo "Vous avez été déconnecté. ";
header('Location: /accueil.html');
exit();

*