<?php

require_once("lib/artikel.php");

class ingredient {

    private $connection;
    private $art;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selecteerIngredient($ingredient_id) {

        $sql = "select * from ingredient where ingredient_id = $ingredient_id";

        $result = mysqli_query($this->connection, $sql);
        $ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        return($ingredient);
    }

// nog iets met selecteerArtikel


}