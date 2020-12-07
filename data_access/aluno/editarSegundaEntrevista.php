<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_entrevista = filter_input(INPUT_POST, 'id_entrevista', FILTER_SANITIZE_NUMBER_INT);
    $atv_desenvolvida = filter_input(INPUT_POST, 'atv_desenvolvida', FILTER_SANITIZE_STRING);
    $desc_treinamento = filter_input(INPUT_POST, 'desc_treinamento', FILTER_SANITIZE_STRING);
    $desc_dif_superada = filter_input(INPUT_POST, 'desc_dif_superada', FILTER_SANITIZE_STRING);
    $desc_nova_dificuldade = filter_input(INPUT_POST, 'desc_nova_dificuldade', FILTER_SANITIZE_STRING);
    $desc_acompanhamento = filter_input(INPUT_POST, 'desc_acompanhamento', FILTER_SANITIZE_STRING);
    $relacao = filter_input(INPUT_POST, 'relacao', FILTER_SANITIZE_STRING);
    $coment_aluno = filter_input(INPUT_POST, 'coment_aluno', FILTER_SANITIZE_STRING);

    if(isset($_POST['check_treinamento'])) {
      $treinamento = true;
    }else{
      $treinamento = false;
      $desc_treinamento = null;
    }

    if(isset($_POST['check_dif_superada'])) {
      $dif_superada = true;
    }else{
      $dif_superada = false;
      $desc_dif_superada = null;
    }

    if(isset($_POST['check_nova_dificuldade'])) {
      $nova_dificuldade = true;
    }else{
      $nova_dificuldade = false;
      $desc_nova_dificuldade = null;
    }

    if(isset($_POST['check_acompanhamento'])) {
      $acompanhamento = true;
    }else{
      $acompanhamento = false;
      $desc_acompanhamento = null;
    }

    $consulta = "update segunda_entrevista set atv_desenvolvida = '$atv_desenvolvida', desc_treinamento='$desc_treinamento',
                treinamento='$treinamento', desc_dificuldade_ant='$desc_dif_superada', dif_superada='$dif_superada',
                desc_nova_dificuldade='$desc_nova_dificuldade', nova_dificuldade='$nova_dificuldade',
                desc_acompanhamento='$desc_acompanhamento', acomp_mantido='$acompanhamento', desc_relacao='$relacao',
                coment_aluno='$coment_aluno' where id='$id_entrevista'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";

    header('Location: ../../view/menu.php?Pagina=entrevista_2');
?>
