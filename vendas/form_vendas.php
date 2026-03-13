<?php

require_once __DIR__ . '/../banco.php';

date_default_timezone_set('America/Manaus');

$clientes = recuperarTodosCliente($pdo);

$produtos = recuperarTodosProdutos($pdo);

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_POST['adicionar_produto'])) {
    $idProduto = $_POST['id_produto'];
    $quantidade = isset($_POST['quant_venda']) ? (int) $_POST['quant_venda'] : 1;

    $stmt = $pdo->prepare("SELECT * FROM produto WHERE id = ?");
    $stmt->execute([$idProduto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($produto) {

        $quantidade = max(1, (int) $quantidade);

        $encontrado = false;
        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item['id'] == $produto['id']) {
                $item['quant_venda'] += $quantidade;
                $encontrado = true;
                break;
            }
        }
        unset($item);

        if (!$encontrado) {
            $produto['quant_venda'] = $quantidade;
            $_SESSION['carrinho'][] = $produto;
        }
    }

    header("Location: form_vendas.php");
    exit;
}

$carrinho = $_SESSION['carrinho'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link rel="stylesheet" href="../css/form_vendas.css">
</head>

<body>
    <div id="head_vendas">
        <h1>Venda</h1>
        <a id="voltar" href="/AdsVendas/menu.php"><img width="30px" src="/AdsVendas/imagens/voltar.png" alt=""><br></a>
        <p id="alerta_venda">Venda finalizada com sucesso!</p>
    </div>

    <div id="vendas_container">
        <div class="form_vendas">
            <div id="cab_vendas">
                <h3>Pedido</h3>
            </div>

            <!--cliente-->
            <form action="vendas.php" method="post">
                <div class="busca_cliente">
                    <input class="data_pedido" type="datetime-local" name="data_pedido"
                        value="<?php echo date('Y-m-d\TH:i'); ?>">
                    <div class="forma_cpf">
                        <label for="cliente">Cliente</label>
                        <input class="input_cpf" type="text" name="id_cliente" id="id_cliente"
                            placeholder="Digite o CPF" autocomplete="off" inputmode="numeric">
                        <datalist id="lista_clientes">
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?php echo $cliente['cpf'] ?>"> <?php echo $cliente['cpf'] ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="forma_nome">
                        <label for="nome">Nome</label>
                        <input class="input_nome" type="text" id="nome" placeholder="Nome Completo" readonly>
                    </div>
                </div>

                <!--Adicionar no carrinho-->
                <div class="buscarProdutoCarrinho">
                    <div>
                        <label for="">Buscar Produto</label>
                        <input class="input_produto" type="text" list="lista_produtos" name="id_produto"
                            id="id_produto">

                        <datalist id="lista_produtos">
                            <?php foreach ($produtos as $prod): ?>
                                <option value="<?php echo $prod['id']; ?> "><?php echo $prod['nome_produto'] ?></option>
                            <?php endforeach; ?>
                        </datalist>
                        <label for="quant_venda">Quantidade</label>
                        <input class="input_quantidade" type="number" name="quant_venda" id="quant_venda" min="1">

                        <input type="submit" class="btn_adicionar" name="adicionar_produto" id="adicionar_produto"
                            value="Adicionar">
                    </div>
                    <div>
                        <label for="">Tipo de Venda</label>
                        <select class="tipo" name="tipo_venda" id="tipo_venda">
                            <option value="1">Imedita</option>
                            <option value="2">Entrega</option>
                        </select>
                    </div>
                </div>

                <!--tabela do carrinho-->
                <div class="tabela_produtos">
                    <table>
                        <tr>
                            <th>Forn.</th>
                            <th class="nomeProduto">Produto</th>
                            <th class="descricaoProduto">Descrição</th>
                            <th>Preço UND</th>
                            <th>Preço</th>
                            <th>Quant</th>
                            <th>Remover</th>
                        </tr>
                        <?php foreach ($carrinho as $produtos): ?>
                            <tr>
                                <td><?php echo $produtos['fornecedor'] ?></td>
                                <td><?php echo $produtos['nome_produto'] ?></td>
                                <td class="descricaoProduto"><?php echo $produtos['descricao'] ?></td>
                                <td><?php echo $produtos['preco'] ?></td>
                                <td><?php echo number_format($produtos['preco'] * $produtos['quant_venda'], 2, ',', '.'); ?>
                                </td>
                                <td><?php echo $produtos['quant_venda'] ?></td>
                                <td><a href="removerItens.php?id=<?php echo $produtos['id']; ?>"><img
                                            src="../imagens/excluir.png" alt="excluir"></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php
                    $total = 0;
                    foreach ($carrinho as $produtos) {
                        $sub = $produtos['preco'] * $produtos['quant_venda'];
                        $total += $sub;
                    }
                    ?>
                </div>
                <div class="form_final">
                    <h3>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h3>
                    <input class="finalizar_venda" type="submit" value="Finalizar Venda" name="finalizar_venda"
                        id="finalizar_venda">
                </div>
            </form>

        </div>
    </div>

    <!--só para apareceer o nome-->
    <script>
        const clientes = <?= json_encode($clientes); ?>;

        document.getElementById('id_cliente').addEventListener('blur', function () {
            const cpfDigitado = this.value;

            const clienteEncontrado = clientes.find(c => c.cpf === cpfDigitado);

            if (clienteEncontrado) {
                document.getElementById('nome').value = clienteEncontrado.nome;
            } else {
                document.getElementById('nome').value = 'Cliente não encontrado';
            }
        });
    </script>
</body>

                        <!--Alerta-->
<?php if (!empty($_SESSION['venda_sucesso'])): ?>
    <script>
        const msg = document.getElementById('alerta_venda');
        msg.style.display = 'block'

        setTimeout(() => {
            msg.style.display = 'none';
        }, 3000);
    </script>
    <?php unset($_SESSION['venda_sucesso']); endif ?>

</html>