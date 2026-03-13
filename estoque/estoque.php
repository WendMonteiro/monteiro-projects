<?php

require "../banco.php";

$produtos = recuperarTodosProdutos($pdo);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="/AdsVendas/css/estoque.css">
</head>

<body>
    <div id="head_estoque">
        <h1>Estoque</h1>
        <a id="voltar" href="/AdsVendas/menu.php"><img width="30px" src="/AdsVendas/imagens/voltar.png" alt=""><br></a>
        <a class="novo" href="./criarProduto.php">Criar Novo Produto</a>
        <a class="novoCelular" href="./criarProduto.php">+Produto</a>
    </div>

    <div id="form_container">
        <input type="text" class="busca" id="busca" placeholder="Buscar produto..." onkeyup="buscarProduto()">
        <table id="tabela_produto">
            <tr>
                <th class="celular">cód. de Barras</th>
                <th>fornecedor</th>
                <th>Produto</th>
                <th class="celular">Descrição</th>
                <th>Preço Venda</th>
                <th>Quantidade</th>
            </tr>
            <?php foreach ($produtos as $produto) : ?>
            <tr>
                <td class="celular"> <?php echo $produto['cod_barras']?></td>
                <td> <?php echo $produto['fornecedor']?></td>
                <td> <?php echo $produto['nome_produto']?></td>
                <td class="celular"> <?php echo $produto['descricao']?></td>
                <td>R$ <?php echo $produto['preco']?></td>
                <td> <?php echo $produto['quant']?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>

    <script>
        function buscarProduto() {
            let input = document.getElementById("busca").value.toUpperCase();
            let tabela = document.getElementById("tabela_produto");
            let tr = tabela.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let tds = tr[i].getElementsByTagName("td");
                let encontrou = false;

                for (let j = 0; j < tds.length; j++) {
                    if (tds[j].textContent.toUpperCase().includes(input)) {
                        encontrou = true;
                        break
                    }
                }
                tr[i].style.display = encontrou ? "" : "none";
            }
        }
    </script>

</body>

</html>