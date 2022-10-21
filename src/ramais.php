<?php    
ini_set('display_errors', 0); /// Tem um jeito de ocultar os WANRING, precisamos pesquisar

require('../config.php');

//require('model/ramal_model.php');

class Ramais
{          

    public function verificar_status() {                

        //die('controler');                

        $ramalresult = $this->verificar_ramal();                        

        echo json_encode($ramalresult);
    
    }

    public function lerFilas(){               
        
        $ramais = file('../lib/ramais');
        $filas = file('../lib/filas');

        foreach($filas as $linhas){
            if(strstr($linhas,'SIP/')){
                if(strstr($linhas,'(Ring)')){
                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal) = explode('/',$linha[0]);
                    $status_ramais[$ramal] = array('status' => 'chamando');
                }
                if(strstr($linhas,'(In use)')){            
                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal) = explode('/',$linha[0]);
                    $status_ramais[$ramal] = array('status' => 'ocupado');    
                }
                if(strstr($linhas,'(Not in use)')){
                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal)  = explode('/',$linha[0]);
                    $status_ramais[$ramal] = array('status' => 'disponivel');    
                }
                //
                if(strstr($linhas,'(Unavailable)')){
                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal)  = explode('/',$linha[0]);
                    $status_ramais[$ramal] = array('status' => 'indisponivel');    
                }

                if(strstr($linhas,'(paused)')){
                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal)  = explode('/',$linha[0]);
                    $status_ramais[$ramal] = array('status' => 'pausa');    
                }
                $linha = array_reverse(explode(' ', trim($linhas)));   
                $status_ramais[$ramal]['operador'] = $linha[0];                          
            }
            

        }
        $info_ramais = array();
        foreach($ramais as $linhas){
            $linha = array_filter(explode(' ',$linhas));
            $arr = array_values($linha);
            
            if(trim($arr[1]) == '(Unspecified)' AND trim($arr[4]) == 'UNKNOWN'){        
                list($name, $username) = explode('/',$arr[0]);        
                $info_ramais[$name] = array(
                    'nome' => $name,
                    'ramal' => $username,
                    'online' => false,
                    'status' => $status_ramais[$name]['status'],
                    'operador' => $status_ramais[$name]['operador']
                );
            }
            //if(!isset($arr[5])){
            //    echo '<pre>'; print_r($arr); die();
            //}
            if(isset($arr[5]) && trim($arr[5]) == "OK"){                      
                list($name,$username) = explode('/',$arr[0]);
                $info_ramais[$name] = array(
                    'nome' => $name,
                    'ramal' => $username,
                    'online' => true,
                    'status' => $status_ramais[$name]['status'],
                    'operador' => $status_ramais[$name]['operador']
                );
            }
        }

        //echo '<pre>'; print_r($info_ramais); die();

        echo json_encode($info_ramais);
        
    }

}

//die('fora da classe');

$ramais = new Ramais();

$ramais->lerFilas();

