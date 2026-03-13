<?php

require '../banco.php';

$cod_barras = $forn = $produto = $descricao = $preco = $quant = "";
$cod_barras_erro = $forn_erro = $produto_erro = $descricao_erro = $preco_erro = $qtd_erro = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //valida se o campo esta vazio
    if(empty(trim($_POST['cod_barras']))) {
        $cod_barras_erro = "Insirar o código de barras do produto!";
    } elseif(empty(trim($_POST['fornecedor']))) {
        $forn_erro = "Insirar o fornecedor";
    } elseif(empty(trim($_POST['nome_produto']))) {
        $produto_erro = "insirar o nome do produto!";
    } elseif(empty(trim($_POST['descricao']))) {
        $descricao_erro = "Insirar a descrição do produto";
    } elseif(empty(trim($_POST['preco']))) {
        $preco_erro = "Produto sem precificação!";
    } elseif(empty(trim($_POST['quant']))) {
        $qtd_erro = "Informar a quantidade total do item!";
    } else {
        $query = "SELECT id FROM ads_vendas.produto WHERE cod_barras = :cod_barras";

        if($stmt = $pdo->prepare($query)) {
            $stmt->bindParam(":cod_barras", $param_barras, PDO::PARAM_STR);
            $param_barras =trim($_POST['cod_barras']);

            if($stmt->execute()) {
                if($stmt->rowCount() == 1) {
                    $cod_barras_erro = "código de barras já cadastrado!";
                } else {
                    $cod_barras = trim($_POST['cod_barras']);
                    $forn = trim($_POST['fornecedor']);
                    $produto = trim($_POST['nome_produto']);
                    $descricao = trim($_POST['descricao']);
                    $preco = trim($_POST['preco']);
                    $quant = trim($_POST['quant']);
                }
            } else {
                echo "Algo deu errado, tente novamente!";
            }
            unset($stmt);
        }
    }

    if(empty($forn_erro) && empty($produto_erro) && empty($preco_erro) && empty($qtd_erro)) {
        $query = "INSERT INTO produto (cod_barras, fornecedor, nome_produto, descricao, preco, quant) VALUES (:cod_barras, :fornecedor, :nome_produto, :descricao, :preco, :quant)";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'cod_barras' => $cod_barras,
            'fornecedor' => $forn,
            'nome_produto' => $produto,
            'descricao' => $descricao,
            'preco' => $preco,
            'quant' => $quant
        ]);

        header("Location: ./estoque.php");
        exit;
    }
}

require 'formProduto.php';
