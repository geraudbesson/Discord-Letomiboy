<?php

    include_once '../auth-discord/connexion_bdd.php';

    // Requête SQL pour récupérer les données de la table "participants"
    $requete = "SELECT * FROM participants_photo p LEFT JOIN users u ON u.idusers = p.idusers LEFT JOIN theme t ON t.idtheme = p.idtheme WHERE participer = 1";
    $resultat = $conn->query($requete);

    // Créer un tableau associatif des résultats
    $data = array();
    while ($row = $resultat->fetch_assoc()) {
        $data[] = $row;
    }

    // Retourner les données au format JSON
    echo json_encode($data);

    // Fermer la connexion à la base de données
    $conn->close();
?>
