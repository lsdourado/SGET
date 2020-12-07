<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_boletim = filter_input(INPUT_POST, 'id_boletim', FILTER_SANITIZE_NUMBER_INT);
    $observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
    $nota_final = $_POST['nota_final'];

    if(isset($_POST['check_encerrarBoletim'])) {
      $encerrar = true;

      if($nota_final >= 7){
        $situacao = "Aprovado";
      }else{
        $situacao = "Reprovado";
      }
    }else{
      $encerrar = false;
      $situacao = null;
    }

    $consulta = "UPDATE boletim SET encerrado='$encerrar', observacao='$observacao', situacao='$situacao' WHERE id='$id_boletim'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    if($encerrar == true){
      $id_estagio = $_SESSION['$id_estagio'];

      $consulta = "UPDATE avaliacao_empresa SET encerrado='$encerrar' WHERE id_estagio='$id_estagio'";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      $consulta = "UPDATE avaliacao_entrevista SET encerrado='$encerrar' WHERE id_estagio='$id_estagio'";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      $consulta = "UPDATE entrevista_final SET encerrado='$encerrar' WHERE id_estagio='$id_estagio'";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      $consulta = "UPDATE plano_trabalho SET encerrado='$encerrar' WHERE id_estagio='$id_estagio'";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      $consulta = "UPDATE primeira_entrevista SET encerrado='$encerrar' WHERE id_estagio='$id_estagio'";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      $consulta = "UPDATE relatorio_final SET encerrado='$encerrar' WHERE id_estagio='$id_estagio'";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      $consulta = "UPDATE segunda_entrevista SET encerrado='$encerrar' WHERE id_estagio='$id_estagio'";
      $result = $mysqli->query($consulta) or die($mysqli->error);
    }

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
    header('Location: /estagio/view/menu.php?Pagina=gerenciarEstagio&id_gerenciar='.$_SESSION['id_gerenciar']);
?>
