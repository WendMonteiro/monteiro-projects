<?php

require '../banco.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    foreach ($_SESSION['carrinho'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['carrinho'][$key]);
            break;
        }
    }
}


header('Location: ./vendas.php');