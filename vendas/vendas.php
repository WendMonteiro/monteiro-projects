<?php

require '../banco.php';

$data_venda = $id_cliente = $id_produto = $id_usuario = $tipo_venda = $quant_venda = $total_venda = "";
$id_cliente_erro = $tipo_erro = $quant_erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['finalizar_venda'])) {
    if (empty(trim($_POST['id_cliente']))) {
        $id_cliente_erro = "Informe o CPF do cliente!";
    } elseif (empty(trim($_POST['tipo_venda']))) {
        $tipo_erro = "Por favor informe o tipo da venda!";
    } elseif (empty($_SESSION['carrinho'])) {
        $quant_erro = "Carrinho vazio!";
    } else {
        $query = "SELECT id FROM ads_vendas.cliente WHERE cpf = :cpf";

        if ($stmt = $pdo->prepare($query)) {
            $stmt->bindParam(":cpf", $_POST['id_cliente'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
                    $data_venda = !empty($_POST['data_pedido']) ? $_POST['data_pedido'] : date('Y-m-d H:i:s');
                    $id_cliente = $cliente['id'];
                    $tipo_venda = trim($_POST['tipo_venda']);
                    $total_venda = 0;

                    foreach ($_SESSION['carrinho'] as $item) {
                        $total_venda += $item['preco'] * $item['quant_venda'];
                    }

                } else {
                    $id_cliente_erro = "Cliente não encontrado cadastro";
                }
            } else {
                echo "Algo deu errado, tente novamente!";
            }
            unset($stmt);
        }
    }

    if (empty($id_cliente_erro) && empty($tipo_erro) && empty($quant_erro)) {
        $query = "INSERT INTO vendas(id_usuario, id_cliente, tipo_venda, total_venda, data_venda) VALUES (:id_usuario, :id_cliente, :tipo_venda, :total_venda, :data_venda)";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'id_usuario' => $_SESSION['id'],
            'id_cliente' => $id_cliente,
            'tipo_venda' => $tipo_venda,
            'total_venda' => $total_venda,
            'data_venda' => $data_venda
        ]);

        $idVenda = $pdo->lastInsertId();

        $query = "INSERT INTO itens_vendas(id_venda, id_produto, quantidade, preco) VALUES (:id_venda, :id_produto, :quantidade, :preco)";

        $stmt = $pdo->prepare($query);

        foreach ($_SESSION['carrinho'] as $item) {
            $stmt->execute([
                'id_venda' => $idVenda,
                'id_produto' => $item['id'],
                'quantidade' => $item['quant_venda'],
                'preco' => $item['preco']
            ]);
        }

        foreach ($_SESSION['carrinho'] as $item) {

            $id_produto = $item['id'];
            $quant_venda = (int) $item['quant_venda'];

            $produtos = recuperarProduto($pdo, $id_produto);

            $query = "UPDATE ads_vendas.produto SET quant = :quant WHERE id = :id";

            $quant_nova = $produtos['quant'] - $quant_venda;

            $stmt = $pdo->prepare($query);

            $stmt->execute([
                'quant' => $quant_nova,
                'id' => $id_produto
            ]);

        }

        unset($_SESSION['carrinho']);

    }

    $_SESSION['venda_sucesso'] = true;
    header('Location: ./vendas.php');
    exit;

}

require 'form_vendas.php';


