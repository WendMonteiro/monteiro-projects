<?php

require '../banco.php';

$cpf = $nome = $endereco = $bairro = $cidade = $telefone = "";
$cpf_erro = $nome_erro = $tel_erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //valida se o campo está vazio
    if (empty(trim($_POST['cpf']))) {
        $cpf_erro = "Informe o CPF do cliente!";
    } elseif (empty(trim($_POST["nome"]))) {
        $nome_erro = "Informe o nome do cliente!";
    } elseif (empty(trim($_POST['telefone']))) {
        $tel_erro = "Informe o número de contato!";
    } else {
        //validar se o usuario já está cadastrado e salvar na variavel
        $query = "SELECT id FROM ads_vendas.cliente WHERE cpf = :cpf";

        if($stmt = $pdo->prepare($query)) {
            $stmt->bindParam(":cpf", $param_cpf, PDO::PARAM_STR);
            $param_cpf = trim($_POST['cpf']);

            if($stmt->execute()){
                if($stmt->rowCount() == 1) {
                    $cpf_erro = "Cliente já tem cadastro!";
                } else {
                    $cpf = trim($_POST['cpf']);
                    $nome = trim($_POST['nome']);
                    $endereco = trim($_POST['endereco']);
                    $bairro = trim($_POST['bairro']);
                    $cidade = trim($_POST['cidade']);
                    $telefone = trim($_POST['telefone']);
                }
            } else {
                echo "Algo deu errado, tente novamente!";
            }
            unset($stmt);
        }
    }
//salvar no banco
    if(empty($cpf_erro) && empty($nome_erro) && empty($tel_erro)) {
        $query = "INSERT INTO cliente(cpf, nome, endereco, bairro, cidade, telefone) VALUES (:cpf, :nome, :endereco, :bairro, :cidade, :telefone)";

        $stmt = $pdo->prepare($query);
        $stmt ->execute([
            'cpf' => $cpf,
            'nome' => $nome,
            'endereco' => $endereco,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'telefone' => $telefone
        ]);

        header("location: ./cliente.php");
        exit;
    }

}

require './grvCliente.php';