<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    //FLUXO DA PRIMEIRA AVALIAÇÃO

    if($_POST['salvar_avaliacao_1']) {
      $id_avaliacao = filter_input(INPUT_POST, 'id_avaliacao_1', FILTER_SANITIZE_NUMBER_INT);
      $av_criterio_1 = $_POST['av_criterio_1'];
      $av_criterio_2 = $_POST['av_criterio_2'];
      $av_criterio_3 = $_POST['av_criterio_3'];
      $av_criterio_4 = $_POST['av_criterio_4'];
      $av_criterio_5 = $_POST['av_criterio_5'];
      $nota = $_POST['nota1'];
      $observacao = $_POST['observacao_avaliacao_1'];

      if(isset($_POST['check_encerrar_av_1'])) {
        $encerrar = true;
      }else{
        $encerrar = false;
      }

      $nota_orientacao = ($nota+$_SESSION['avaliacao_entrevista2']['nota_avaliacao'])/2;
    }

    //FLUXO DA SEGUNDA AVALIAÇÃO

    if($_POST['salvar_avaliacao_2']) {
      $id_avaliacao = filter_input(INPUT_POST, 'id_avaliacao_2', FILTER_SANITIZE_NUMBER_INT);
      $av_criterio_1 = $_POST['av2_criterio_1'];
      $av_criterio_2 = $_POST['av2_criterio_2'];
      $av_criterio_3 = $_POST['av2_criterio_3'];
      $av_criterio_4 = $_POST['av2_criterio_4'];
      $av_criterio_5 = $_POST['av2_criterio_5'];
      $nota = $_POST['nota2'];
      $observacao = $_POST['observacao_avaliacao_2'];

      if(isset($_POST['check_encerrar_av_2'])) {
        $encerrar = true;
      }else{
        $encerrar = false;
      }

      $nota_orientacao = ($nota+$_SESSION['avaliacao_entrevista1']['nota_avaliacao'])/2;

    }

    $consulta = "UPDATE avaliacao_entrevista SET encerrado='$encerrar', av_criterio_1='$av_criterio_1',
                av_criterio_2='$av_criterio_2', av_criterio_3='$av_criterio_3', av_criterio_4='$av_criterio_4',
                av_criterio_5='$av_criterio_5', nota='$nota', observacao='$observacao' WHERE id='$id_avaliacao'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $id_boletim = $_SESSION['boletim']['id'];

    $nota_final = ($nota_orientacao+$_SESSION['boletim']['nota_empresa']+$_SESSION['boletim']['nota_relatorio'])/3;

    $consulta = "UPDATE boletim SET nota_orientacao='$nota_orientacao', nota_final='$nota_final' WHERE id='$id_boletim'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
    header('Location: /estagio/view/menu.php?Pagina=gerenciarEstagio&id_gerenciar='.$_SESSION['id_gerenciar']);
?>
