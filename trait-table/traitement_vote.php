<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $pseudo = $_POST["pseudo"];
    $choix = $_POST["choix"];

    // Assurez-vous que vous avez au moins trois choix, sinon ajoutez des valeurs vides
    while (count($choix) < 3) {
        $choix[] = ''; // Ajoutez des valeurs vides pour remplir les trois choix
    }

    // Connexion à la base de données
    include_once '../auth-discord/connexion_bdd.php';

    // Construire la requête SQL avec les valeurs directement incluses
    $sql = "INSERT INTO votants (nomvotant, choix1, choix2, choix3) VALUES ('$pseudo', '$choix[0]', '$choix[1]', '$choix[2]')";

    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {
        echo "Données enregistrées avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement des données : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
    
    // Redirection vers index.html après 2 secondes
    header("Location: ../front/front-secondaire/confirmation-vote.php");
} else {
    echo "Erreur lors de la soumission du formulaire.";
}

?>
