<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $senha_token = $_POST['senha_token'];
    $id_supervisor = $_POST['id_supervisor'];

    $consulta = "select * from supervisor where byPass_token='$senha_token' and id='$id_supervisor'";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    if($result->num_rows == 0){
      $_SESSION['erro_login']="Senha do token é inválida";
    }else{
      $_SESSION['id_login']=$id_supervisor;
      $_SESSION['tipo_login']="supervisor";
    }

    header('Location: ../../view/supervisor/estagios.php');
?>
