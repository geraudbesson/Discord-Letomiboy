<?php

    include_once '../auth-discord/connexion_bdd.php';
    include_once '../front/header.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idusers = mysqli_real_escape_string($conn, $_POST['idusers']);
        $img = mysqli_real_escape_string($conn, $_FILES['file']['name']);
        $idtheme = mysqli_real_escape_string($conn, $_POST['idtheme']);
    
        $nomFichier = $_FILES["file"]["name"];
        $cheminTemporaire = $_FILES["file"]["tmp_name"];
        
        $cheminFinal = "../img/Participants/" . $img;
        move_uploaded_file($cheminTemporaire, $cheminFinal);

        $requete = "INSERT INTO participants (idusers, img, idtheme, formulaire) VALUES ('$idusers', '$img', '$idtheme', 2);";
        
        if ($conn->query($requete) === TRUE) {
        } else {
            echo "Erreur lors de l'insertion des données : " . $conn->error;
        }

        header("Location: ../front/dashboard.php");
        $conn->close();
    }
?>