<?php
// Connexion à la base de données (à personnaliser avec vos propres informations de connexion)
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "";
$nomBaseDeDonnees = "concoursdiscord";

// Établir la connexion
$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

  
// Vérifier la connexion
if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}
?>