<?php

    include_once 'connexion_bdd.php';

    // Requête SQL pour récupérer les données de la table "participants"
    $requete = "SELECT votants.idvotant, votants.nomvotant, 
    participants1.nomparticipant AS choix1_nom, 
    participants2.nomparticipant AS choix2_nom, 
    participants3.nomparticipant AS choix3_nom
    FROM votants
    LEFT JOIN participants AS participants1 ON votants.choix1 = participants1.idparticipant
    LEFT JOIN participants AS participants2 ON votants.choix2 = participants2.idparticipant
    LEFT JOIN participants AS participants3 ON votants.choix3 = participants3.idparticipant;";
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