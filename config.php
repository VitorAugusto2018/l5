<?php
ini_set('display_errors', 1);
/*
 * Método de conexão sem padrões
 */
class Database
{
  // configuração do banco de dados
    private $host   = 'mysql';
    private $dbname = 'teste';
    private $username = 'root';
    private $password = 'root';

    // armazena a conexão
    public $conn;

    public function __construct()
    {
        // Quando essa classe é instanciada, é atribuido a variável $conn a conexão com o db
        $this->conn = new PDO("mysql:dbname=$this->dbname;host=$this->host;user=$this->username;password=$this->password");

        
    }

}