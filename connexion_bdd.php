<?php

$serveur = "localhost";
$user = "root";
$pasword = "";
$dbname = "concoursdiscord";

// Établir la connexion
$conn = mysqli_connect($serveur, $user, $pasword, $dbname);

  
// Vérifier la connexion
if ($conn->connect_error) {
    die("Une erreur s'est produite, merci de réessayer : " . $conn->connect_error);
}
?>