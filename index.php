<?php
require "./banco.php";

$usuario = $senha = "";
$usuario_erro = $senha_erro = $login_erro= "";

//VALIDA O METODO DE ENTRADA
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //verifica se o campo está vazio
    if(empty(trim($_POST["usuario"] ?? ""))){
        $usuario_erro = "Insira seu usuário";
    } else {
        $usuario = trim($_POST["usuario"]);
    }

    //verifica se o campo está vazio
    if(empty(trim($_POST["senha"]))){
        $senha_erro = "Informe a sua senha!";
    } else {
        $senha = trim($_POST["senha"]);
    }

    //validação de acesso
    if(empty($usuario_erro) && empty($senha_erro)) {
        $query = "SELECT * FROM usuarioConta WHERE usuario = :usuario";

        if($stmt = $pdo-> prepare($query)){
            $param_usuario = trim($_POST["usuario"]);
            $stmt->bindParam(":usuario", $param_usuario, PDO:: PARAM_STR);

            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $id = $row["id"];
                        $nomeUsuario = $row["nomeUsuario"];
                        $usuario = $row["usuario"];
                        $senha_cifrada = $row["senha"];
                        $tipo = $row["tipo"];

                        if($senha == $senha_cifrada) {
                            session_start();

                            $_SESSION["logado"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["nomeUsuario"] = $nomeUsuario;
                            $_SESSION["tipo"] = $tipo;

                            header("Location: ./menu.php");
                            exit;
                        } else {
                            $login_erro = "Usuário ou senha incorretos.Por favor, tente novamente!";
                        }
                    }
                } else {
                    $login_erro = "Conta não cadastrada!";
                }
            }
        }
    }
}

require "../AdsVendas/login/login.php";