<?php
ini_set('display_errors', 0);
/*
 * Método de conexão sem padrões
 */
class Database
{
  // configuração do banco de dados
    private $host   = 'localhost';
    private $dbname = 'teste';
    private $username = 'root';
    private $password = '';

    // armazena a conexão
    public $conn;

    public function __construct()
    {
        // Quando essa classe é instanciada, é atribuido a variável $conn a conexão com o db
        $this->conn = new PDO("mysql:dbname=$this->dbname;host=$this->host;user=$this->username;password=$this->password");

        
    }

}