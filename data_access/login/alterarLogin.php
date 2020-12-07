<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_login = $_POST['id_login'];

    $nova_senha = $_POST['nova_senha'];

    $consulta = "update acesso set senha = '$nova_senha' where id = '$id_login'";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    if(isset($_SESSION['primeiro_login'])){
      $nome = $_POST['nome_coordenador'];
      $email = $_POST['email_coordenador'];

      $consulta = "insert coordenador set nome='$nome', email='$email'";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      $consulta = "update acesso set login='$email' where id='$id_login'";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      unset($_SESSION['primeiro_login']);

      header('Location: ../../view/menu.php?Pagina=instituicao');
    }else{
      $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";

      header('Location: ../../view/menu.php?Pagina=conf_acesso');
    }
?>
