<?php
    include_once 'header.php';
    include_once '../auth-discord/connexion_bdd.php';
    
    session_start();
    if(!$_SESSION['logged_in']){
        header('Location: front-secondaire/error.php');
        exit();
    }else if($_SESSION['userData']['role'] != 'concours' && $_SESSION['userData']['role'] != 'admin') {
        header("location: index.php?error=not_concours");
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

                <div class="row">
                    <div class="form-floating mb-3">
                        <input id="texte" name="nomparticipant">
                        <label for="texte">Votre pseudonyme Discord:</label>
                    </div>
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
                            <input type="text" id="texte3" name="funfact" class="form-control" id="floatingInput" placeholder="name@example.com"></input>
                            <label for="texte3" id="floatingInput">Anecdotes et funfacts:</label>
                        </div>
                    </div>
                </div>
                    
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Je certifie être niveau 3 et avoir le rôle [✔] Concours|ON sur le serveur discord.
                            </label>
                        </div>
                    </div>

                <div class="col-12">
                    <input type="submit" class="btn btn-primary" value="Valider">
                </div>
            </form>
        </div>
    </div>
    
    <?php
        include('footer.php');
    ?>
</body>

</html>
