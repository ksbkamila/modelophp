<?php
include "../conn/connect.php";

 
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o campo 'login' foi enviado via POST
    // Obtém os valores dos campos
    $login = $_POST['login'];
     $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = md5($_POST['senha']); // Criptografando a senha
    $nivel = 'com'; // Definindo o nível do usuário, pode ser alterado conforme necessário
 
        try {
                // Inicia uma transação para garantir que ambas as inserções sejam feitas de forma atômica
 
                // Insere o usuário na tabela 'usuarios' (para login)
        $sql_usuario = "INSERT INTO usuarios (login, senha, nivel) VALUES (:login, :senha, :nivel)";
        $smt_usuario = $pdo->prepare($sql_usuario);
        $smt_usuario->bindParam(":login", $login);
        $smt_usuario->bindParam(":senha", $senha);
        $smt_usuario->bindParam(":nivel", $nivel);
        $resultado = $pdo->query($insereUsuario);
        $user = $pdo->query("select @@identity");
        $iduser = $user->fetch(PDO::FETCH_ASSOC);
        $id_usuario = $iduser['@@identity'];
        $smt_usuario->execute();
 
                // Insere o cliente na tabela 'cliente' (dados adicionais)
        $sql_cliente = "INSERT INTO clientes (login, cpf, email, senha) VALUES (:login, :cpf, :email, :senha)";
        $smt_cliente = $pdo->prepare($sql_cliente);
        $smt_cliente->bindParam(":email", $email);
        $smt_cliente->bindParam(":senha", $senha); // Note que a senha do cliente é a mesma do usuário
        $smt_cliente->bindParam(":cpf", $cpf);
        $smt_cliente->bindParam(":login", $login);
        $smt_cliente->execute();
 
            if ($smtt->execute()) {
 
            // Mensagem de sucesso
            echo "Usuário e cliente cadastrados com sucesso";
            header('Location: login.php'); // Redireciona para a página de login
            exit();
                }
            } catch (PDOException $e) {
                $pdo->rollBack();
                echo "Erro: " . $e->getMessage();
            }
}
    

?>
 
<!DOCTYPE html>
<html lang="pt-BR">
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="30;URL=../index.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/2495680ceb.js" crossorigin="anonymous"></script>
    <!-- Link para CSS específico -->
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">
 
    <title>Chuleta Quente - Cadastro</title>
</head>
 
<body>
    <main class="container">
        <section>
            <article>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <h1 class="breadcrumb text-info text-center">Faça seu cadastro</h1>
                        <div class="thumbnail">
                            <p class="text-info text-center" role="alert">
                                <i class="fas fa-users fa-10x"></i>
                            </p>
                            <br>
                            <div class="alert alert-info" role="alert">
                                <form action="login.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="nivel" id="nivel" value="com">
                                    <label for="login">Nome:</label>
                                    <p class="input-group">
                                        <input type="text" name="login" id="login" class="form-control" required autocomplete="off" placeholder="Digite seu nome de usuário.">
                                    </p>
                                    <label for="email">Email:</label>
                                    <p class="input-group">
                                        <input type="email" name="email" id="email" class="form-control" required autocomplete="off" placeholder="Digite seu email.">
                                    </p>
                                    <label for="cpf">Cpf:</label>
                                    <p class="input-group">
                                        <input type="text" name="cpf" id="cpf" class="form-control" required autocomplete="off" placeholder="Digite seu CPF.">
                                    </p>
                                    <label for="senha">Senha:</label>
                                    <p class="input-group">
                                        <input type="password" name="senha" id="senha" class="form-control" required autocomplete="off" placeholder="Digite sua senha.">
                                    </p>
                                    <p class="text-right">
                                        <input type="submit" value="Cadastrar" class="btn btn-primary">
                                    </p>
                                </form>
                                <p class="text-center">
                                    <small>
                                        <br>
                                        Caso não faça uma escolha em 30 segundos, será redirecionado automaticamente para a página inicial.
                                    </small>
                                </p>
                            </div><!-- fecha alert -->
                        </div><!-- fecha thumbnail -->
                    </div><!-- fecha dimensionamento -->
                </div><!-- fecha row -->
            </article>
        </section>
    </main>
 
    <!-- Link arquivos Bootstrap js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
 
</html>
 