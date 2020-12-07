<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_estagio = filter_input(INPUT_POST, 'id_estagio', FILTER_SANITIZE_NUMBER_INT);

    if(isset($_POST['nota_relatorio_final'])){
      $nota = $_POST['nota_relatorio_final'];
    }else{
      $nota = null;
    }


    if(isset($_POST['check_encerrarRelatorio'])) {
      $encerrar = true;
    }else{
      $encerrar = false;
    }

    $consulta = "UPDATE relatorio_final SET encerrado='$encerrar', nota=$nota WHERE id_estagio='$id_estagio'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $nota_final = ($nota+$_SESSION['boletim']['nota_orientacao']+$_SESSION['boletim']['nota_empresa'])/3;

    $consulta = "UPDATE boletim SET nota_relatorio='$nota', nota_final='$nota_final' WHERE id_estagio='$id_estagio'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
    header('Location: /estagio/view/menu.php?Pagina=gerenciarEstagio&id_gerenciar='.$_SESSION['id_gerenciar']);
?>
