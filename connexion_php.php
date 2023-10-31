<?php
// Vos informations de connexion (à remplacer par votre propre base de données)
$correct_username = "admin";
$correct_password = "1234";

// Récupération des données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];

// Vérification des informations
if ($username == $correct_username && $password == $correct_password) {
    // Redirection vers la page protégée si les informations sont correctes
    header("Location: admin.php");
    exit();
} else {
    // Redirection vers la page de login avec un message d'erreur si les informations sont incorrectes
    header("Location: index.php?error=1");
    exit();
}
?>
