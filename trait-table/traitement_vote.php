<?php
session_start();

// Inclure le fichier de connexion à la base de données
include '../auth-discord/connexion_bdd.php';

// Extraire les données de la session
extract($_SESSION['userData']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'idusers de l'utilisateur connecté à partir du discord_username
    $sql_user = "SELECT idusers FROM users WHERE discord_username = '$name'";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $idusers = $row_user["idusers"];

        // Récupérer les données du formulaire
        if(isset($_POST['participants'])){
            $values = [];
            foreach($_POST['participants'] as $participant){
                $idparticipant = $participant['idparticipant'];
                $note = $participant['note'];
                // Échapper les valeurs pour éviter les attaques par injection SQL
                $idparticipant = mysqli_real_escape_string($conn, $idparticipant);
                $note = mysqli_real_escape_string($conn, $note);
                // Ajouter les valeurs à la liste des valeurs à insérer
                $values[] = "('$idparticipant', '$idusers', '$note')";
            }

            // Construire la requête SQL avec les valeurs incluses
            $sql = "INSERT INTO votants (idparticipant, idusers, note) VALUES " . implode(", ", $values);

            // Exécuter la requête
            if ($conn->query($sql) === TRUE) {
                echo "Données enregistrées avec succès.";
            } else {
                echo "Erreur lors de l'enregistrement des données : " . $conn->error;
            }
        }

        // Fermer la connexion à la base de données
        $conn->close();
        
        // Redirection vers index.html après 2 secondes
        header("Location: ../front/front-secondaire/confirmation-vote.php");
    } else {
        echo "Erreur lors de la récupération de l'idusers de l'utilisateur connecté.";
    }
} else {
    echo "Erreur lors de la soumission du formulaire.";
}
?>
