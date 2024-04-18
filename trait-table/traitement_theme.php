<?php
include_once '../auth-discord/connexion_bdd.php';
include_once '../front/header.php';

// Récupération des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img = mysqli_real_escape_string($conn, $_FILES['file']['name']);
    $text = mysqli_real_escape_string($conn, $_POST['text']);
    $dateFinTheme = mysqli_real_escape_string($conn, $_POST['date']);
    $concours = mysqli_real_escape_string($conn, $_POST['concours']);

    // Récupérer le nom du fichier et son chemin temporaire
    $cheminTemporaire = $_FILES["file"]["tmp_name"];
    
    // Déplacer le fichier vers le dossier img-thème
    $cheminFinal = "../img/img-theme/" . $img;
    move_uploaded_file($cheminTemporaire, $cheminFinal);

    // Message par défaut
    $message = "Ajout du thème réussi.";

    // Personnaliser le message en fonction du choix dans le menu déroulant
    if ($concours == "1") {
        $message = "Le thème '$text' pour le concours photo a été enregistré.";
    } elseif ($concours == "2") {
        $message = "Le fichier raw '$text' pour le concours retouche a été enregistré.";
    }

    // Requête SQL pour insérer les données dans la table "theme" avec le champ concours
    $requete = "INSERT INTO theme (nomimg, theme, datefintheme, concours) VALUES ('$img', '$text', '$dateFinTheme', '$concours')";

    // Exécution de la requête
    if ($conn->query($requete) === TRUE) {
        // Ajout réussi, afficher une alerte avec le message personnalisé
        echo '<script>alert("'.$message.'");</script>';
        // Redirection vers admin.php après 2 secondes
        echo '<script>window.location.href="../front/admin.php";</script>';
    } else {
        echo "Erreur lors de l'insertion des données : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
