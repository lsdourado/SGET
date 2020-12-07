<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_entrevista = filter_input(INPUT_POST, 'id_entrevista', FILTER_SANITIZE_NUMBER_INT);
    $desc_empresa = filter_input(INPUT_POST, 'desc_empresa', FILTER_SANITIZE_STRING);
    $desc_atividade = filter_input(INPUT_POST, 'desc_atividade', FILTER_SANITIZE_STRING);
    $conclusao = filter_input(INPUT_POST, 'conclusao', FILTER_SANITIZE_STRING);

    $consulta = "update relatorio_final set desc_empresa='$desc_empresa', desc_atividade='$desc_atividade', conclusao='$conclusao'
                where id='$id_entrevista'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";

    header('Location: ../../view/menu.php?Pagina=relatorio_final');
?>
