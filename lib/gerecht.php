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

//ophalen user
    public function selecteerGerecht($gerecht_id) {
        $sql = "select * from gerecht where gerecht_id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $user_id = $row['user_id'];
            $user = $this->ophalenUser($user_id);
            $gerecht[] = $row + $user;
        }
        return($gerecht);
    }

//ophalen ingredient
    public function selecteerGerecht($gerecht_id) {
        $sql = "select * from gerecht where gerecht_id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $ingredient_id = $ingredient['ingredient_id'];
        $ingredient = $this->ophalenIngredient($ingredient_id);
        $gerecht[] = $ingreient + $row;
    }
    return($gerecht);
}


//berekenen calorien
//berekenen prijs
//ophalen waardering
//ophalen bereidingswijze stappen
//ophalen opmerkingen
//ophalen keuken
//ophalen type
//maak favoriet


}