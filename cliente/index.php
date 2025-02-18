<?php 
if(isset($_GET['cliente'])){
   $cliente = $_GET['cliente'];
    echo "<h2> Olá, ".$cliente.", seja bem vindo á sua área!<h2>";
}
?>