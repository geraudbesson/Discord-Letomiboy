<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif</title>
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
    <style>
        .error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-box {
            text-align: center;
        }
        .error-title {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .error-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php
        include('../header.php');
    ?>
    <div class="error-container">
        <div class="error-box">
            <div class="error-title">
                Page indisponible car vous n'êtes pas encore connecté
            </div>
            <a class="btn btn-primary" href="http://localhost/site/auth-discord/init-oauth.php" role="button">Se connecter</a>
        </div>
    </div>
    <?php
        include('../footer.php');
    ?>
</body>
</html>