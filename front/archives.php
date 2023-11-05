<?php
    // Démarrez la session
    session_start();
    include '../auth-discord/connexion_bdd.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Onglets Bootstrap</title>
  <!-- Inclure les fichiers CSS et JS de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/site/front/styles.css">
    <link rel="stylesheet" type="text/css" href="/site/front/styles-admin.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
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

        <!-- Affichez l'avatar de l'utilisateur avec un lien vers dashboard.php -->
        <a href="dashboard.php">
            <img class="avatar-discord" src="<?php echo $avatar_url; ?>" alt="Avatar Discord" style="width: 50px; height: 50px; border-radius: 50%;">
        </a>

        <?php
        } else {
            // Si l'utilisateur n'est pas connecté, affichez le bouton de connexion
        ?>
            
        <!-- Affichez le bouton de connexion -->
        <button><a href="http://localhost/site/auth-discord/init-oauth.php">Se connecter à Discord</a></button>

        <?php
        }
        ?>

            
        </div>
</header>
    
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><b><u>Concours photo:</b></button> 
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Concours retouche</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Archives</button>
  </li>
</ul>
  <div class="container mt-5">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
          role="tab" aria-controls="home" aria-selected="true">Accueil</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Profil</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
          role="tab" aria-controls="contact" aria-selected="false">Contact</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h2>Contenu de l'onglet Accueil</h2>
        <p>Ceci est le contenu de l'onglet Accueil.</p>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <h2>Contenu de l'onglet Profil</h2>
        <p>Ceci est le contenu de l'onglet Profil.</p>
      </div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <h2>Contenu de l'onglet Contact</h2>
        <p>Ceci est le contenu de l'onglet Contact.</p>
      </div>
    </div>
  </div>

  <?php
$sql = "SELECT * FROM users;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $idusers = $row["idusers"];
        $discord_id = $row["discord_id"];
        $discord_username = $row["discord_username"];
        $discord_avatar = $row["discord_avatar"];
        $avatarUrl = "https://cdn.discordapp.com/avatars/$discord_id/$discord_avatar.jpg";

        // Affichage des données de chaque utilisateur
        echo "ID Utilisateur: $idusers<br>";
        echo "ID Discord: $discord_id<br>";
        echo "Nom d'utilisateur Discord: $discord_username<br>";
        echo "Avatar Discord: <img src='$avatarUrl' alt='Avatar de $discord_username'><br><br>";
    }
} else {
    echo "Aucun utilisateur trouvé dans la base de données.";
}
?>

  <!-- Affichage de l'avatar avec la balise img -->
  <img src="<?php echo $avatar; ?>" alt="Avatar de <?php echo $discord_username; ?>">

  <!-- Affichage de l'ID Discord et du nom d'utilisateur -->
  <?php echo $discord_id; ?><br>
  <?php echo $discord_username; ?>

  <script type="text/javascript">
                            // Fonction qui sera exécutée lors du clic sur le bouton
                            document.getElementById("confirmButton").addEventListener("click", function() {
                                // Affiche une boîte d'alerte JavaScript
                                var confirmation = confirm("Êtes-vous sûr de vouloir effectuer cette opération?");

                                // Si l'utilisateur clique sur OK dans l'alerte
                                if (confirmation) {
                                // Soumettez le formulaire
                                document.forms["updateForm"].submit();
                                } else {
                                // Si l'utilisateur clique sur Annuler, annulez l'action
                                return false;
                                }
                            });
                            </script>
                        </div>
                        <button id="generatePageButton">Générer Nouvelle Page</button>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            // Attacher un gestionnaire d'événements au bouton
                            document.getElementById("generatePageButton").addEventListener("click", function() {
                                // Effectuer une requête AJAX pour déclencher le script PHP
                                $.ajax({
                                    url: "create_page.php", // Chemin vers votre script PHP
                                    type: "POST", // Méthode de requête
                                    success: function(response) {
                                        // Gérer la réponse du script PHP ici (si nécessaire)
                                        console.log("Nouvelle page générée avec succès!");
                                        // Vous pouvez rediriger l'utilisateur vers la nouvelle page ici si nécessaire
                                        window.location.href = response;
                                    },
                                    error: function(xhr, status, error) {
                                        // Gérer les erreurs de la requête AJAX ici
                                        console.error("Erreur lors de la génération de la page: " + error);
                                    }
                                });
                            });
                        </script>
</body>

</html>
