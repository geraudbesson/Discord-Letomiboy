<?php

    include_once '../auth-discord/connexion_bdd.php';
    include_once '../front/header.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idusers = mysqli_real_escape_string($conn, $_POST['idusers']);
        $file = mysqli_real_escape_string($conn, $_FILES['file']['name']);
        $exifs = mysqli_real_escape_string($conn, $_POST['exifs']);
        $funfact = mysqli_real_escape_string($conn, $_POST['funfact']);
        $idtheme = mysqli_real_escape_string($conn, $_POST['idtheme']);
    
        $nomFichier = $_FILES["file"]["name"];
        $cheminTemporaire = $_FILES["file"]["tmp_name"];
        
        $cheminFinal = "../img/Participants/" . $file;
        move_uploaded_file($cheminTemporaire, $cheminFinal);

        $requete = "INSERT INTO participants_photo (idusers, file, exifs, funfact, idtheme) VALUES ('$idusers', '$file', '$exifs', '$funfact', '$idtheme');";
        
        if ($conn->query($requete) === TRUE) {
        } else {
            echo "Erreur lors de l'insertion des données : " . $conn->error;
        }

        header("Location: ../front/front-secondaire/confirmation-participation.php");
        $conn->close();
    }
?>