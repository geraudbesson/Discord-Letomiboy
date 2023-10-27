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

// Requête SQL pour récupérer les données de la table "participants"
$requete = "SELECT nomparticipant, file, exifs, funfact FROM participants";
$resultat = $connexion->query($requete);

// Créer un tableau associatif des résultats
$data = array();
while ($row = $resultat->fetch_assoc()) {
    $data[] = $row;
}

// Retourner les données au format JSON
echo json_encode($data);

// Fermer la connexion à la base de données
$connexion->close();
?>
