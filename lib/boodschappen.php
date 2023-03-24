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
        $this->tk = new artikel($connection);
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
            $data_art = $this->art->ophalenArtikel($ingredient["artikel_id"]);
            $boodschappen[] = $ingredient + $data_art;
        }

        return $boodschappen;

    }


// toevoegen aan boodschappenlijst
    public function toevoegenBoodschappen($gerecht_id, $user_id) {

    }
    
}