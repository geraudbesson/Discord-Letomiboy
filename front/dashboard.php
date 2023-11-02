<?php

    include_once 'header.php';
session_start();

if(!$_SESSION['logged_in']){
    header('Location: ../init-oauth.php');
    exit();
}

extract($_SESSION['userData']);

// $avatar_url = "https://cdn.discordapp.com/avatar/$discord_id/$avatar.jpg";

$avatar_url = "https://cdn.discordapp.com/avatars/$discord_id/$avatar.jpg";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif</title>
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
</head>
<body>
    <div class="calendar-box">
        <div>Welcome to the dashboard, </div>
                <img class="rounded-full w-12 h-12 mr-3" src="<?php echo $avatar_url?>" />
                <span class="text-3x1 text-white font-semibold"><?php echo $name?></span>
        <a href="logout.php" class="mt-5 text-grey-300">Logout</a>
        </div>
    </div>
    
    <?php
        include('footer.php');
    ?>
</body>
</html>