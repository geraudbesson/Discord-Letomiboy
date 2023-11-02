<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if(!isset($_GET['code'])){
        echo 'no code';
        exit();
    }

    $discord_code = $_GET['code'];


    $payload = [
        'code'=>$discord_code,
        'client_id'=>'1169333837633957888',
        'client_secret'=>'ToE77MI4kLPPzBVOukyUcsnCAEUkQeqD',
        'grant_type'=>'authorization_code',
        'redirect_uri'=>'http://localhost/Site/auth-discord/process-oauth.php', // or your redirect link
        'scope'=>'identify%20guids',
    ];

    print_r($payload);

    $payload_string = http_build_query($payload);
    $discord_token_url = "https://discordapp.com/api/oauth2/token";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $discord_token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $result = curl_exec($ch);

    if(!$result){
        echo curl_error($ch);
    }

    $result = json_decode($result,true);
    $access_token = $result['access_token'];

    $discord_users_url = "https://discordapp.com/api/users/@me";
    $header = array("Authorization: Bearer $access_token", "Content-Type: application/x-www-form-urlencoded");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_URL, $discord_users_url);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $result = curl_exec($ch);

    $result = json_decode($result, true);

    $guildObject = getGuildObject($access_token, '404790598831177730');
    $guild_roles = $guildObject['roles'];
    // see if roles has the correct role_id within the array

    $role = 'user';
    if(in_array('406012972675366912', $guild_roles)){
        $role = 'admin';
    }else if(in_array('837424035687956490', $guild_roles)){
        $role = 'concours';
    }

    session_start();

    $_SESSION['logged_in'] = true;
    $_SESSION['userData'] = [
        'name'=>$result['username'],
        'discord_id'=>$result['id'],
        'avatar'=>$result['avatar'],
        'role'=>$role,
    ];

    //IF YOU ARE HAVING ISSUES, ADD AN EXIT() HERE, this will stop the script early, and show any errors!
    //exit();

    if($role=='admin'){
        header("location: http://localhost/site/front/admin.php");
    }else if($role == 'admin' || $role == 'concours'){
        header("location: http://localhost/site/front/participer.php");
    }else{
        header("location: http://localhost/site/front/dashboard.php");
    }

    exit();

    function getGuildObject($access_token, $guild_id){
        //requires the following scope: guilds.members.read
        $discord_api_url = "https://discordapp.com/api";
        $header = array("Authorization: Bearer $access_token","Content-Type: application/x-www-form-urlencoded");
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_URL, $discord_api_url.'/users/@me/guilds/'.$guild_id.'/member');
        curl_setopt($ch,CURLOPT_POST, false);
        //curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        $result = json_decode($result,true);
        return $result;
    }