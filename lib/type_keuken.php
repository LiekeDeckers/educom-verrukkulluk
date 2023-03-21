<?php

class type_keuken {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selecteerTypeKeuken($type_keuken_id) {

        $sql = "select * from type_keuken where type_keuken_id= $type_keuken_id";

        $result = mysqli_query($this->connection, $sql);
        $type_keuken = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($type_keuken);
    }

}