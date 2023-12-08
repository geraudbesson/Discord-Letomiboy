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

        function checkParticiperValue($name, $conn) {
            $sql_select_participer = "SELECT participer FROM participants_retouche p INNER JOIN users u ON u.idusers = p.idusers WHERE u.discord_username = '$name' AND participer = 1";
            $result_participer = $conn->query($sql_select_participer);

            if ($result_participer === FALSE) {
                echo "Erreur dans la requête : " . $conn->error;
                return false;
            } else {
                if ($result_participer->num_rows > 0) {
                    echo '<script>
                            if(confirm("Tu as déjà participé ! Cliques sur OK pour aller sur ton dashboard. Cliques sur Annuler pour revenir à l\'accueil")) {
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
            ($_SESSION['userData']['role'] == 'concours' || $_SESSION['userData']['role'] == 'admin') && checkFormValue(1, $conn) && !checkParticiperValue($name, $conn)
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
    <meta name="viewport" content="width=device-width">
    <title>Concours Créatif - Participer</title> 
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
</head>
<body>
    <div class="container-form">
    
    <h2>Hey <?php echo $name?>, Tu peux soumettre ta participation via le formulaire ci-dessous.</h2>
    <p>Veuille à bien lire le règlement</p>
        <div class="content-box">
            <div class="info-box">
                <h1 style="margin-bottom: 25px;">Informations à propos du concours</h1>
                <div class="separator"></div>
                <li style="margin-top: 25px;">Vous avez 3 semaines pour soumettre votre photo dans ce formulaire ci-contre</li>
                <li>1 seule photo sera acceptée.</li>
                <li>Merci de donner l’appareil utilisé et les réglages si vous les avez.</li>
                <li>Aucun changement n’est possible, donc choisissez bien la photo que vous proposez pour le concours.</li>
                <li>La photo doit avoir été prise durant les 3 mois précedent l'annonce du thème si vous ne parvenez pas durant le mois en cours.</li>
                <li>Si l'une des règles n'est pas respectée nous vous demanderons de modifier votre photo.</li>
            </div>
            <div class="form-box">
                <h1>Soumettre votre participation</h1>
                <form action="../trait-table/traitement_participation.php" method="post" enctype="multipart/form-data">
                    <?php
                    extract($_SESSION['userData']);

                    // Requête SQL pour obtenir l'idusers associé au nom d'utilisateur Discord
                    $sql = "SELECT idusers FROM users WHERE discord_username = '$name'";

                    // Exécutez la requête SQL
                    $result = mysqli_query($conn, $sql);

                    // Vérifiez si la requête a réussi et s'il y a un résultat
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Récupérez la ligne de résultats
                        $row = mysqli_fetch_assoc($result);
                        
                        // Obtenez l'idusers associé au nom d'utilisateur Discord
                        $idusers = $row['idusers'];

                        // Utilisez $idusers dans votre formulaire
                        ?>
                        <div class="row">
                            <div class="form-floating mb-3">
                                <input type="hidden" id="texte" name="idusers" value="<?php echo $idusers ?>">
                            </div>
                    <?php
                    } else {
                        // Si aucun résultat n'est trouvé, affichez un message d'erreur ou prenez une autre action appropriée
                        echo "Erreur : Aucun utilisateur trouvé pour le nom d'utilisateur Discord : $name";
                    }
                    ?>

                        <div class="mb-3">
                            <label for="file" class="col-sm-2 col-form-label">Téléverser un Fichier:</label>
                            <input type="file" id="file" name="file" class="form-control" required>
                        </div>
                    </div>
                        
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" id="texte2" name="exifs"class="form-control is-invalid" id="validationTextarea" placeholder="Required example textarea" required></input>
                                <label for="texte2" id="floatingInput">EXIFS:</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" id="texte3" name="funfact" class="form-control" id="floatingInput"></input>
                                <label for="texte3" id="floatingInput">Anecdotes et funfacts:</label>
                            </div>
                        </div>
                        <?php 
                            $sql = "SELECT * FROM theme ORDER BY idtheme DESC LIMIT 1;";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $lastThemeId = $row['idtheme'];
                            ?>
                        <div class="form-floating mb-3">
                            <input type="hidden" id="texte" name="idtheme" value="<?php echo $lastThemeId?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" class="btn btn-primary" value="Valider">
                    </div>
                </form>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
