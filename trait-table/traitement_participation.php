<?php

    include_once 'connexion_bdd.php';
    include_once 'header.php';
    include('connexion_bdd_discord.php');

    // Récupération des données du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomparticipant = mysqli_real_escape_string($conn, $_POST['nomparticipant']);
        $file = mysqli_real_escape_string($conn, $_FILES['file']['name']);
        $exifs = mysqli_real_escape_string($conn, $_POST['exifs']);
        $funfact = mysqli_real_escape_string($conn, $_POST['funfact']);
    
        // Récupérer le nom du fichier et son chemin temporaire
        $nomFichier = $_FILES["file"]["name"];
        $cheminTemporaire = $_FILES["file"]["tmp_name"];
        
        // Déplacer le fichier vers le dossier img-thème
        $cheminFinal = "Participants/" . $file;
        move_uploaded_file($cheminTemporaire, $cheminFinal);

        // Requête SQL pour insérer les données dans la table "participants"
        $requete = "INSERT INTO participants (nomparticipant, file, exifs, funfact) VALUES ('$nomparticipant', '$file', '$exifs', '$funfact')";

        // Exécution de la requête
        if ($conn->query($requete) === TRUE) {
        } else {
            echo "Erreur lors de l'insertion des données : " . $conn->error;
        }

        // Redirection vers index.html après 2 secondes
        header("Location: confirmation-participation.php");
        // Fermer la connexion à la base de données
        $conn->close();
    }
?>