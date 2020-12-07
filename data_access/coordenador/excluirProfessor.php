<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id = @$_GET['id'];

    $consulta = "select * from estagio where id_professor='$id'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    if($result->num_rows == 0){
      $consulta = "delete from professor where id='$id'";

      $result = $mysqli->query($consulta) or die($mysqli->error);
    }else{
      $_SESSION['erro_excluir']="Não foi possível excluir o professor.";
    }

    header('Location: ../../view/menu.php?Pagina=professores');
?>
