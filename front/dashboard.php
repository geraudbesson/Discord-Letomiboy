<?php

    include_once 'header.php';
    include_once '../auth-discord/connexion_bdd.php';

if(!$_SESSION['logged_in']){
    header('Location: ../auth-discord/init-oauth.php');
    exit();
}
extract($_SESSION['userData']);
$avatar_url = "https://cdn.discordapp.com/avatars/$discord_id/$avatar.jpg";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif</title>
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
    .container-fluid {
      display: flex; /* Utilisez flex pour aligner les enfants côte à côte */
      padding: 20px;
    }
    .nav-tabs {
      width: 25%;
      height: 100%;
      background-color: #f8f9fa;
    }    
    .nav-tabs .nav-item {
      width: 100%;
    }

    .nav-tabs .nav-link {
      width: 100%;
    }
    .tab-content {
      padding-left: 75px;
    }
    .dashboard-perso{
        display: flex;
        justify-content: space-between;
    }
    .carte{
        width: 30%;
        background-color: #f8f9fa;
        text-align: center;
        padding: 25px;
        border: 2px solid;
        border-radius: 10px;
    }
    .concours-part{
        display: flex;
        justify-content: space-between;
    }
    .moitier-gauche{
        background-color: #fff;
        width: 45%;
    }
    .moitier-droite{
        background-color: #fff;
        width: 45%;
    }
    .card-off{
        padding: 16px;

    }
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
<body>
    <h1 class="titre-dashboard">Bienvenue sur ton espace perso, <?php echo $name?></h1>
    <div class="container-fluid">
            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                <li class="nav-item" role="Dashboard">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                    <img src="<?php echo $avatar_url?>" style="width: 42px; height: 42px; border-radius: 50%;" /> 
                    <?php echo $name ?></button>
                </li>
                <li class="nav-item" role="concoursphoto">
                    <button class="nav-link" id="concoursphoto-tab" data-bs-toggle="tab" data-bs-target="#concoursphoto" type="button" role="tab" aria-controls="home" aria-selected="false">Concours Photo</button> 
                </li>
                <li class="nav-item" role="Concours photo">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Concours retouche</button>
                </li>
                <li class="nav-item" role="Concours Retouche">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Archives</button>
                </li>
                <li class="nav-item" role="Archive">
                    <a class="nav-link" id="déco-tab" href="front-secondaire/logout.php" role="tab" aria-controls="contact" aria-selected="false">Se déconnecter</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h2>Hey, voici ton dashboard personnel</h2>
                    <div class="dashboard-perso">
                        <div class="carte">
                            <p>Nombre de concours photo participer:</p><br>
                            <p>Meilleure place obtenue:</p>
                        </div>
                        <div class="carte">
                            <p>Nombre de concours retouche participer:</p><br>
                            <p>Meilleure place obtenue:</p>
                        </div>
                        <div class="carte">
                            <p>Autre:</p>
                        </div>
                    </div>
                    <div class="concours-part">
                        <div class="moitier-gauche">
                            <?php
                            $sql = "SELECT * FROM participants_photo p INNER JOIN users u ON u.idusers = p.idusers INNER JOIN theme t on t.idtheme = p.idtheme WHERE discord_username = '$name' AND participer = 1 LIMIT 1;";
                            $particip = $conn->query($sql);
                            if ($particip->num_rows > 0) {
                                $row = $particip->fetch_assoc();
                                $nomFichier = $row["file"];
                                $theme = $row["theme"];
                                $exifs = $row["exifs"];
                                $funfact = $row["funfact"];
                                $idparticipant = $row["idparticipant"];
                                $cheminImage = "../img/Participants/" . $nomFichier;
                                ?>
                                <div class="card-body">
                                    <div class="row mb-4">
                                            <div class="card card-off">
                                                <p for="participant_<?php echo $idparticipant; ?>" class="card-title"><b><?php echo "Thème: ", $theme; ?></b></p>
                                                <a href="<?php echo $cheminImage; ?>" data-lightbox="images" data-title="Option <?php echo $idparticipant; ?>">
                                                    <img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>" class="card-img-top">
                                                </a>
                                            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="exifs-tab" data-toggle="tab" href="#exifs" role="tab" aria-controls="exifs" aria-selected="true">Exifs</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="funfact-tab" data-toggle="tab" href="#funfact" role="tab" aria-controls="funfact" aria-selected="false">Funfact</a>
                                                </li>
                                            </ul>
                                                <div class="tab-pane fade show active" id="exifs" role="tabpanel" aria-labelledby="exifs-tab">
                                                    <?php echo $exifs; ?>
                                                </div>
                                                <div class="tab-pane fade" id="funfact" role="tabpanel" aria-labelledby="funfact-tab">
                                                    <?php echo $funfact; ?>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <?php } else {
                                    echo '
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="card card-off">
                                                <h3> Tu n\'as pas encore participé au <br> concours photo</h3> 
                                                    <a href="participer.php" class="btn btn-primary">Je veux participer</a>
                                            </div>
                                        </div>
                                    </div>';
                                    }?>
                            </div>
                        <div class="moitier-droite">
                            <?php
                            $sql = "SELECT * FROM participants_retouche p INNER JOIN users u ON u.idusers = p.idusers INNER JOIN raw r on r.idraw = p.idraw WHERE discord_username = '$name' AND participer = 1 LIMIT 1;";
                            $participret = $conn->query($sql);

                            if ($participret->num_rows > 0) {
                                $row = $participret->fetch_assoc(); // Fix the typo here
                                $nomFichier = $row["file"];
                                $raw = $row["nomraw"];
                                $cheminImage = "../img/Participants/" . $nomFichier;
                                $idparticipantretouche = $row["idparticipantretouche"]; // Define $idparticipantretouche

                                ?>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="card card-off">
                                            <p for="participant_<?php echo $idparticipantretouche; ?>" class="card-title"><b><?php echo "Thème: ", $raw; ?></b></p>
                                            <a href="<?php echo $cheminImage; ?>" data-lightbox="images" data-title="Option <?php echo $idparticipantretouche; ?>">
                                                <img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>" class="card-img-top">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } else {
                                echo '
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="card card-off">
                                            <h3> Tu n\'as pas encore participé au <br> concours retouche</h3> 
                                                <a href="participer-retouche.php" class="btn btn-primary">Je veux participer</a>
                                        </div>
                                    </div>
                                </div>';
                            }?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="concoursphoto" role="tabpanel" aria-labelledby="concoursphoto-tab">
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
                                            // Récupérer la note attribuée pour ce participant
                                            $sqlNote = "SELECT note FROM votants WHERE idparticipant = '$idparticipant' AND discord_username = '$name'";
                                            $resultNote = $conn->query($sqlNote);

                                            if ($resultNote !== false && $resultNote->num_rows > 0) {
                                                // Il y a une note attribuée
                                                $note = $resultNote->fetch_assoc()['note'];
                                            } else {
                                                // Aucune note attribuée, initialiser à 0 par défaut
                                                $note = 0;
                                            }
                                            ?>

                                            <?php
                                            if ($note >= 1 && $note <= 10) {
                                                $lettre = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'][$note - 1];
                                            } else {
                                                // Gérer le cas où la note n'est pas dans la plage valide
                                                $lettre = ''; // ou une valeur par défaut appropriée
                                            }
                                            echo "ID Participant: $idparticipant, Note: $note, Lettre: $lettre<br>";
                                            ?>
                                            <input type="radio"
                                                name="participants[<?php echo $idparticipant; ?>][note]"
                                                id="note_<?php echo $idparticipant . '_' . $lettre; ?>"
                                                value="<?php echo $note; ?>"
                                                required>
                                            <label for="note_<?php echo $idparticipant . '_' . $lettre; ?>"><?php echo $lettre; ?></label>
                                            
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h2>Work in progress</h2>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <?php 
                    $sqll = "SELECT * FROM participants_photo p INNER JOIN theme t ON t.idtheme= p.idtheme INNER JOIN users u ON u.idusers= p.idusers WHERE u.discord_username = '$name' AND p.participer = 0;";
                    $photo_participants = $conn->query($sqll);
                    $count = 0; // Variable pour compter le nombre d'éléments générés
                            
                    while ($row = mysqli_fetch_assoc($photo_participants)) {
                        $nomFichier = $row["file"];
                        $idparticipant = $row["idparticipant"];
                        $theme = $row["theme"];
                        $idtheme = $row["idtheme"];
                        $datedebuttheme = $row["datedebuttheme"];
                        $datefintheme = $row["datefintheme"];
                        $cheminImage = "../img/Participants/" . $nomFichier;
                            
                        // Extraction du mois et de l'année de datedebuttheme et datefintheme en français avec les trois premières lettres du mois et l'année
                        $moisDebutTheme = date('M Y', strtotime($datedebuttheme));
                        $moisFinTheme = date('M Y', strtotime($datefintheme));
                        ?>

                        <?php if ($count % 3 == 0) { ?>
                            <div class="row mb-4">
                                <?php } ?>
                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="<?php echo $cheminImage; ?>" data-lightbox="images" data-title="Option <?php echo $idparticipant; ?>">
                                            <img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>" class="card-img-top">
                                        </a>
                                        <div class="card-body">
                                            <p for="participant_<?php echo $idparticipant; ?>" class="card-title"><?php echo "Theme: ", $theme, "<br> (De ", $moisDebutTheme, " à ", $moisFinTheme, ")"; ?></p>
                                            <a href="archivetheme.php?idtheme=<?php echo$idtheme; ?>" class="btn btn-primary">Découvrir les clichés </a>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($count % 3 == 2) { ?>
                            </div>
                                <?php } ?>
                                <?php 
                                $count++;
                    } 
                    // Vérifiez si la dernière ligne est incomplète et fermez-la correctement
                    if ($count % 3 != 0) { ?>
                </div>
                    <?php } ?>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <p>&copy; 2023 Concours Créatif / Discord Letomiboy</p>
            <div class="social-icons">
                <a href="#"><img src="../img/facebook.webp" ></a>
                <a href="#"><img src="../img/twitter.png" ></a>
                <a href="#"><img src="../img/instagram.png" ></a>
            </div>
        </div>
    </footer>
</body>
</html>