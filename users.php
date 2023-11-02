<?php

include('connexion_bdd_discord.php');
include('header.php');

$all_users = getAllUsersFromDatabase($pdo);
$usersMarkup='';

foreach ($all_users as $key => $userData) {
    $usersMarkup.='
        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600 flex  items-center">
            <img class="h-12 w-12 rounded-full mr-6" src="https://cdn.discordapp.com/avatars/'.$userData['discord_id'].'/'.$userData['discord_avatar'].'.jpg"/>
            '.$userData['discord_username'].'
        </li>';
}

?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../dist/output.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="flex items-center justify-center h-screen bg-discord-gray text-white flex-col">
        <ul class="w-96 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white mt-6">
            <h3 class="text-xl font-bold ml-3 text-gray-300 uppercase py-2">Users:</h3>
            <?php echo $usersMarkup;?>
        </ul>
    </div>
</body>
</html>