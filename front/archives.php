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
        $resultat = $conn->query("SELECT * FROM theme");
        // Boucle pour générer les cards
        while ($row = $resultat->fetch_assoc()) {
            $idtheme = $row["idtheme"];
            $nomTheme = $row["theme"];
            $imageURL = $row["nomimg"];
            $image = "../img/img-theme/" . $imageURL;

            // Générer la card Bootstrap avec l'image et le bouton
            echo "
            <div class='col-md-4 mb-3'>
                <div class='card'>
                    <img href='archivetheme.php?idtheme=$idtheme' src='$image' class='card-img-top' alt='$nomTheme'>
                    <div class='card-body'>
                        <h5 class='card-title'>$nomTheme</h5>
                        <a href='archivetheme.php?idtheme=$idtheme' class='btn btn-primary'>Découvrir les clichés </a>
                    </div>
                </div>
            </div>
            ";
        }

        // Fermer la connexion à la base de données
        $conn->close();
        ?>

    </div>
</div>
</body>
</html>
