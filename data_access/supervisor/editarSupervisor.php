<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_supervisor = $_POST['id_supervisor'];

    if(isset($_POST['editar_email'])){
      $email = $_POST['email'];

      $consulta = "update supervisor set email='$email' where id = '$id_supervisor'";
      $result = $mysqli->query($consulta) or die($mysqli->error);
    }else{
      $nova_senha = $_POST['nova_senha'];

      $consulta = "update supervisor set byPass_token = '$nova_senha' where id = '$id_supervisor'";
      $result = $mysqli->query($consulta) or die($mysqli->error);
    }



    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
    header('Location: ../../view/supervisor/estagios.php');
?>
