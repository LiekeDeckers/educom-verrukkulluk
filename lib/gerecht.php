<?php

require_once("lib/type_keuken.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");

class gerecht {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selecteerGerecht($gerecht_id) {

        $sql = "select * from gerecht where gerecht_id = $gerecht_id";
        
        $result = mysqli_query($this->connection, $sql);
        $gerecht = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($gerecht);

    }

}