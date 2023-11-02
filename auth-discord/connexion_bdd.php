<?php

$host = "localhost";
$user = "root";
$pass = "";
$db='concoursdiscord';

// Établir la connexion
$conn = mysqli_connect($host, $user, $pass, $db);

  
// Vérifier la connexion
if ($conn->connect_error) {
    die("Une erreur s'est produite, merci de réessayer : " . $conn->connect_error);
}

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
}
catch(PDOException $e){
  echo "Connection failed: " . $e->getMessage();
}

function addUserToDatabase($pdo,$discord_id,$discord_avatar,$discord_username){
    $sql = "INSERT INTO users (discord_id,discord_avatar,discord_username) VALUES (:discord_id,:discord_avatar,:discord_username)";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'discord_id'=>$discord_id,
            'discord_avatar'=>$discord_avatar,
            'discord_username'=>$discord_username,
        ]);
        echo 'inserted successfully';
    } catch (Exception $e) {
        echo $e;
    }
}

function getUserFromDatabase($pdo,$discord_id){
    $sql = "SELECT * FROM users WHERE discord_id=:discord_id";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'discord_id'=>$discord_id,
        ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch (Exception $e) {
        echo $e;
    }
}

function getAllUsersFromDatabase($pdo){
    $sql = "SELECT * FROM users";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (Exception $e) {
        echo $e;
    }
}
