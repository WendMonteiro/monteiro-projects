<?php
require '../banco.php';

$clientes = recuperarTodosCliente($pdo);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
    <link rel="stylesheet" href="/AdsVendas/css/cliente.css">
    <script></script>
</head>

<body>
    <div id="head_cliente">
        <h1>Cliente</h1>
        <a id="voltar" href="/AdsVendas/menu.php"><img width="30px" src="/AdsVendas/imagens/voltar.png" alt=""><br></a>
        <a class="novo" href="./criarCliente.php">Criar Novo Cliente</a>
        <a class="novoCelular" href="./criarCliente.php">+Cliente</a>
    </div>

    <div id="form_container">
        <input type="text" class="busca" id="busca" placeholder="Buscar Cliente..." onkeyup="buscarCliente()">
        <table id="tabela_clientes">
            
            <tr>
                <th>CPF</th>
                <th>Nome</th>
                <th class="celular">Endereço</th>
                <th class="celular">Bairro</th>
                <th class="celular">Cidade</th>
                <th class="celular">telefone</th>
                <th class="pc">detalhes</th>
            </tr>
            <?php foreach ($clientes as $cliente) : ?>
            <tr>
                <td><?php echo $cliente['cpf']?></td>
                <td><?php echo $cliente['nome']?></td>
                <td class="celular"><?php echo $cliente['endereco']?></td>
                <td class="celular"><?php echo $cliente['bairro']?></td>
                <td class="celular"><?php echo $cliente['cidade']?></td>
                <td class="celular"><?php echo $cliente['telefone']?></td>
                <td class="pc"><a href="./detalhesCliente.php?id=<?php echo $cliente['id'];?>"> <img width="25px" src="/AdsVendas/imagens/detalhes.png" alt="detalhes"></a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>


    <script>
        function buscarCliente() {
            let input = document.getElementById("busca").value.toUpperCase();
            let tabela = document.getElementById("tabela_clientes");
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
