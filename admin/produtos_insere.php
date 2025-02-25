<?php 
include 'acesso_com.php';
include '../conn/connect.php';
//verifica se o form foi enviado via post
if($_POST){
    if(isset($_POST['enviar'])){
        //verifica se o btn foi acionado
        $nome_img = $_FILES['imagemfile'] ['name'];
        $tmp_img = $_FILES['imagemfile'] ['tmp_name'];
        $rand = rand(100001,999999); //gerar um numero aleatorio
        $dir_img = "../images/".$rand.$name_img; //vai concatenar
    }
        //mover o arquivo da pasta tmp para o diretório de destino 
        move_uploaded_file($tmp_img, $dir_img);//vai mover o arquivo que esta na pasta temporaria  para o destino
        //recupera o id do tipo de produto selecionado no formulario
        $id = $_POST['id_tipo'];
        // recupera o valor do campo 'destaque' do formulario
        $destaque = $_POST['destaque'];
        // recupera a descricao do produto enviada do formulario
        $descricao = $_POST['descricao'];
        //recupera o resumo do produto enviada do formulario
        $resumo = $_POST['resumo'];
        //recupera o valor do produto
        $valor = $_POST['valor'];
        //concatena o num aleatorio com o nome da imagem para salvar no banco de dados 
        $imagem = $rand.$nome_img;
        //montar query para inserir o novo produto na tabela produtos
        $insereProduto = "insert into produtos (tipo_id, destaque, descricao, resumo, valor) values ($id, '$descricao', '$valor', '$imagem', '$destaque')";
        //executa a query de inserção no banco de dados
        $resultado = $conn->query($insereProduto);
        //verifica se a inserção foi bem-sucedida pelo retorno do id do registro inserido
        if(mysqli_insert_id($conn)){
            //redireciona para a pagina de listagem de produtos 
            header('location:produtos_lista.php');
        }

}
//seleciona a lista de tipos para preencher o <select> do formulario
$listaTipo = $conn->query("select * from tipos order by rotulo");
//recupera o primeiro registro da consulta como array associativo 
$rowTipo = $listaTipo->fetch_assoc();
//armazena o numero total de registros retornados na consulta
$numLinhas = $listaTipo->num_rows;



?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Produto - Insere</title>
</head>
<body>

<?php include "menu_adm.php";?>
<main class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-offset-2 col-sm-6  col-md-8">
            <h2 class="breadcrumb text-danger">
                <a href="produtos_lista.php">
                    <button class="btn btn-danger">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </button>
                </a>
                Inserindo Produtos
            </h2>
            <div class="thumbnail">
                <div class="alert alert-danger" role="alert">
                    <form action="produtos_insere.php" method="post" 
                    name="form_insere" enctype="multipart/form-data"
                    id="form_insere">
                        <label for="id_tipo">Tipo:</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
                            </span>
                            <select name="id_tipo" id="id_tipo" class="form-control" required>
                               <?php do{ ?>
                                    <option value="<?php
                                        //exibe o id do tipo 
                                        echo $rowTipo['id'];?>">
                                    <?php 
                                    //exibe o rotulo (nome) do tipo
                                    echo $rowTipo['rotulo'];?>
                                    </option>
                               <?php }while($rowTipo = $listaTipo->fetch_assoc());?> 
                            </select>
                        </div>
                        <label for="destaque">Destaque:</label>
                        <div class="input-group">
                            <label for="destaque_s" class="radio-inline">
                                <input type="radio" name="destaque" id="destaque" value="Sim">Sim
                            </label>
                            <label for="destaque_n" class="radio-inline">
                                <input type="radio" name="destaque" id="destaque" value="Não" checked>Não
                            </label>
                        </div>
                            <label for="descricao">Descrição:</label>     
                        <div class="input-group">
                           <span class="input-group-addon">
                                <span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span>
                           </span>
                           <input type="text" name="descricao" id="descricao" 
                                class="form-control" placeholder="Digite a descrição do Produto"
                                maxlength="100" required>
                        </div>   
                        
                        <label for="resumo">Resumo:</label>     
                        <div class="input-group">
                           <span class="input-group-addon">
                                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                           </span>
                           <textarea  name="resumo" id="resumo"
                                cols="30" rows="8"
                                class="form-control" placeholder="Digite os detalhes do Produto"
                                required></textarea>
                        </div> 
                        
                        <label for="valor">Valor:</label>     
                        <div class="input-group">
                           <span class="input-group-addon">
                                <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                           </span>
                           <input type="number" name="valor" id="valor" 
                                class="form-control" required min="0" step="0.01">
                        </div>   
                        <label for="imagem">Imagem:</label>    
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                           </span>
                           <img src="" name="imagem" id="imagem" class="img-responsive">
                           <input type="file" name="imagemfile" id="imagemfile" class="form-control" accept="image/*">
                        </div>

                        <br>
                        <input type="submit" name="enviar" id="enviar" class="btn btn-danger btn-block" value="Cadastrar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Script para imagem -->
<script>
document.getElementById("imagem").onchange = function(){
    var reader = new FileReader();
    if(this.files[0].size>512000){
        alert("A imagem deve ter no máximo 500KB");
        $("#imagem").attr("src", "blank");
        $("#imagem").hide();
        $("#imagem").wrap('<form>').closest('form').get(0).reset();
        $("#imagem").unwrap();
        return false
    }
    if(this.files[0].type.indexOf("image")==-1){
        alert("formato inválido, escolha uma imagem!");
        $("#imagem").attr("src", "blank");
        $("#imagem").hide();
        $("#imagem").wrap('<form>').closest('form').get(0).reset();
        $("#imagem").unwrap();
        return false
    }
    reader.onload = function(e){
        document.getElementById("imagem").src = e.target.result
        $("#imagem").show();
    }
    reader.readAsDataURL(this.files[0])
}    
</script>

</body>
</html>