<?php
    require "./banco.php";

    if(!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true){
        header("location:./login.php");
        exit;
    }

    //permissoes
    /*if($_SESSION['tipo'] == 1 ) {
       echo '<style> #venda_menu { display: none} </style>';
    }*/

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial</title>
    <link rel="stylesheet" href="/AdsVendas/css/menu.css">
</head>



<body>
    <div id="head_menu">
        <h1>Ads Vendas</h1>
        <a id="sair" href="/AdsVendas/login/sair.php"><img width="50px" src="/AdsVendas/imagens/sair.png" alt=""><br>sair</a>
    </div>

    <div id="menu_container" >
        <a id="venda_menu" class="link" href="./vendas/vendas.php"><img class="menuOpcoes" src="/AdsVendas/imagens/comprar.png" alt="vendas"><br>Vendas</a>
        <a id="cliente_menu" class="link" href="./Cliente/cliente.php"><img class="menuOpcoes" src="/AdsVendas/imagens/adicionar-usuario.png" alt="Cliente"><br>Cliente</a>
        <a id="pedidos_menu" class="link" href="./pedido.php?id=<?php echo $_SESSION['id'];?>"><img class="menuOpcoes" src="/AdsVendas/imagens/pedido.png" alt="Pedido"><br>Pedidos</a>
        <a id="estoque_menu" class="link" href="./estoque/estoque.php"><img class="menuOpcoes" src="/AdsVendas/imagens/inventario.png" alt="estoque"><br>Estoque</a>
    </div>

</body>

</html>

