<?php
    // Démarrez la session
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif</title>
    <link rel="icon" type="image/png" href="http://localhost/img/Logo-Noir.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" type="text/css" href="/site/front/styles.css">
    <link rel="stylesheet" type="text/css" href="/site/front/styles-admin.css">
    <link rel="stylesheet" type="text/css" href="/site/front/styles-participer.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</head>
<body>   
    <header>
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
    
</body>
</html>