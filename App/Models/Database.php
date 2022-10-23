<?php 
ini_set('display_errors', 1);

class Database {

    private $db;

    private $host       = 'localhost';
    private $dbname     = 'teste';
    private $username   = 'root';
    private $password   = '';
    private $where;

    public function __construct(){

        $this->db = new PDO("mysql:dbname=$this->dbname;host=$this->host;user=$this->username;password=$this->password");

    }

    public function insert(string $table, array $data){

        // Test connection

        if(empty($data)){
            die('Dados não recebidos');
        }

        //echo '<pre>'; print_r($data); die();

        foreach($data as $k => $v){

            $fields[] = $k;
            $values[] = $v;

        }

        $fields = implode("`, `", $fields);
        $values = implode("', '", $values);

        $query = "INSERT INTO `{$table}` (`{$fields}`) VALUES ('{$values}')";

        //echo $query; die();

        $stmt   = $this->db->prepare($query);
        
        return $stmt->execute();

    }

    public function select(string $table, string $fields){

        $query = "SELECT {$fields} FROM `{$table}` ";
        
        //die($query . $this->where);

        $stmt = $this->db->query($query . $this->where)->fetchAll(PDO::FETCH_OBJ);;

        return $stmt;

    }

    public function update(string $table, array $fields){

        //echo '<pre>'; print_r($fields); die();
        foreach($fields as $k => $v){
            $query[] = "`{$k}` = '{$v}'";
        }

        $fields = implode(", ", $query);

        $query = "UPDATE `{$table}` SET {$fields} ";

        $stmt   = $this->db->prepare($query . $this->where);
        
        return $stmt->execute();

    }

    public function where(array|string $where, string $operation = null, string $value = null){

        if(is_array($where)){
            foreach($where as $condition){
                foreach($condition as $k => $v){
                    $query[] = "`{$k}` = '{$v}'";
                }
            }

            $this->where = ' WHERE ' . implode(" AND ", $query);
        }

        return $this;

    }
    
}