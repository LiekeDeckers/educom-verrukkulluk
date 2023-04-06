<?php

require_once("gerecht.php");
require_once("gerecht_info.php");
require_once("keuken_type.php"); 
require_once("ingredient.php");
require_once("artikel.php");

class zoeken {

    private $connection;
    private $ger;  

    public function __construct($connection) {
        $this->connection = $connection;
        $this->ger = new gerecht($connection);
    }

    private function ophalenGerecht() {
        $data_ger = $this->ger->selecteerGerecht();
        return($data_ger);
    }

    public function zoeken() { /////
        $zoekresultaat = []; 

        $sql = "select * from"; /////
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $zoekresultaat[] = $row;
        }

    return($zoekresultaat);
    }

}