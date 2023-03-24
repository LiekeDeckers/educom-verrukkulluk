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


// alles van 1 gerecht in een array
    public function selecteerGerecht($gerecht_id) {
        $gerecht_data = [
            "id" => "",
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
            "gemiddelde_waardering" => ""
        ];


        $sql = "select * from gerecht where gerecht_id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);

        $kaalGerechtData = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $gerecht_data["id"] = $kaalGerechtData["gerecht_id"];
        $gerecht_data["keuken"] = $this->ophalenTypeKeuken($kaalGerechtData["keuken_id"]);
        $gerecht_data["type"] = $this->ophalenTypeKeuken($kaalGerechtData["type_id"]);
        $gerecht_data["user"] = $this->ophalenUser($kaalGerechtData["user_id"]);
        $gerecht_data["datum_toegevoegd"] = $kaalGerechtData["datum_toegevoegd"];
        $gerecht_data["titel"] = $kaalGerechtData["titel"];
        $gerecht_data["korte_omschrijving"] = $kaalGerechtData["korte_omschrijving"];
        $gerecht_data["lange_omschrijving"] = $kaalGerechtData["lange_omschrijving"];
        $gerecht_data["ingredienten"] = $this->ophalenIngredient($kaalGerechtData["gerecht_id"]);
        $gerecht_data["favoriet"] = $this->ophalenFavoriet($kaalGerechtData["gerecht_id"]);
        $gerecht_data["waardering"] = $this->ophalenWaardering($kaalGerechtData["gerecht_id"]);
        $gerecht_data["bereidingswijze"] = $this->ophalenBereiding($kaalGerechtData["gerecht_id"]);
        $gerecht_data["opmerkingen"] = $this->ophalenOpmerking($kaalGerechtData["gerecht_id"]);
        $gerecht_data["prijs_gerecht"] = $this->berekenPrijs($gerecht_data["ingredienten"]);
        $gerecht_data["calorieen"] = $this->berekenCalorieen($gerecht_data["ingredienten"]);
        $gerecht_data["gemiddelde_waardering"] = $this->berekenGemiddeldeWaardering($gerecht_data["waardering"]);

        return $gerecht_data;
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
    private function berekenGemiddeldeWaardering($waarderingen) {
        $somWaardering = 0;
        $aantalWaarderingen = count($waarderingen);

        foreach($waarderingen as $waardering) {
            $somWaardering += $waardering["nummeriekveld"];
        }
        $gemiddeldeWaardering = $somWaardering / $aantalWaarderingen;

        return $gemiddeldeWaardering;
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


// 1 of meerdere gerechten selecteren
    public function selecteerGerechten($gerecht_ids = []) {
        $gerechten = [];

        foreach($gerecht_ids as $gerecht_id) {
        $sql = "select * from gerecht where gerecht_id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);

        $kaalGerechtData = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $gerecht_data["id"] = $kaalGerechtData["gerecht_id"];
        $gerecht_data["keuken"] = $this->ophalenTypeKeuken($kaalGerechtData["keuken_id"]);
        $gerecht_data["type"] = $this->ophalenTypeKeuken($kaalGerechtData["type_id"]);
        $gerecht_data["user"] = $this->ophalenUser($kaalGerechtData["user_id"]);
        $gerecht_data["datum_toegevoegd"] = $kaalGerechtData["datum_toegevoegd"];
        $gerecht_data["titel"] = $kaalGerechtData["titel"];
        $gerecht_data["korte_omschrijving"] = $kaalGerechtData["korte_omschrijving"];
        $gerecht_data["lange_omschrijving"] = $kaalGerechtData["lange_omschrijving"];
        $gerecht_data["ingredienten"] = $this->ophalenIngredient($kaalGerechtData["gerecht_id"]);
        $gerecht_data["favoriet"] = $this->ophalenFavoriet($kaalGerechtData["gerecht_id"]);
        $gerecht_data["waardering"] = $this->ophalenWaardering($kaalGerechtData["gerecht_id"]);
        $gerecht_data["bereidingswijze"] = $this->ophalenBereiding($kaalGerechtData["gerecht_id"]);
        $gerecht_data["opmerkingen"] = $this->ophalenOpmerking($kaalGerechtData["gerecht_id"]);
        $gerecht_data["prijs_gerecht"] = $this->berekenPrijs($gerecht_data["ingredienten"]);
        $gerecht_data["calorieen"] = $this->berekenCalorieen($gerecht_data["ingredienten"]);
        $gerecht_data["gemiddelde_waardering"] = $this->berekenGemiddeldeWaardering($gerecht_data["waardering"]);

        $gerechten[] = $gerecht_data;
        }

        return $gerechten;

    }
}
