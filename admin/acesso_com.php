<?php 
session_name('chulettaaa');
if(!isset($_SESSION)){ //se não atribuido valor é pq não tem sessão aberta //matriz associativa 
   session_start();
} 
//segurança digital
//verificar se o usuario esta logado na sessao
if(!isset($_SESSION['login_usuario'])){// determina se uma variavel esta declarada e não é diferente nulo 
    // se nao existir, redirecionamos a sessão por segurança
    header('location: login.php');
    exit;
}
$nome_da_sessao= session_name();
if(!isset($_SESSION['$nome_da_sessao']) or ($_SESSION['$nome_da_sessao'] != $nome_da_sessao))
{
    session_destroy();
    header('location: login.php');  
}
?>