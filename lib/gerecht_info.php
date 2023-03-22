<?php
require_once("lib/user.php");

class gerecht_info {

    private $connection;
    private $usr;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->usr = new user($connection);
    }

    private function ophalenUser($user_id) {
        $data_usr = $this->usr->selecteerUser($user_id);
        return($data_usr);
    }

    public function selecteerGerechtInfo($gerecht_id) {
        $sql = "select * from gerecht_info where gerecht_id = $gerecht_id";
        //echo $sql;
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)); {
            if ($row["record_type"] == 'O' || $row["record_type"] == 'F') { 
                $user_id = $row['user_id'];
                echo $user_id;
                $user = $this->ophalenUser($user_id);
                var_dump($user);
            
            $gerecht_info[] = [
                'gerecht_info_id' => $row['gerecht_info_id'],
                'record_type' => $row['record_type'],   
                'gerecht_id' => $row['gerecht_id'],
                'datum' => $row['datum'],
                'nummeriekveld' => $row['nummeriekveld'],
                'tekstveld' => $row['tekstveld'],
                'user_name' => $user['user_name'],
                'user_password' => $user['user_password'],
                'email' => $user['email']
            ];
        }
        else {
            $gerecht_info[] = $row;
        }

        return($ingredient_info);    
        }
    }    
}