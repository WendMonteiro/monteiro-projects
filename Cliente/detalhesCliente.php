<?php
require '../banco.php';

$dados = recuperarCliente($pdo, $_GET['id']);

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes</title>
    <link rel="stylesheet" href="../css/det_cliente.css">
</head>

<body>
    <div id="head_dados">
        <h1>Detalhes</h1>
        <a id="voltar" href="./cliente.php"><img width="30px" src="/AdsVendas/imagens/voltar.png" alt=""><br></a>
    </div>
    <div class="container">
        <div class="tabela_dados">
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" value="<?php echo $dados['cpf']?>" readonly>

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?php echo $dados['nome']?>" readonly>

            <label for="endereco">Endereço</label>
            <input type="text" name="endereco" id="endereco" value="<?php echo $dados['endereco']?>" readonly>

            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro" value="<?php echo $dados['bairro']?>" readonly>

            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade" value="<?php echo $dados['cidade']?>" readonly>

            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php echo $dados['telefone']?>" readonly>
            
            
        </div>
    </div>

</body>

</html>