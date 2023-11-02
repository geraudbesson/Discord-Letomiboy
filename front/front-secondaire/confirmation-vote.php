<?php
    include_once '../connexion_bdd.php';
    include_once 'header.php';
?>

<h1>Votre vote a été enregistrée !</h1>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomparticipant = $_POST["nomparticipant"];
    $file = $_FILES["file"]["name"];
    $exifs = $_POST["exifs"];
    $funfact = $_POST["funfact"];
    echo "Nom participant: " . $nomparticipant . "<br>";
    echo "<div class='container'><div class='row align-items-start'><div class='col'>Votre participation<br> <img class ='participant' src='Participants/" . $file . "'></div>";
    echo "<div class='col'>Exifs<br> " . $exifs . "</div>";
    echo "<div class='col'>Funfact<br> " . $funfact . "</div></div>";}
?>
<a href="..index.php" class="btn btn-success">Retour à l'accueil</a>
