<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Cliente</title>
    <link rel="stylesheet" href="../css/criarCliente.css">
</head>

<body>
    <div id="head_criarCliente">
        <h1>Criar Novo Cliente</h1>
        <a id="voltar" href="./cliente.php"><img width="30px" src="/AdsVendas/imagens/voltar.png" alt=""><br></a>
    </div>

    <div id="container">
        <p>Por favor preencha os dados corretamente</p>
        <form id="cadastro_container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" autocomplete="off" inputmode="numeric">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" autocomplete="off">

            <label for="endereco">Endereço</label>
            <input type="text" name="endereco" id="endereco" autocomplete="off">

            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro" autocomplete="off">

            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade" autocomplete="off">

            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" autocomplete="off">

            <div class="alinhar_submit" >
                <input id="criar" type="submit" value="Criar">
            </div>
        </form>
    </div>

</body>

</html>