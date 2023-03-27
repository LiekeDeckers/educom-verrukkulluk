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

        $sql = "select * from boodschappenljst where user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);

        while($ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $artikel = $this->ophalenArtikel($ingredient_id);
            $boodschappen[] = $ingredient + $artikel;
        }

        return $boodschappen;

    }


 // artikel op boodschappenlijst?   
    public function artikelOpLijst($artikel_id, $user_id){
        $boo = $this->ophalenBoodschappen($user_id);

        foreach($boo as $artikel) {
            if($artikel["artikel_id"] == $artikel) {
                return $artikel;
            }
        }

        return false;
    }

// toevoegen aan boodschappenlijst

    public function toevoegenBoodschappen($gerecht_id, $user_id) {

        $data_ing = $this->ing->selecteerIngredient($gerecht_id);
        if (count($data_ing) == 0) {
            return;
        }

        foreach($ingredienten as $ingredient) {
            $gebruikt = $ingredient["aantal"] / $ingredient["verpakking"];

            $sql = "INSERT INTO boodschappenljst(user_id, artikel_id, gebruikt)
            VALUES ('$user_id', '$artikel_id', '$gebruikt)";

            $artikelOpLijst = $this->artikelOpLijst($artikel_id, $user_id);
            if($artikelOpLijst == false) {
                // update lijst
            }

        }
    } 
}