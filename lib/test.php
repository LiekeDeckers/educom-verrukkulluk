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

    private function ophalenFavoriet($gerecht_id) {
        return $this->ger_info->selecteerGerechtInfo($gerecht_info_id, 'F');
    }

    private function ophalenOpmerking($gerecht_id) {
        return $this->ger_info->selecteerGerechtInfo($gerecht_info_id, 'O');
    }

    private function ophalenBereiding($gerecht_id) {
        return $this->ger_info->selecteerGerechtInfo($gerecht_info_id, 'B');
    }

// ophalen gerecht met alles    
    public function selecteerGerecht($gerecht_id) {
        $gerecht_compleet[] = [
        "gerecht" => "",
        "keuken" => [],
        "type" => [],
        "user" => [],
        "datum_toegevoegd" => "",
        "titel" => "",
        "korte_omschrijving" => "",
        "lange_omschrijving" => "",
        "afbeelding" => "",
        "ingredienten" => [],
        "favoriet" => [],
        "waardering" => [],
        "bereidingswijze" => [],
        "opmerkingen" => [],
        "prijs_gerecht" => "",
        "calorieen" => "",
    ];
        

        $sql = "select * from gerecht where gerecht_id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);
        $gerecht = mysqli_fetch_array($result, MYSQLI_ASSOC);

        
        $gerecht_compleet = [
            "gerecht" => $gerecht["gerecht_id"],
            "keuken" => $this->ophalenTypeKeuken($gerecht["keuken_id"]),
            "type" => $this->ophalenTypeKeuken($gerecht["type_id"]),
            "user" => $this->ophalenUser($gerecht["user_id"]),
            "datum_toegevoegd" => $gerecht["datum_toegevoegd"],
            "titel" => $gerecht["titel"],
            "korte_omschrijving" => $gerecht["korte_omschrijving"],
            "lange_omschrijving" => $gerecht["lange_omschrijving"],
            "afbeelding" => $gerecht["afbeelding"],
            "ingredienten" => $this->ophalenIngredient($gerecht["ingredient_id"]),
            "favoriet" => $this->ophalenFavoriet($gerecht["id"]),
            "waardering" => $this->ophalenWaardering($gerecht["id"]),
            "bereidingswijze" => $this->ophalenBereiding($gerecht["id"]),
            "opmerkingen" => $this->ophalenOpmerking($gerecht["id"]),
            "prijs_gerecht" => $this->berekenPrijs($gerecht["ingredient"]),
            "calorieen" => $this->berekenCalorieen($gerecht["ingredient"]),
        ];

        return $gerecht_compleet;
    }
}