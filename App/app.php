<?php
require 'Models/Database.php';
require 'Controllers/Monitoring.php';

$monitoring = new Monitoring();

if(isset($_GET['route'])){

    $route = $_GET['route'];

    //echo '<pre>'; print_r($_GET); die();

    if(!method_exists($monitoring, $route)){
        die('Rota não encontrada');
    }

    //echo $route; die();

    $monitoring->$route();
    
}