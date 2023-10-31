
<?php
    include_once 'header.php';
?>
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
<body><div class="container">
    <form action="traitement_vote.php" method="post">
        <h1>Choisissez votre/vos photo(s) favorites</h1><br>
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required><br><br>

        <div class="row">
        <?php
            require_once 'connexion.php';

            $sql = "SELECT * FROM participants";
            $photo_participants = $connexion->query($sql);

            while ($row = mysqli_fetch_assoc($photo_participants)) {
                $nomFichier = $row["file"];
                $idparticipant = $row["idparticipant"];
                $cheminImage = "Participants/" . $nomFichier;
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>" class="card-img-top">
                        <div class="card-body">
                            <input type="checkbox" id="participant_<?php echo $idparticipant; ?>" name="choix[]" value="<?php echo $idparticipant; ?>">
                            <label for="participant_<?php echo $idparticipant; ?>" class="card-title"><?php echo "Option ", $idparticipant; ?></label>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
    
    <script>
    function validerFormulaire() {
        var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
        if (checkboxes.length > 3) {
            alert('Vous ne pouvez sélectionner que 3 fichiers au maximum.');
            return false; // Empêche la soumission du formulaire si plus de 3 choix sont cochés
        }
        return true; // Autorise la soumission du formulaire si 3 choix ou moins sont cochés
    }

    // Limiter le nombre de cases à cocher à 3
    var checkboxes = document.querySelectorAll('input[type=checkbox]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var checkedCheckboxes = document.querySelectorAll('input[type=checkbox]:checked');
            if (checkedCheckboxes.length > 3) {
                alert('Vous ne pouvez sélectionner que 3 fichiers au maximum.');
                this.checked = false; // Désélectionne la case cochée
            }
        });
    });
</script>
</div>






</body>
</html>