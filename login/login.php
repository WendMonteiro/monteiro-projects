<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdsCaixa</title>
    <link rel="stylesheet" href="/AdsVendas/css/login.css">
</head>

<body>
    <div id="texto_info">
        <h1>Login</h1>
        <p style="font-weight: bold; margin-top:20px; font-size: 18px;">Faça login para acessar o sistema de vendas.</p>
        <p style="color: red; margin-top: 5px;">O acesso é restrito a usuários autorizados.</p>
    </div>

    <form id="login_container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <div id="input_container">
            <label for="usuario">Usuário</label>
            <input id="usuario" name="usuario" type="text" autocomplete="off">
            <span><?php echo $usuario_erro ?></span>

            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha">
            <span><?php echo $senha_erro ?></span>
        </div>
        <input id="submit" class="acessar" type="submit" value="Acessar">
    </form>

    <div class="alerta">
        <span style="color: red; align-items: center;"><?php echo $login_erro ?? "" ?></span>
    </div>

</body>

</html>