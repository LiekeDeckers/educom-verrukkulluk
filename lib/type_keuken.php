<?php

class type_keuken {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selecteerTypeKeuken($type_keuken_id) {

        $sql = "select * from type_keuken where id= $type_keuken_id";

        $result = mysqli_query($this->connection, $sql);
        $artikel = mysqli_fetch_array($result, MYSQL_ASSOC);

        return($type_keuken_id);
    }

}