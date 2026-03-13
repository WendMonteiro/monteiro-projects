<?php

session_start();


define("USUARIO", "root");
define( "SENHA", "");
define("HOST", "localhost");
define("PORTA", "3307");
define("DBNAME", "ads_vendas");

try {
    $pdo = new PDO("mysql:host=".HOST.";port=".PORTA.";dbname=".DBNAME, USUARIO, SENHA);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Não foi possivel conectar." . $e->getMessage());
}


function recuperarTodosCliente($pdo) {
    $query = "SELECT * FROM ads_vendas.cliente";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Erro ao recuperar clientes: ". $e->getMessage());
    }
}

function recuperarCliente($pdo, $id) {
    $query = "SELECT * FROM ads_vendas.cliente WHERE id = :id";

    try {
        if($stmt = $pdo->prepare($query)){
            $param_id = $id;

            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            $stmt->execute();

            $cliente =  $stmt->fetch(PDO::FETCH_ASSOC);

            return $cliente;
        }
    } catch(PDOException $e) {
        die("Erro ao recuperar o cliente". $e->getMessage());
    }
}


function recuperarTodosProdutos($pdo) {
    $query = "SELECT * FROM ads_vendas.produto";

    try{
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao recuperar os produtos!". $e->getMessage());
    }
}

function recuperarProduto ($pdo, $id) {
    $query = "SELECT * FROM ads_vendas.produto WHERE id = :id";

    try {
        if($stmt = $pdo->prepare($query)) {
            $param_id = $id;

            $stmt -> bindParam(":id", $param_id, PDO::PARAM_INT);
            $stmt->execute();

            $produtos = $stmt->fetch(PDO::FETCH_ASSOC);

            return $produtos;

        }
    } catch (PDOException $e) {
        die("Erro ao encontrar o produto". $e->getMessage());
    }
}



function removerItens ($pdo, $id) {
    $query = "DELETE FROM ads_vendas.produto WHERE id = :id";

    try{
        if($stmt = $pdo->prepare($query)) {
            $param_id = $id;
            
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        die("ERROR: Não foi possivel remover o item!" . $e->getMessage());
    }
}


function buscarPrecoProduto ($pdo, $id) {
    $query = "SELECT preco FROM ads_vendas.produto WHERE id = :id";

    try{
        if($stmt = $pdo->prepare($query)) {
            $param_id = $id;
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            $stmt->execute();

            $row =  $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['preco'] : 0;

        }
    }catch (PDOException $e) {
        die("ERROR: Não foi possivel achar o preço!" . $e->getMessage());
    }
}

/*function recuperarPedidoPorVendedor($pdo, $id_usuario) {
    $query = "SELECT * FROM ads_vendas.vendas WHERE id = :id" ;

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id', $id_usuario);
        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao recuperar pedidos!". $e->getMessage());
    }
}*/

function recuperarPedidoPorVendedor($pdo, $id_usuario) {
  $query = "SELECT v.*, c.nome AS nome_cliente 
            FROM ads_vendas.vendas v 
            JOIN ads_vendas.cliente c ON v.id_cliente = c.id 
            WHERE v.id_usuario = :id_usuario";
  try {
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id_usuario', $id_usuario);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    die("Erro ao recuperar pedidos! ". $e->getMessage());
  }
}

function recuperarPedidoComItens($pdo, $id_pedido) {
    $query = "SELECT v.id AS id_pedido, v.data_venda, v.tipo_venda, c.nome AS nome_cliente,
                     iv.id AS id_item, iv.id_produto, p.nome_produto, iv.quantidade, p.preco
              FROM vendas v
              JOIN cliente c ON v.id_cliente = c.id
              JOIN itens_vendas iv ON v.id = iv.id_venda
              JOIN produto p ON iv.id_produto = p.id
              WHERE v.id = :id_pedido
              ORDER BY iv.id";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_pedido', $id_pedido);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao recuperar pedidos e itens! ". $e->getMessage());
    }
}