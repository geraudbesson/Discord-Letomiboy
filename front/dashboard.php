<?php

    include_once 'header.php';
    include_once '../auth-discord/connexion_bdd.php';

if(!$_SESSION['logged_in']){
    header('Location: ../auth-discord/init-oauth.php');
    exit();
}

extract($_SESSION['userData']);

$avatar_url = "https://cdn.discordapp.com/avatars/$discord_id/$avatar.jpg";

$sql = "SELECT * FROM participants_photo p INNER JOIN users u ON u.idusers = p.idusers WHERE discord_username = '$name' ORDER BY date DESC LIMIT 1;";
    $imgparticipant = $conn->query($sql);
    if ($imgparticipant->num_rows > 0) {
    $row = $imgparticipant->fetch_assoc();
    $nomFichier = $row["file"];
    $exifs = $row["exifs"];
    $funfact = $row["funfact"];
    $idparticipant = $row["idparticipant"];
    $cheminImage = "../img/Participants/" . $nomFichier;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif</title>
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <h1 class="titre-dashboard">Bienvenue sur ton espace perso, <?php echo $name?></h1>
    <?php
        $sql = "SELECT * FROM theme ORDER BY idtheme DESC LIMIT 1;";
        $result = $conn->query($sql);
        
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Récupération de la première ligne du résultat
        $theme = $row["theme"];
        ?> <h2 class="titre-dashboard">Voici ta participation pour le thème <?php echo $theme?>.</h2> <?php
    } else {
    ?>
    <h2 class="titre-dashboard">Vous n'avez pas encore envoyé votre participation pour ce thème.</h2>
    <?php } ?>
    <div class="container mt-5">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <img src="<?php echo $avatar_url?>" style="width: 42px; height: 42px; border-radius: 50%;" />
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><b><u>Concours photo:</b>
                    <?php
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc(); // Récupération de la première ligne du résultat
                        $theme = $row["theme"];
                        ?> <?php echo $theme?></u>.<?php
                    } else { ?>
                    <?php } ?></button> 
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Concours retouche</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Archives</button>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="déco-tab" href="front-secondaire/logout.php" role="tab" aria-controls="contact" aria-selected="false">Se déconnecter</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <?php
                $sql = "SELECT * FROM participants_photo p INNER JOIN users u ON u.idusers = p.idusers INNER JOIN theme t on t.idtheme = p.idtheme WHERE discord_username = '$name' AND participer = 1 LIMIT 1;";
                $particip = $conn->query($sql);
                    if ($particip->num_rows > 0) {
                        $row = $particip->fetch_assoc(); // Récupération de la première ligne du résultat
                        $theme = $row["theme"];
                        ?>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Votre participation</th>
                                    <th>Exifs</th>
                                    <th>Funfacts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td style="width: 250px;"><img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>" style="width: 250px; height: auto;"></td>
                                <td style="width: 250px;"><?php echo $exifs; ?></td>
                                <td style="width: 250px;"><?php echo $funfact; ?></td>
                            </tbody>
                        </table>
                    <?php } else {
                        echo '<h3> Vous n\'avez pas encore participer</h3> 
                        <a href="participer.php" class="btn btn-primary">Je veux participer</a>';
                        }?>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <h2>Work in progress</h2>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <?php 
                $sqll = "SELECT * FROM participants_photo pp INNER JOIN theme t ON t.idtheme=pp.idtheme WHERE pp.nomparticipant = '$name' AND pp.participer = 0;";
                $photo_participants = $conn->query($sqll);
                $count = 0; // Variable pour compter le nombre d'éléments générés
                        
                while ($row = mysqli_fetch_assoc($photo_participants)) {
                    $nomFichier = $row["file"];
                    $idparticipant = $row["idparticipant"];
                    $theme = $row["theme"];
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
    <footer>
        <div class="footer-content">
            <p>&copy; 2023 Votre Nom / Nom de votre entreprise<br></p>
            <div class="social-icons">
                <a href="#"><img src="../img/facebook.webp" ></a>
                <a href="#"><img src="../img/twitter.png" ></a>
                <a href="#"><img src="../img/instagram.png" ></a>
            </div>
        </div>
    </footer>
</body>
</html>