<?php 
$host = "localhost";
$database = "tinsphpdb01";
$root = "root";
$pass = "";
$charset = "utf8";
$port = "3306";

try{
    //lembre dessa variavel quando usar um comando sql no php 
    $conn = new mysqli($host, $root, $pass, $database, $port);
    mysqli_set_charset($conn, $charset); //utf8
}catch(Throwable $th){
    die("Falha, ocorreu um erro! ".$th);
}
?>