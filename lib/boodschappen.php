<?php

require_once("lib/user.php");
require_once("lib/ingredient.php");

class boodschappen {
    private $connection;
    private $usr;
    private $tk;
    private $ing;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->usr = new user($connection);
        $this->art = new artikel($connection);
        $this->ing = new ingredient($connection);
    }

    private function ophalenUser($user_id) {
        $data_usr = $this->usr->selecteerUser($user_id);
        return($data_usr);
    }

    private function ophalenArtikel($gerecht_id) {
        $data_art = $this->art->selecteerArtikel($gerecht_id);
        return($data_art);
    }

    private function ophalenIngredient($gerecht_id) {
        $data_ing = $this->ing->selecteerIngredient($gerecht_id);
        return($data_ing);
    }

    

// selecteer boodschappenlijst
    public function selecteerBoodschappen($user_id) {
        $boodschappen = [];

        $sql = "select * from boodschappenljst where user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $artikel_id = $row['artikel_id'];
            $artikel = $this->ophalenArtikel($artikel_id);

            $ingredient_id = $row['ingredient_id'];
            $ingredient = $this->ophalenIngredient($ingredient_id);

            $boodschappen[] = [
                'lijst_id' => $row['lijst_id'],
                'user_id' => $row['user_id'],
                'ingredient_id' => $row['ingredient_id'],
                'naam' => $artikel['naam'],
                'omschrijving' => $artikel['omschrijving'],
                'prijs' => $artikel['prijs'],
                'eenheid' => $artikel['eenheid'],
                'verpakking' => $artikel['verpakking'],
                'calorieen' => $artikel['calorieen'],
                'artikel_afbeelding' => $artikel['artikel_afbeelding'],
                'aantal_kopen' => $this->berekenAantal($ingredient),
            ];        
        }

        return $boodschappen;

    }


// toevoegen aan boodschappenlijst

    public function toevoegenBoodschappen($gerecht_id, $user_id) {

        $ingredient = $this->selecteerIngredient($gerecht_id);
        
        foreach($ingredienten as $ingredient) {
            $opgehaald = $this->artikelOpLijst($artikel_id, $user_id);
            if(!$opgehaald) {
                $this->toevoegenArtikel($artikel, $user_id);
            }
        
            else {
                $this->artikelBijwerken($opgehaald, $artikel);
            }
        }
    }


    public function artikelOpLijst($artikel_id, $user_id) {
        $boo = $this->selecteerBoodschappen($user_id);

        foreach($boo as $artikel){
            if($artikel["artikel_id"] == $artikel_id) {
                return $artikel;
            }       
        }

        return false;
    }



// verwijderen uit boodschappenlijst
    public function verwijderBoodschappen($artikel_id, $user_id) {
        $sql = "DELETE FROM boodschappenljst WHERE artikel_id = $artikel_id and user_id = $user_id";
        $result = mysqli_query($this->connection,$sql);
        echo "Verwijderd uit boodschappenlijst";
    }

// aantal berekenen
    private function berekenAantal($ingredient) {
        $aantal_kopen = 0;

        foreach($ingredient as $ingredient) {
        $aantal_kopen += ($ingredient["aantal"] / $ingredient["verpakking"]);
        }

        return ceil($aantal_kopen);
    }

} 