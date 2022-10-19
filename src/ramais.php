<?php    
ini_set('display_errors', 1);

require('../config.php');

require('model/ramal_model.php');

class Ramais extends Ramal
{          

    public function verificar_status() {                

        //die('controler');                

        $ramalresult = $this->verificar_ramal();                        

        echo json_encode($ramalresult);
    
    }

}

//die('fora da classe');

$ramais = new Ramais();

$ramais->verificar_status();

