<?php

//require('/,,/config.php');

class Ramal {

    public function verificar_ramal() {                                              

        $db = new Database();        

        $result = $db->conn->query('SELECT * FROM teste.ramais');                

        if($result){

            return $result->fetchAll(PDO::FETCH_ASSOC);  

        }
    }
    
}

?>