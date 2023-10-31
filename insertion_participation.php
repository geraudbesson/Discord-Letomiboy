<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif - Voter</title>
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<?php

    include_once 'connexion.php';
    include_once 'header.php';

    // Récupération des données du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomparticipant = $_POST["nomparticipant"];
        $file = $_FILES["file"]["name"];
        $exifs = $_POST["exifs"];
        $funfact = $_POST["funfact"];
        $nomparticipant = mysqli_real_escape_string($connexion, $_POST['nomparticipant']);
        $file = mysqli_real_escape_string($connexion, $_FILES['file']['name']);
        $exifs = mysqli_real_escape_string($connexion, $_POST['exifs']);
        $funfact = mysqli_real_escape_string($connexion, $_POST['funfact']);
    
        // Récupérer le nom du fichier et son chemin temporaire
        $nomFichier = $_FILES["file"]["name"];
        $cheminTemporaire = $_FILES["file"]["tmp_name"];
        
        // Déplacer le fichier vers le dossier img-thème
        $cheminFinal = "Participants/" . $file;
        move_uploaded_file($cheminTemporaire, $cheminFinal);

        // Requête SQL pour insérer les données dans la table "participants"
        $requete = "INSERT INTO participants (nomparticipant, file, exifs, funfact) VALUES ('$nomparticipant', '$file', '$exifs', '$funfact')";

        // Exécution de la requête
        if ($connexion->query($requete) === TRUE) {
        } else {
            echo "Erreur lors de l'insertion des données : " . $connexion->error;
        }

        // Redirection vers index.html après 2 secondes
        header("Location: confirmation-participation.php");
        // Fermer la connexion à la base de données
        $connexion->close();
    }
?>
</html>
<style>
    .participant{
        max-width: 500px;
        max-height: 500px;
    }
</style>