<?php
    // Démarrez la session
    session_start();
    include '../auth-discord/connexion_bdd.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Onglets Bootstrap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/site/front/styles.css">
</head>
<body>

<header class="fixed-top">
  <div id="logo">
    <a href="http://localhost/site/front/index.php"><img src="http://localhost/site/img/Logo-Blanc.png" alt="Logo de votre site"></a>
  </div>
  <nav>
    <ul>
      <li><a href="http://localhost/site/front/index.php">Accueil</a></li>
      <li><a href="http://localhost/site/front/formulaires.php">Formulaires concours</a></li>
      <li><a href="http://localhost/site/front/archives.php">Archives</a></li>
      <?php
      // Vérifiez si l'utilisateur est connecté et a le rôle d'admin
      if (isset($_SESSION['userData']) && $_SESSION['userData']['role'] == 'admin') {
        // Si l'utilisateur est connecté et a le rôle d'admin, affichez le bouton "Admin"
        echo '<li><a href="http://localhost/site/front/admin.php">Admin</a></li>';
      }
      ?>
    </ul>
  </nav>
  <div id="connexion">
    <?php
    // Vérifiez si l'utilisateur est connecté
    if (isset($_SESSION['userData'])) {
      // Si l'utilisateur est connecté, récupérez les données de la session
      extract($_SESSION['userData']);
      $avatar_url = "https://cdn.discordapp.com/avatars/$discord_id/$avatar.jpg";
    ?>
    <a href="dashboard.php">
      <img class="avatar-discord" src="<?php echo $avatar_url; ?>" alt="Avatar Discord" style="width: 50px; height: 50px; border-radius: 50%;">
    </a>
    <?php
    } else {
      ?>      
      <button><a href="http://localhost/site/auth-discord/init-oauth.php">Se connecter à Discord</a></button>
      <?php
      }
      ?>
  </div>
</header>
<div class="header-fix"></div>
<div class="container">
    <div class="row">
        <?php
        // Récupérer l'idtheme depuis l'URL
        if (isset($_GET['idtheme'])) {
            $idtheme = $_GET['idtheme'];
            $sql = "SELECT nomimg, theme FROM theme WHERE idtheme = $idtheme";
            $imgtheme = $conn->query($sql);

            if ($imgtheme->num_rows > 0) {
                $row = $imgtheme->fetch_assoc();
                $nomFichier = $row["nomimg"];
                $nomTheme = $row["theme"];
                $cheminImage = "../img/img-theme/" . $nomFichier;
                ?>
                <img src="<?php echo $cheminImage; ?>" alt="<?php echo $nomFichier; ?>">
                
            <?php
            } else {
                echo "Petit soucis sur le thème, on règle ça rapidement.";
            }

            // Requête SQL pour sélectionner les données de la table participer en fonction de l'idtheme
            $requete = "SELECT u.discord_username, u.discord_avatar, p.file FROM participants_photo p INNER JOIN users u ON u.idusers = p.idusers WHERE idtheme = $idtheme";
            $resultat = $conn->query($requete);

            // Afficher les données de la table participer
            if ($resultat->num_rows > 0) {
                while ($row = $resultat->fetch_assoc()) {
                    // Affichez les champs de la table participer selon vos besoins
                    $discord_username = $row['discord_username'];
                    $image = $row['file'];
                    $cheminImage = "../img/Participants/" . $image;
                    // ... Affichez d'autres champs selon votre structure de table
                    echo "
                    <div class='col-md-4 mb-3'>
                        <div class='card'>
                        <img src='$cheminImage' class='card-img-top'>
                        <div class='card-body'>
                            <h5 class='card-title'>$discord_username</h5>
                        </div>
                    </div>
                </div>
                ";
                }
                echo "</ul>";
            } else {
                echo "Aucune donnée trouvée pour l'idtheme $idtheme.";
            }

            // Fermer la conn à la base de données
            $conn->close();
        } else {
            echo "ID du thème non spécifié dans l'URL.";
        }
        ?>
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