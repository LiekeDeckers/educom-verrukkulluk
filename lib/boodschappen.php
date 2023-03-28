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

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $ingredienten = $this->ophalenIngredient($row["lijst_id"]);
            
            $boodschappen[] = [
                'lijst_id' => $row['lijst_id'],
                'user_id' => $row['user_id'],
                'ingredienten' => $ingredienten,
                'gebruikt' => $row['gebruikt'],
                'aantal_kopen' => $row['aantal_kopen'],
                //'prijs_totaal' => $this->berekenPrijsTotaal($ingredienten) 
            ];        
        }

        return $boodschappen;

    }


// toevoegen aan boodschappenlijst

    public function toevoegenBoodschappen($gerecht_id, $user_id) {

        $data_ing = $this->ing->selecteerIngredient($gerecht_id);

        foreach($ingredienten as $ingredient) {
            $gebruikt = $ingredient["aantal"] / $ingredient["verpakking"];

            // al op lijst
            if(artikelOpLijst != false) {            
            $gebruikt += $boodschappenljst['gebruikt'];

            $sql = "UPDATE boodschappenljst SET aantal_kopen = " . ceil($gebruikt) . ", gebruikt = $gebruikt 
            WHERE user_id = $user_id AND artikel_id = " . $ingredient["artikel_id"]; 
            }

            // nog niet op lijst
            else {
            $sql = "INSERT INTO boodschappenljst(user_id, artikel_id, gebruikt, aantal_kopen) VALUES
            VALUES ('$user_id', '$artikel_id', '$gebruikt', 'ceil($gebruikt)')";
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
    public function verwijderBoodschappen($user_id) {
        $sql = "DELETE FROM boodschappenljst WHERE artikel_id = $artikel_id";
        $result = mysqli_query($this->connection,$sql);
        echo "Verwijderd uit boodschappenlijst";
    }


/* prijs totaal berekenen
    private function berekenPrijsTotaal($user_id) {
        $prijs_totaal == 0.0;

        foreach($ingredienten as $ingredient) {
            $prijs_totaal += $artikel['prijs'];
        }

        return round($prijs_totaal,2);
    }    
*/
} 