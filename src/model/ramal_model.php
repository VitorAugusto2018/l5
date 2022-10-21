<?php

ini_set('display_errors', 1);
require('../../config.php');

class Ramal {

    public function atualizarDados() {                                              
        
        $db = new Database();        

        
        $ramais = file('../../lib/ramais');
        $filas = file('../../lib/filas');

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
                list($host) = explode('/',$arr[1]);       
                $info_ramais[$name] = array(
                    'nome'     => $name,
                    'ramal'    => $username,
                    'ip'       => $host,
                    'online'   => false,
                    'status'   => $status_ramais[$name]['status'],
                    'operador' => $status_ramais[$name]['operador']
                );
            }                        
            if(isset($arr[5]) && trim($arr[5]) == "OK"){                      
                list($name,$username) = explode('/',$arr[0]);
                list($host) = explode('/',$arr[1]);
                $info_ramais[$name] = array(
                    'nome' => $name,
                    'ramal'     => $username,
                    'ip'        => $host,
                    'online'    => true,
                    'status'    => $status_ramais[$name]['status'],
                    'operador'  => $status_ramais[$name]['operador']
                );
            }
        }                            

        foreach($info_ramais as $i){        
                        
            $result = $db->conn->query("SELECT * FROM teste.ramais WHERE Name = '$i[nome]'");                

            if($result){

                $result = $db->conn->query("UPDATE teste.ramais SET nome    ='$i[nome]', ramal   ='$i[ramal]', ip      ='$i[ip]',status  ='$i[status]' WHERE nome= '$i[nome]'");
                //$stmt= $db->conn->prepare($sql);            
                //$stmt->execute();
            }else{

                $result = $db->conn->query("INSERT INTO 
                                                teste.ramais
                                                (nome ,
                                                ramal ,
                                                ip,
                                                status)
                                            VALUES 
                                                ('$i[nome]', 
                                                '$i[ramal]', 
                                                '$i[ip]',
                                                '$i[status]')");        

            }                                        

        }        

        $result->fetchAll(PDO::FETCH_ASSOC);

        var_dump($result);
      
    }
    
}

$ramal = new Ramal();

$ramal->atualizarDados();
?>