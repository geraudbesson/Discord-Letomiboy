<?php
// Connexion à la base de données (à personnaliser avec vos propres informations de connexion)
$serveur = "localhost"; // Serveur MySQL
$utilisateur = "root"; // Nom d'utilisateur MySQL
$motDePasse = ""; // Mot de passe MySQL
$nomBaseDeDonnees = "concoursdiscord"; // Nom de la base de données

// Établir la connexion
$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

// Récupération des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomparticipant = $_POST["nomparticipant"];
    $file = $_FILES["file"]["name"];
    $exifs = $_POST["exifs"];
    $funfact = $_POST["funfact"];
    
    echo "Nom participant: " . $nomparticipant . "<br>";
    echo "Nom du fichier: " . $file . "<br>";
    echo "Exifs: " . $exifs . "<br>";
    echo "Funfact: " . $funfact . "<br>";

    // Requête SQL pour insérer les données dans la table "participants"
    $requete = "INSERT INTO participants (nomparticipant, file, exifs, funfact) VALUES ('$nomparticipant', '$file', '$exifs', '$funfact')";

    // Exécution de la requête
    if ($connexion->query($requete) === TRUE) {
        echo "Les données ont été insérées avec succès dans la table participants.";
    } else {
        echo "Erreur lors de l'insertion des données : " . $connexion->error;
    }

    // Fermer la connexion à la base de données
    $connexion->close();
}
?>