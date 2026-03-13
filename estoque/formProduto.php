<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/formProduto.css">
</head>

<body>
    <div id="head_criarCliente">
        <h1>Criar Novo Produto</h1>
        <a id="voltar" href="./estoque.php"><img width="30px" src="/AdsVendas/imagens/voltar.png" alt=""><br></a>
    </div>

    <div id="container">
        <p>Por favor preencha os dados corretamente</p>
        <form id="cadastro_container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <label for="cod_barras">Código de Barras</label>
            <input type="text" id="cod_barras" name="cod_barras" autocomplete="off">

            <label for="fornecedor">Fornecedor</label>
            <input type="text" id="fornecedor" name="fornecedor" autocomplete="off">

            <label for="nome_produto">Produto</label>
            <input type="text" name="nome_produto" id="nome_produto" autocomplete="off">

            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" id="descricao" autocomplete="off">

            <label for="preco">Preço</label>
            <input type="text" name="preco" id="preco" autocomplete="off">

            <label for="quant">Quantidade</label>
            <input type="text" name="quant" id="quant" autocomplete="off">

            <div class="alinhar_submit">
                <input id="criar" type="submit" value="Criar">
            </div>
        </form>
    </div>

</body>

</html>