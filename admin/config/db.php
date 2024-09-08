<?php

$host="localhost";
$db="deustoformacion";
$user="root";
$password="";

try{
    $connection= new PDO("mysql:host=$host;dbname=$db",$user,$password);
    if($connection)
    {
        //echo "Conectado al la base de datos";
    }
} catch ( Exception $ex) {
    echo $ex->getMessage();
}

?>