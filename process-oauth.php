<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include('connexion_bdd_discord.php');

    if(!isset($_GET['code'])){
        echo 'error: no code passed';
        exit();
    }else{

        $discord_code = $_GET['code'];
        $client_id = '1169333837633957888';
        $client_secret = 'KXmWzg6zFh443quzt85FVySHuAgcvheH';


    $payload = [
        'client_id'=>$client_id,
        'client_secret'=>$client_secret,
        'grant_type'=>'authorization_code',
        'code'=>$discord_code,
        'redirect_uri'=>'http://localhost/Site/process-oauth.php',
        'scope'=>'identify%20guids',
    ];

    // print_r($payload);

    $fields_string = http_build_query($payload);
    $discord_token_url = "https://discordapp.com/api/oauth2/token";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $discord_token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $result = curl_exec($ch);

    if(!$result){
        echo 'curl failed';
        $response = curl_error($ch);
        echo $response;
    }

    $result = json_decode($result,true);

    $access_token = $result['access_token'];
    echo $access_token;

    $discord_api_url = "https://discordapp.com/api";
    $header = array("Authorization: Bearer $access_token", "Content-Type: application/x-www-form-urlencoded");
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_URL, $discord_api_url.'/users/@me');
    curl_setopt($ch, CURLOPT_POST, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


    $result = curl_exec($ch);
    if(!$result){
        echo curl_error($ch);
    }else{
        $userData = json_decode($result,true);

        $user_data_from_db = getUserFromDatabase($pdo,$userData['id']);

        if(!$user_data_from_db){
            addUserToDatabase($pdo,$userData['id'],$userData['avatar'],$userData['username']);
        }


        $_SESSION['logged_in'] = true;
        $_SESSION['userData'] = [
            'discord_id'=>$userData['id'],
            'name'=>$userData['username'],
            'avatar'=>$userData['avatar'],
        ];
        header("location: dashboard.php");
        exit();
        }
    }


