<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_entrevista = filter_input(INPUT_POST, 'id_entrevista', FILTER_SANITIZE_NUMBER_INT);
    $atv_desenvolvida = filter_input(INPUT_POST, 'atv_desenvolvida', FILTER_SANITIZE_STRING);
    $desc_treinamento = filter_input(INPUT_POST, 'desc_treinamento', FILTER_SANITIZE_STRING);
    $adaptacao = filter_input(INPUT_POST, 'adaptacao', FILTER_SANITIZE_STRING);
    $acompanhamento_emp = filter_input(INPUT_POST, 'acompanhamento_emp', FILTER_SANITIZE_STRING);
    $exec_trabalhos = filter_input(INPUT_POST, 'exec_trabalhos', FILTER_SANITIZE_STRING);
    $coment_aluno = filter_input(INPUT_POST, 'coment_aluno', FILTER_SANITIZE_STRING);

    if(isset($_POST['check_treinamento'])) {
      $treinamento = true;
    }else{
      $treinamento = false;
      $desc_treinamento = null;
    }

    $consulta = "update primeira_entrevista set atv_desenvolvida = '$atv_desenvolvida', desc_treinamento='$desc_treinamento',
                adaptacao='$adaptacao', acompanhamento_emp='$acompanhamento_emp', exec_trabalhos='$exec_trabalhos',
                coment_aluno='$coment_aluno', treinamento='$treinamento'
                where id='$id_entrevista'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";

    header('Location: ../../view/menu.php?Pagina=entrevista_1');
?>
