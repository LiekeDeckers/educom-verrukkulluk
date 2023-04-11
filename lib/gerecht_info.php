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

// user ophalen bij opmerking en favoriet    
    public function selecteerGerechtInfo($gerecht_id, $record_type) {
        $sql = "select * from gerecht_info where gerecht_id = $gerecht_id and record_type = '$record_type'";
        //echo $sql;
        $result = mysqli_query($this->connection, $sql);
        $gerecht_info = [];

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            if ($record_type == 'O' || $record_type == 'F') { 
                //var_dump($row);
                $user_id = $row['user_id'];
                //echo $user_id;
                $user = $this->ophalenUser($user_id);
                //var_dump($user);
            
                $gerecht_info[] = [
                    'gerecht_info_id' => $row['gerecht_info_id'],
                    'record_type' => $row['record_type'],   
                    'gerecht_id' => $row['gerecht_id'],
                    'datum' => $row['datum'],
                    'nummeriekveld' => $row['nummeriekveld'],
                    'tekstveld' => $row['tekstveld'],
                    'user_name' => $user['user_name'],
                    'user_password' => $user['user_password'],
                    'email' => $user['email'],
                    'user_afbeelding' => $user['user_afbeelding']
                ];
            }

            else {
                $gerecht_info[] = $row;
            }
        
            
        }
        return($gerecht_info);
    }
    


// favoriet
    public function toevoegenFavoriet($gerecht_id, $user_id) {
        $sql = "INSERT INTO gerecht_info (record_type, gerecht_id, user_id) 
        VALUES ('F', '$gerecht_id', '$user_id')";
        $result = mysqli_query($this->connection,$sql);
    }

    public function verwijderenFavoriet($gerecht_id, $user_id) {
        $sql = "DELETE FROM gerecht_info WHERE gerecht_id = $gerecht_id and user_id = $user_id";
        $result = mysqli_query($this->connection,$sql);
    }


// waardering
    public function toevoegenWaardering($gerecht_id, $value) {

        $sql = "INSERT INTO gerecht_info (record_type, gerecht_id, nummeriekveld) 
        VALUES ('W', '$gerecht_id', '$value')";
        $result = mysqli_query($this->connection,$sql);

    }
}








