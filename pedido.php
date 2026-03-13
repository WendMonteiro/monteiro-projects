<?php
require './banco.php';

$id_usuario = $_SESSION['id'];
$pedidos = recuperarPedidoPorVendedor($pdo, $id_usuario);



?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="stylesheet" href="./css/pedido.css">
</head>

<body>
    <div id="head_pedido">
        <h1>Pedidos</h1>
        <a id="voltar" href="/AdsVendas/menu.php"><img width="30px" src="/AdsVendas/imagens/voltar.png" alt=""><br></a>
    </div>

    <div id="form_container">
        <input type="text" class="busca" id="busca" placeholder="Buscar Pedido..." onkeyup="buscarPedido()">
        <table id="tabela_pedidos">

            <tr>
                <th>Nº Pedido</th>
                <th>Data Pedido</th>
                <th class="celular" >Cliente</th>
                <th>Tipo de Venda</th>
                <th class="celular" >Total</th>
                <th class="">detalhes</th>
            </tr>
            <?php
                foreach ($pedidos as $pedido) : ?>
                <tr>
                    <td><?php echo $pedido['id'] ?></td>
                    <td><?php echo date('d/m/Y', strtotime($pedido['data_venda'])); ?></td>
                    <td class="celular" ><?php echo $pedido['nome_cliente']?></td>
                    <td ><?php echo $pedido['tipo_venda'] == 1 ? 'Imediata' : 'Entrega' ?></td>
                    <td class="celular" >R$ <?php echo '' . $pedido['total_venda'] ?></td>
                    <td class=""><a href="detalhesPedido.php?id=<?php echo $pedido['id'] ?>"> <img width="25px" src="/AdsVendas/imagens/detalhes.png" alt="detalhes"></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>


    <script>
        function buscarPedido() {
            let input = document.getElementById("busca").value.toUpperCase();
            let tabela = document.getElementById("tabela_pedidos");
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