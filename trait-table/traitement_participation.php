<?php

    include_once '../auth-discord/connexion_bdd.php';
    include_once '../front/header.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idusers = mysqli_real_escape_string($conn, $_POST['idusers']);
        $image = mysqli_real_escape_string($conn, $_FILES['file']['name']);
        $exifs = mysqli_real_escape_string($conn, $_POST['exifs']);
        $funfact = mysqli_real_escape_string($conn, $_POST['funfact']);
        $idtheme = mysqli_real_escape_string($conn, $_POST['idtheme']);
    
        $nomFichier = $_FILES["file"]["name"];
        $cheminTemporaire = $_FILES["file"]["tmp_name"];
        $cheminFinal = "../img/Participants/" . $image;

        // Vérifier les erreurs de téléchargement du fichier
        if ($_FILES['file']['error'] > 0) {
            echo 'Erreur lors du téléchargement du fichier : ' . $_FILES['file']['error'];
        } else {
            // Déplacer le fichier vers le dossier img-thème
            if (move_uploaded_file($cheminTemporaire, $cheminFinal)) {
                echo "Le fichier a été déplacé avec succès.";
            } else {
                echo "Erreur lors du déplacement du fichier.";
            }
        }

        $requete = "INSERT INTO participants (idusers, img, exifs, funfact, idtheme, formulaire) VALUES ('$idusers', '$image', '$exifs', '$funfact', '$idtheme', 1);";

        if ($conn->query($requete) === TRUE) {
            // ...
        } else {
            echo "Erreur lors de l'insertion des données : " . $conn->error;
        }

        header("Location: ../front/dashboard.php");
        $conn->close();
    }
?>