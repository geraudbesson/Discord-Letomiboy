
<?php
    include_once 'header.php';
    include_once '../auth-discord/connexion_bdd.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif - Voter</title>
    <link rel="icon" type="image/png" href="../img/Logo-Noir.png">
</head>
<body><div class="container">
        <form action="../trait-table/traitement_vote.php" method="post" onsubmit="return validerFormulaire();">
            <h1>Choisissez votre/vos photo(s) favorites</h1><br>
            <label for="pseudo">Pseudo :</label>
            <input type="text" id="pseudo" name="pseudo" required><br><br>

            <div class="row">
                <?php
                $sql = "SELECT * FROM participants";
                $photo_participants = $conn->query($sql);

                while ($row = mysqli_fetch_assoc($photo_participants)) {
                    $nomFichier = $row["file"];
                    $idparticipant = $row["idparticipant"];
                    $cheminImage = "../img/Participants/" . $nomFichier;
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <a href="<?php echo $cheminImage; ?>" data-lightbox="images" data-title="Option <?php echo $idparticipant; ?>">
                                <img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>" class="card-img-top">
                            </a>
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
    </div>


    <script>
        function validerFormulaire() {
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
            if (checkboxes.length > 3) {
                alert('Vous ne pouvez sélectionner que 3 fichiers au maximum.');
                return false;
            }
            return true;
        }

        var checkboxes = document.querySelectorAll('input[type=checkbox]');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var checkedCheckboxes = document.querySelectorAll('input[type=checkbox]:checked');
                if (checkedCheckboxes.length > 3) {
                    alert('Vous ne pouvez sélectionner que 3 fichiers au maximum.');
                    this.checked = false;
                }
            });
        });

        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        });
    </script>

    </div>
    
    <?php
        include('footer.php');
    ?>
</body>
</html>