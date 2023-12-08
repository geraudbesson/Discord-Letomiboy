
<?php
        include_once 'header.php';
        include_once '../auth-discord/connexion_bdd.php';

        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            echo '<script>
                alert("Erreur : Vous n\'êtes pas connecté.");
                window.location.href = "http://localhost/site/auth-discord/init-oauth.php";
            </script>';
            exit();
        }
        if (!isset($_SESSION['userData']) || !is_array($_SESSION['userData'])) {
            echo '<script>
                    alert("Erreur : Données utilisateur indisponibles.");
                    window.location.href = "index.php";
                </script>';
            exit();
        }

        extract($_SESSION['userData']);

        function checkFormValue($expectedValue, $conn) {
            $sql_select = "SELECT formretouche FROM formulaire WHERE formretouche = $expectedValue";
            $result = $conn->query($sql_select);

            if ($result === FALSE) {
                echo '<script>
                    alert("Le formulaire est indisponible pour le moment.");
                    window.location.href = "dashboard.php";
                </script>';
                return false;
            } else {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $currentFormValue = $row["formretouche"];
                    return $currentFormValue == $expectedValue;
                } else {
                    echo '<script>
                        alert("Formulaire indisponible");
                        window.location.href = "dashboard.php";
                    </script>';
                    return false;
                }
            }
        }

        function checkVoterValue($name, $conn) {
            $sql_select_voter = "SELECT * FROM votants_retouche v INNER JOIN users u ON u.idusers = v.idusers WHERE u.discord_username = '$name' AND voter = 1";
            $result_voter = $conn->query($sql_select_voter);

            if ($result_voter === FALSE) {
                echo "Erreur dans la requête : " . $conn->error;
                return false;
            } else {
                if ($result_voter->num_rows > 0) {
                    echo '<script>
                            if(confirm("Tu as déjà voter ! Cliques sur OK pour aller sur ton dashboard. Cliques sur Annuler pour revenir à l\'accueil")) {
                                window.location.href = "dashboard.php";
                            } else {
                                window.location.href = "index.php";
                            }
                        </script>';
                    return true;
                } else {
                    return false;
                }
            }
        }

        // Vérifier la condition du formulaire et de la participation
        if (
            ($_SESSION['userData']['role'] == 'concours' || $_SESSION['userData']['role'] == 'admin') && checkFormValue(2, $conn) && !checkVoterValue($name, $conn)
        ) {
        } else {
            echo '<script>
                $(document).ready(function(){
                    $("#myModal").modal();
                });
            </script>';
            exit();
        }
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif - Voter</title>
    <link rel="icon" type="image/png" href="../img/Logo-Noir.png">
    <style>
    /* Style pour les boutons carrés */
    label {
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    input[type="radio"] {
        display: none; /* Cache l'input radio par défaut */
    }

    label {
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        width: 30px; /* Largeur fixe pour les boutons carrés */
        height: 30px; /* Hauteur fixe pour les boutons carrés */
        text-align: center;
        line-height: 30px; /* Pour centrer le texte verticalement */
        border: 1px solid #007bff;
        border-radius: 5px;
        font-weight: bold;
        font-size: 16px;
    }

    input[type="radio"]:checked + label {
        background-color: #007bff;
        color: #fff;
    }

</style>

</head>
<body><div class="container">
        <form action="../trait-table/traitement_vote.php" method="post" onsubmit="return validerFormulaire();">
            <h1>Donnez vos notes pour les photos suivantes</h1><br>
            <input type="hidden" id="pseudo" name="pseudo" value="<?php echo $name?>" ><br><br>
            <div class="row">
                <?php
                $sql = "SELECT * FROM participants_photo p INNER JOIN users u ON u.idusers = p.idusers WHERE participer = 1";
                $photo_participants = $conn->query($sql);
                while ($row = mysqli_fetch_assoc($photo_participants)) {
                    $nomFichier = $row["file"];
                    $idparticipant = $row["idparticipant"];
                    $discord_username = $row["discord_username"];
                    $cheminImage = "../img/Participants/" . $nomFichier;
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <a href="<?php echo $cheminImage; ?>" data-lightbox="images" data-title="Option <?php echo $idparticipant; ?>">
                                <img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>" class="card-img-top">
                            </a>
                            <div class="card-body">
                                <?php if ($discord_username == $name) : ?>
                                    <fieldset disabled>
                                        <input type="text"
                                            id="disabledTextInput"
                                            class="form-control"
                                            placeholder="<?php echo $name ?>">
                                    </fieldset>
                                <?php else : ?>
                                    <input type="hidden"
                                        name="participants[<?php echo $idparticipant; ?>][idparticipant]"
                                        value="<?php echo $idparticipant; ?>">

                                    <?php
                                    $lettres = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                                    for ($i = 10; $i >= 1; $i--) {
                                        $lettre = isset($lettres[10 - $i]) ? $lettres[10 - $i] : '';
                                        if (!empty($lettre)) {
                                            ?>
                                            <input type="radio"
                                                name="participants[<?php echo $idparticipant; ?>][note]"
                                                id="note_<?php echo $idparticipant . '_' . $lettre; ?>"
                                                value="<?php echo $i; ?>"
                                                required>
                                            <label for="note_<?php echo $idparticipant . '_' . $lettre; ?>"><?php echo $lettre; ?></label>
                                            <?php if ($lettre == 'E') : ?>
                                                <br>
                                            <?php endif; ?>
                                        <?php }
                                    } ?>
                                <?php endif; ?>
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
    </div>
    <?php
        include('footer.php');
    ?>
</body>
</html>