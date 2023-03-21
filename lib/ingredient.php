<?php

require_once("lib/artikel.php");

class ingredient {

    private $connection;
    private $art;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->art = new artikel($connection);
    }

    private function ophalenArtikel($artikel_id) {
        $data_art = $this->art->selecteerArtikel($artikel_id);
        return ($data_art);
    }

    public function selecteerIngredient($gerecht_id) {
        $ingredient_artikel = [];
        $sql = "select * from ingredient where gerecht_id = $gerecht_id";
        //echo $sql;
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $artikel_id = $row['artikel_id'];
            echo $artikel_id;
            $artikel = $this->ophalenArtikel($artikel_id);
            //var_dump($artikel);

        $ingredient_artikel = array(
            'ingredient_id' => $row['ingredient_id'],
            'gerecht_id' => $row['gerecht_id'],
            'aantal' => $row['aantal'],
            'naam' => $artikel['naam'],
            'omschrijving' => $artikel['omschrijving'],
            'prijs' => $artikel['prijs'],
            'eenheid' => $artikel['eenheid'],
            'verpakking' => $artikel['verpakking']
        );
    }

        return($ingredient_artikel);
    }

}

