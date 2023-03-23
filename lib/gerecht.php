<?php

require_once("lib/user.php");
require_once("lib/type_keuken.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");

class gerecht {

    private $connection;
    private $usr;
    private $tk;
    private $ing;
    private $gerinfo;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->usr = new user($connection);
        $this->tk = new type_keuken($connection);
        $this->ing = new ingredient($connection);
        $this->gerinfo = new gerecht_info($connection);
    }

    private function ophalenUser($user_id) {
        $data_usr = $this->usr->selecteerUser($user_id);
        return($data_usr);
    }

    private function ophalenTypeKeuken($user_id) {
        $data_tk = $this->tk->selecteerTypeKeuken($type_keuken_id);
        return($data_tk);
    }

    private function ophalenIngredient($ingredient_id) {
        $data_ing = $this->ing->selecteerIngredient($ingredient_id);
        return($data_ing);
    }

    private function ophalenGerechtInfo($gerecht_info_id) {
        $data_gerinfo = $this->gerinfo->selecteerGerechtInfo($gerecht_info_id);
        return($data_gerinfo);
    }

    private function ophalenWaardering($gerecht_id) {
        return $this->ger_info->selecteerGerechtInfo($gerecht_info_id, 'W');
    }

//ophalen user
    public function selecteerGerecht($gerecht_id) {
        $sql = "select * from gerecht where gerecht_id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $user_id = $row['user_id'];
            $user = $this->ophalenUser($user_id);
            
//ophalen ingredient
            $gerecht_id = $row['gerecht_id'];
            $gerecht = $this->ophalenIngredient($gerecht_id);

            $gerecht[] = $row + $user;
        }
        return($gerecht);
    }


//berekenen calorieen
    private function berekenCalorieen($gerecht_id) {
        $calorieen_gerecht = [];

        $sql = "select * from ingredient where gerecht_id = $gerecht_id)";
        $result = mysqli_query($this->connection, $sql);
        $ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC);


        foreach($ingredients as $ingredient) {
            $calorieen_gerecht = [(($ingredient["aantal"] / $ingredient["verpaking"]) * $ingredient["calorieen"])];
        }
        return array_sum($calorieen_gerecht);
    }


//berekenen prijs
    public function berekenPrijs($gerecht_id) {
        $prijs_gerecht = [];

        $sql = "select * from gerecht where gerecht_id = $gerecht_id)";
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $prijs_gerecht= (($ingredient["aantal"] / $ingredient["verpaking"]) * $ingredient["prijs"]);
        }
        return array_sum($prijs_gerecht);
    }

//ophalen waardering --> werkt niet
    public function selecteerGerechtInfo($gerecht_id, $record_type) {
        $sql = "select * from gerecht_info where gerecht_id = $gerecht_id and record_type = '$record_type'";
        echo $sql;
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if ($record_type == 'W') { 
            $gerecht_id = $row['gerecht_id'];
            $gerecht = $this->ophalenGerechtInfo($gerecht_id);
            $waardering[] = [$row + $gerecht];
        }
        return($waardering);
    }
    }
}

//ophalen bereidingswijze stappen
//ophalen opmerkingen
//ophalen keuken
//ophalen type
//maak favoriet 