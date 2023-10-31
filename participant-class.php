<?php

class Participant {
    private $idparticipant;
    private $nomparticipant;
    private $file;
    private $exifs;
    private $funfact;

    public function __construct($idparticipant, $nomparticipant, $file, $exifs, $funfact) {
        $this->idparticipant = $idparticipant;
        $this->nomparticipant = $nomparticipant;
        $this->file = $file;
        $this->exifs = $exifs;
        $this->funfact = $funfact;
    }

    // Getters and setters
    public function getIdparticipant() {
        return $this->idparticipant;
    }

    public function getNomparticipant() {
        return $this->nomparticipant;
    }

    public function getFile() {
        return $this->file;
    }

    public function getExifs() {
        return $this->exifs;
    }

    public function getFunfact() {
        return $this->funfact;
    }

    public function setIdparticipant($idparticipant) {
        $this->idparticipant = $idparticipant;
    }

    public function setNomparticipant($nomparticipant) {
        $this->nomparticipant = $nomparticipant;
    }

    public function setFile($file) {
        $this->file = $file;
    }

    public function setExifs($exifs) {
        $this->exifs = $exifs;
    }

    public function setFunfact($funfact) {
        $this->funfact = $funfact;
    }
}

?>
