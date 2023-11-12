<?php

class Database
{

    private $host = "localhost";
    private $user = "root";
    private $pass = "";


    private function getconnexion()
    {
        try{
            return new PDO("mysql:host={$this->host};dbname=concoursdiscord", $this->user, $this->pass);
        } catch(PDOException $e) {
            die ("Erreur" . $e->getMessage());
        }
    }

    public function readCP()
    {
        return $this->getconnexion()->query("SELECT * FROM participants_photo p INNER JOIN users u ON u.idusers = p.idusers INNER JOIN theme t ON t.idtheme = p.idtheme WHERE p.participer = 1 AND t.idtheme = (SELECT idtheme FROM theme t ORDER BY t.idtheme DESC LIMIT 1)")->fetchAll(PDO::FETCH_OBJ);

    }

    public function countBillsCP(): int
    {
        return (int)$this->getconnexion()->query("SELECT COUNT(idparticipant) as count FROM participants_photo WHERE participer = 1")->fetch()[0];

    }

    public function readRCP()
    {
        return $this->getconnexion()->query("SELECT p.idparticipant, u.discord_id, u.discord_avatar, u.discord_username, p.file, AVG(v.note) as moyenne FROM votants v LEFT JOIN participants_photo p ON P.idparticipant = v.idparticipant INNER JOIN users u ON u.idusers = v.idusers WHERE p.participer = 1 GROUP BY u.discord_username;)")->fetchAll(PDO::FETCH_OBJ);
        // Bouton archiver classement
        // UPDATE participants_photo SET note = (SELECT AVG(note) FROM votants WHERE idparticipant = 1)
    }

    public function countBillsRCP(): int
    {
        return (int)$this->getconnexion()->query("SELECT COUNT(v.idvotant) as count FROM votants v INNER JOIN participants_photo p ON p.idparticipant = v.idparticipant WHERE participer = 1")->fetch()[0];

    }
}