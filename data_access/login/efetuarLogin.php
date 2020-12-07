<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    $consulta = "select * from acesso where login = '$usuario' and senha = '$senha'";
    $result = $mysqli->query($consulta) or die($mysqli->error);
    $tam_consulta = mysqli_num_rows($result);


    if($tam_consulta > 0){
        $linha = mysqli_fetch_assoc($result);
        $_SESSION['id_login'] = $linha['id'];
        $_SESSION['tipo_login'] = $linha['tipo'];

        if($linha['tipo']=="aluno"){
          $consulta = "select id from aluno where id_acesso = '$id_acesso'";
          $result = $mysqli->query($consulta) or die($mysqli->error);
          $linha = mysqli_fetch_assoc($result);

          $_SESSION['id_usuario']=$linha['id'];
        }elseif($linha['tipo']=="professor"){
          $consulta = "select id from professor where id_acesso = '$id_acesso'";
          $result = $mysqli->query($consulta) or die($mysqli->error);
          $linha = mysqli_fetch_assoc($result);

          $_SESSION['id_usuario']=$linha['id'];
        }

        if($linha['tipo']=="supervisor"){
          header('Location: ../../view/supervisor/estagios.php');
        }else{
          header('Location: ../../view/menu.php');
        }
    }else{
        $_SESSION['erro_login'] = "Usuário ou senha incorretos.";
        header('Location: ../../index.php');
    }
?>
