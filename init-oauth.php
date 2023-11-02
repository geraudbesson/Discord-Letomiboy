<?php

$discord_url = "https://discord.com/api/oauth2/authorize?client_id=1169333837633957888&redirect_uri=http%3A%2F%2Flocalhost%2FSite%2Fprocess-oauth.php&response_type=code&scope=identify%20guilds";
header("Location: $discord_url");
exit();

?>