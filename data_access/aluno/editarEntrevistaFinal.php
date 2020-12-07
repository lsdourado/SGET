<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_entrevista = filter_input(INPUT_POST, 'id_entrevista', FILTER_SANITIZE_NUMBER_INT);
    $av_estagio_1 = filter_input(INPUT_POST, 'av_estagio_1', FILTER_SANITIZE_NUMBER_FLOAT);
    $av_estagio_2 = filter_input(INPUT_POST, 'av_estagio_2', FILTER_SANITIZE_NUMBER_FLOAT);
    $av_estagio_3 = filter_input(INPUT_POST, 'av_estagio_3', FILTER_SANITIZE_NUMBER_FLOAT);
    $av_estagio_4 = filter_input(INPUT_POST, 'av_estagio_4', FILTER_SANITIZE_NUMBER_FLOAT);
    $av_estagio_5 = filter_input(INPUT_POST, 'av_estagio_5', FILTER_SANITIZE_NUMBER_FLOAT);
    $av_empresa_1 = filter_input(INPUT_POST, 'av_empresa_1', FILTER_SANITIZE_NUMBER_FLOAT);
    $av_empresa_2 = filter_input(INPUT_POST, 'av_empresa_2', FILTER_SANITIZE_NUMBER_FLOAT);
    $av_empresa_3 = filter_input(INPUT_POST, 'av_empresa_3', FILTER_SANITIZE_NUMBER_FLOAT);
    $av_empresa_4 = filter_input(INPUT_POST, 'av_empresa_4', FILTER_SANITIZE_NUMBER_FLOAT);
    $av_empresa_5 = filter_input(INPUT_POST, 'av_empresa_5', FILTER_SANITIZE_NUMBER_FLOAT);
    $coment = filter_input(INPUT_POST, 'coment', FILTER_SANITIZE_STRING);

    if(isset($_POST['check_encerrar'])) {
      $encerrado = true;
    }else{
      $encerrado = false;
    }

    $consulta = "update entrevista_final set av_estagio_1='$av_estagio_1', av_estagio_2='$av_estagio_2',
                av_estagio_3='$av_estagio_3', av_estagio_4='$av_estagio_4', av_estagio_5='$av_estagio_5',
                av_empresa_1='$av_empresa_1', av_empresa_2='$av_empresa_2', av_empresa_3='$av_empresa_3',
                av_empresa_4='$av_empresa_4', av_empresa_5='$av_empresa_5', coment='$coment', encerrado='$encerrado'
                where id='$id_entrevista'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";

    header('Location: ../../view/menu.php?Pagina=entrevista_final');
?>
