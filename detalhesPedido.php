<?php
require './banco.php';

$dados = recuperarPedidoComItens($pdo, $_GET['id']);

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes</title>
    <link rel="stylesheet" href="./css/det_pedido.css">
</head>

<body>
    <div id="head_dados">
        <h1>Nº Pedido: <?php echo $_GET['id']?></h1>
        <a id="voltar" href="./pedido.php"><img width="30px" src="/AdsVendas/imagens/voltar.png" alt=""><br></a>
    </div>
    <div class="container">
        <table>
            <tr>
                <th>Data</th>
                <th class="celular" >hora</th>
                <th>Cliente</th>
                <th class="celular" >Tipo de Venda</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço</th>
            </tr>
            <?php foreach ($dados as $dado): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($dado['data_venda'])); ?></td>
                    <td class="celular" ><?php echo date('H:i', strtotime($dado['data_venda'])) ?></td>
                    <td><?php echo $dado['nome_cliente']?></td>
                    <td class="celular" ><?php echo $dado['tipo_venda'] == 1 ? 'Imediata' : 'Entrega' ?></td>
                    <td><?php echo $dado['nome_produto']?></td>
                    <td><?php echo $dado['quantidade']?></td>
                   <td>R$ <?php echo $dado['preco'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>