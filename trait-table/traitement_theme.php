<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le dossier "img-thème" existe, sinon le créer
    if (!is_dir("img-thème")) {
        mkdir("img-thème");
    }

    // Récupérer le nom du fichier et son chemin temporaire
    $nomFichier = $_FILES["image"]["name"];
    $cheminTemporaire = $_FILES["image"]["tmp_name"];

    // Déplacer le fichier vers le dossier img-thème
    $cheminFinal = "img-thème/" . $nomFichier;
    move_uploaded_file($cheminTemporaire, $cheminFinal);

    echo "Image uploadée avec succès !<br>";

    // Enregistrez le chemin de l'image dans un fichier texte (chemin.txt)
    file_put_contents("chemin.txt", $cheminFinal);
    echo "Image importée et le fichier 'chemin.txt' a été créé.";

    // Redirection vers index.html après 2 secondes
    header("Location: admin.php");
} else {
    echo "Erreur lors de l'envoi du formulaire.";
}
?>
