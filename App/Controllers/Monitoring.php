<?php

class Monitoring extends Database {

    public function list(){

        echo json_encode($this->select('extensions', '*')); die();

    }

    public function updateDb(){

        $data = $this->readQuees();

        //echo '<pre>'; print_r($data); die();

        if(!empty($data)){

            foreach($data as $ext){

                //echo '<pre>'; print_r($ext); die();

                // Check extesion in database
                $checkExt   = $this->where([
                    ['ramal' => $ext['ramal']]
                ])->select('extensions', '*');

                //echo '<pre>'; var_dump($checkExt);

                // If extension not exists, store
                if(!$checkExt){
                   $this->insert('extensions', $ext);
                }

                // If it exists, update
                $this->where([
                    ['ramal' => $ext['ramal']]
                ])->update('extensions', $ext);

            }

        }

        //die('atualizado');

    }

    public function readQuees(){

        $ramais = file(__DIR__ . '\\..\\..\\App\\Storage\\ramais');
        $filas = file(__DIR__ . '\\..\\..\\App\\Storage\\filas');

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
                    'nome'     => $status_ramais[$name]['operador'],
                    'ramal'    => $username,
                    'ip'       => $host,
                    'online'   => false,
                    'status'   => $status_ramais[$name]['status']
                );
            }                        
            if(isset($arr[5]) && trim($arr[5]) == "OK"){                      
                list($name,$username) = explode('/',$arr[0]);
                list($host) = explode('/',$arr[1]);
                $info_ramais[$name] = array(
                    'nome'     => $status_ramais[$name]['operador'],
                    'ramal'     => $username,
                    'ip'        => $host,
                    'online'    => true,
                    'status'    => $status_ramais[$name]['status']                    
                );
            }
        }  

        //echo '<pre>'; print_r($info_ramais); die();

        return $info_ramais;

    }

}