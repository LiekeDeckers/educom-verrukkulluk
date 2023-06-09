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

    private function ophalenTypeKeuken($type_keuken_id) {
        $data_tk = $this->tk->selecteerTypeKeuken($type_keuken_id);
        return($data_tk);
    }

    private function ophalenIngredient($gerecht_id) {
        $data_ing = $this->ing->selecteerIngredient($gerecht_id);
        return($data_ing);
    }

    private function ophalenGerechtInfo($gerecht_id) {
        $data_gerinfo = $this->gerinfo->selecteerGerechtInfo($gerecht_id);
        return($data_gerinfo);
    }

    private function ophalenWaardering($gerecht_id) {
        return $this->gerinfo->selecteerGerechtInfo($gerecht_id, 'W');
    }

    private function ophalenFavoriet($gerecht_id) {
        return $this->gerinfo->selecteerGerechtInfo($gerecht_id, 'F');
    }

    private function ophalenOpmerking($gerecht_id) {
        return $this->gerinfo->selecteerGerechtInfo($gerecht_id, 'O');
    }

    private function ophalenBereiding($gerecht_id) {
        return $this->gerinfo->selecteerGerechtInfo($gerecht_id, 'B');
    }


// 1 of meerdere gerechten Selecteren
    public function SelecteerGerecht($gerecht_id = null) {
    $sql = "select * from gerecht";
    if(!is_null($gerecht_id)) {
        $sql .= " where gerecht_id = $gerecht_id";
    }

    $result = mysqli_query($this->connection,$sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $ingredienten = $this->ophalenIngredient($row["gerecht_id"]);
        $waarderingen = $this->ophalenWaardering($row["gerecht_id"]);

        $gerechten[] = [
        "id" => $row["gerecht_id"],
        "keuken" => $this->ophalenTypeKeuken($row["keuken_id"]),
        "type" => $this->ophalenTypeKeuken($row["type_id"]),
        "user" => $this->ophalenUser($row["user_id"]),
        "datum_toegevoegd" => $row["datum_toegevoegd"],
        "titel" => $row["titel"],
        "korte_omschrijving" => $row["korte_omschrijving"],
        "lange_omschrijving" => $row["lange_omschrijving"],
        "afbeelding" => $row["afbeelding"], 
        "ingredienten" => $ingredienten,
        "favoriet" => $this->ophalenFavoriet($row["gerecht_id"]),
        "waardering" => $waarderingen,
        "bereidingswijze" => $this->ophalenBereiding($row["gerecht_id"]),
        "opmerkingen" => $this->ophalenOpmerking($row["gerecht_id"]),
        "prijs_gerecht" => $this->berekenPrijs($ingredienten),
        "calorieen" => $this->berekenCalorieen($ingredienten),
        "gemiddelde_waardering" => $this->berekenGemiddeldeWaardering($waarderingen)
        ];
    }
        return($gerechten);
    }



//berekenen calorieen
    private function berekenCalorieen($ingredienten) {
        $calorieen_gerecht = 0.0;

        foreach($ingredienten as $ingredient) {
            $calorieen_gerecht += ($ingredient["aantal"] / $ingredient["verpakking"]) * $ingredient["calorieen"];
        }
        return round($calorieen_gerecht);
    }


//berekenen prijs
    private function berekenPrijs($ingredienten) {
        $prijs_gerecht = 0.0;

        foreach($ingredienten as $ingredient) {
            $prijs_gerecht += ($ingredient["aantal"] / $ingredient["verpakking"]) * $ingredient["prijs"];
        }
        return ($prijs_gerecht); 
    }


//bereken gemiddelde waardering
public function berekenGemiddeldeWaardering($waarderingen) {
        $somWaardering = 0;
        $aantalWaarderingen = count($waarderingen);
        if($aantalWaarderingen == 0) return 0;

        foreach($waarderingen as $waardering) {
            $somWaardering += $waardering["nummeriekveld"];
        }
        $gemiddeldeWaardering = $somWaardering / $aantalWaarderingen;

        return round($gemiddeldeWaardering,1);
    } 


//bepalen favoriet 
    public function bepaalFavoriet($gerecht_id, $user_id) {
        $favoriet_data = $this->ophalenFavoriet($gerecht_id);

        foreach($favoriet_data as $favoriet) {
            if($favoriet["user_id"] == $user_id) {
                $isFavoriet = true;
            }
            else {
                $isFavoriet = false;
            }
        }
        return $isFavoriet;

    }
}