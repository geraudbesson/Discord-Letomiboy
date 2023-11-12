<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif</title>
    <link rel="icon" type="image/png" href="../img/Logo-Noir.png">
</head>
<body>
    <?php
        include_once 'header.php';
    ?>

    <div class="content">
        <div class="rules-box">
            <h1>Règlement du concours :</h1>
            <p class="h2">Bienvenue jeune créateur/créatrice au concours créatif pour vous challenger et surtout pour découvrir de nouveaux talents !</p>
                <p>Pour cette nouvelle édition 2023, nous allons nous porter sur des thèmes beaucoup plus variés et de saison. Comment ça se passe ?<br>
                    - Tous les 1er de chaque mois, un thème sera donné dans le salon "règlement-concours" et via une annonce officielle.<br>
                    - Vous avez le choix de participer ou non selon le thème qui vous sera proposé à chaque début de mois. Il n’y a évidemment aucune obligation.<br>
                    - Des rappels ou des annonces seront faites à celles et ceux ayant le rôle annonce disponible dans le salon "Salons et rôles", ce qui confirmera que vous souhaitez recevoir des informations sur le concours photo.<br></p>
                <p class="h2">Comment participer :</p>
                <p>Pour pouvoir participer au concours, il faut impérativement que vous soyez niveau 3 dans le discord*.<br>
                    - Vous avez 3 semaines pour soumettre votre photo dans le salon "concours-photos".<br>
                    - 1 seule photo par personne sera acceptée. Veuillez, si possible, donner l’appareil utilisé et les réglages si vous les avez.<br>
                    - Aucun changement n’est possible, donc choisissez bien la photo que vous proposez pour le concours.<br>
                    - La photo doit avoir été prise durant les 3 derniers mois maximum si vous ne parvenez pas durant le mois en cours.<br><br>
                    Une fois le délai de participation expiré, un vote sera soumis sur le site avec l'onglet "vote" qui sera disponible 1 semaine.<br>
                    - Vous aurez le droit de voter pour une seule et unique photo, alors choisissez bien celle que vous trouvez la plus réussie selon le thème.<br>
                    - Le dernier jour de chaque mois, Letomiboy sera en live sur sa chaîne Twitch pour regarder la photo de chaque participant, mais aussi pour énoncer le/la grand(e) gagnant(e) d’après les votes.<br>
                    - Le/la grand(e) gagnant(e) aura le privilège s’il/elle le souhaite de bénéficier d’une pub "photographe du mois" sur ses réseaux sociaux, tels qu'Instagram, Twitter, etc.<br>
                    Le but étant de montrer vos créations à un maximum de personnes.
            </p>
            <p class="astérisque">*Le serveur est muni d'un système d'experience. Chaque message apporte des points d'experience comme un RPG. Et au niveau 3 vous gagnez le rôle pour participer aux concours photo.</p>
        </div>
        <div class="calendar-box">
            <div class="calendrier">
                <div class="navigation">
                    <button id="prevMonthBtn">&lt;</button>
                    <div class="month" id="month"></div>
                    <button id="nextMonthBtn">&gt;</button>
                </div>
                <div class="month" id="month"></div>
                <div class="days" id="days"></div>
                <div classe="currentDay" id="currentDay"></div>
            </div>
            <div class="separator"></div>
                <div class="date actuelle">
                    <div class="date">
                        <div id="dayOfWeek"></div>
                        <div id="dayOfMonth"></div>
                        <div id="monthName"></div>
                    </div>
                </div>
            <div class="separator"></div>
            <div class="phase" id="info"></div>
            <button id="formulaire"></button>
        </div>
    </div>
    <script src="../script/script-calendar.js"></script>

    </div>
    <div class="boxes-container">
        <div class="theme-box">
            <h2>Thème du mois :</h2>

            <?php
            include_once '../auth-discord/connexion_bdd.php';
                $sql = "SELECT * FROM theme ORDER BY idtheme DESC LIMIT 1";
                $imgtheme = $conn->query($sql);

                if ($imgtheme->num_rows > 0) {
                    $row = $imgtheme->fetch_assoc();
                    $nomFichier = $row["nomimg"];
                    $nomTheme = $row["theme"];
                    $idtheme = $row["idtheme"];
                    $cheminImage = "../img/img-theme/" . $nomFichier;
                    ?>
                    <img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>"><br>
                    <p><?php echo $nomTheme; ?></p>
                    
            <?php
            } else {
                echo "Petit soucis sur le thème, on règle ça rapidement.";
            }
            ?>
        </div>
    
        <div class="winners-box">
            <h3>Vainqueurs des anciens concours</h3>
            <?php
                $sql ="WITH ClassementCTE AS (
                        SELECT *, ROW_NUMBER() OVER (PARTITION BY idtheme ORDER BY note DESC) AS Classement 
                        FROM participants_photo
                    ) 
                    SELECT c.*, u.discord_username, u.discord_id, u.discord_avatar, t.theme 
                    FROM ClassementCTE c 
                    INNER JOIN users u ON u.idusers = c.idusers 
                    INNER JOIN theme t ON t.idtheme = c.idtheme 
                    WHERE Classement = 1";

                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    $nomFichier = $row["file"];
                    $discord_username = $row['discord_username'];
                    $theme = $row['theme'];
                    $cheminImage = "../img/Participants/" . $nomFichier;
                    $idtheme = $row['idtheme']; // Ajout de cette ligne pour récupérer la valeur de idtheme

                    // Afficher discord_username et idtheme
                    echo "<img src=\"https://cdn.discordapp.com/avatars/{$row['discord_id']}/{$row['discord_avatar']}.jpg\" style=\"width: 35px; height: auto; border-radius:50%;\">
                    $discord_username<br> $theme <br> ";?>
                    <img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>" style="width: 2 50px; height: auto;"><?php

                    // Bouton renvoyant vers archivetheme.php?idtheme
                    echo "<br><a href='archivetheme.php?idtheme=$idtheme'><button>Voir Thème</button></a>";

                    echo "<br><br>";
                }
            ?>

        </div>
    </div>
    <div class="additional-content">
        <div class="winner-networks">
            <h3>Réseaux du gagnant :</h3>
            <ul>
                <li><img src="../img/instagram.png" width="20" height="20"> Instagram</li>
                <li><img src="../img/facebook.webp" width="20" height="20"> Facebook</li>
                <li><img src="../img/twitter.png" width="20" height="20"> Twitter</li>
            </ul>            
        </div>
        <div class="winner-photos">
            <h3>Quelques photos du gagnant :</h3>
            <div class="photo-pair">
                <img src="../img/test1.jpeg" alt="Photo 1">
                <img src="../img/test2.jpeg" alt="Photo 2">
            </div>
            <div class="photo-pair">
                <img src="../img/test3.jpeg" alt="Photo 3">
                <img src="../img/test4.jpeg" alt="Photo 4">
            </div>
        </div>
    </div>
    
    <?php
        include('footer.php');
    ?>
</body>
</html>