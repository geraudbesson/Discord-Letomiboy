<?php

    include_once '../auth-discord/connexion_bdd.php';
    include_once '../front/header.php';

    // Récupération des données du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $img = mysqli_real_escape_string($conn, $_FILES['file']['name']);
        $text = mysqli_real_escape_string($conn, $_POST['text']);

        // Récupérer le nom du fichier et son chemin temporaire
        $nomFichier = $_FILES["file"]["name"];
        $cheminTemporaire = $_FILES["file"]["tmp_name"];
        
        // Déplacer le fichier vers le dossier img-thème
        $cheminFinal = "../img/img-theme/" . $img;
        move_uploaded_file($cheminTemporaire, $cheminFinal);

        // Requête SQL pour insérer les données dans la table "participants"
        $requete = "INSERT INTO theme (nomimg, theme) VALUES ('$img', '$text')";

        // Exécution de la requête
        if ($conn->query($requete) === TRUE) {
        } else {
            echo "Erreur lors de l'insertion des données : " . $conn->error;
        }

        // Redirection vers index.html après 2 secondes
        header("Location: ../front/admin.php");
        // Fermer la connexion à la base de données
        $conn->close();
    }
?>