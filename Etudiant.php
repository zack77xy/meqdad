<?php
class Etudiant {
    private $nom;
    private $math;
    private $info;

    public function __construct($nom, $math, $info) {
        $this->nom = $nom;
        $this->math = $math;
        $this->info = $info;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getMath() {
        return $this->math;
    }

    public function getInfo() {
        return $this->info;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setMath($math) {
        $this->math = $math;
    }

    public function setInfo($info) {
        $this->info = $info;
    }

    public function calculerMoyenne() {
        return ($this->math + $this->info) / 2;
    }

    public function getObservation() {
        $moyenne = $this->calculerMoyenne();
        return ($moyenne >= 10) ? "Votre admission a été retenue." : "Votre admission n'a pas été retenue.";
    }

    // Sérialisation de l'étudiant pour le sauvegarder
    public function toCSV() {
        return $this->nom . ";" . $this->math . ";" . $this->info;
    }

    // Crée un objet Etudiant à partir d'une ligne CSV
    public static function fromCSV($csv) {
        $data = explode(";", $csv);
        return new Etudiant($data[0], $data[1], $data[2]);
    }
}
?>
