<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_entrevista = filter_input(INPUT_POST, 'id_entrevista', FILTER_SANITIZE_NUMBER_INT);
    $coment_professor = filter_input(INPUT_POST, 'coment_professor', FILTER_SANITIZE_STRING);

    if(isset($_POST['check_encerrarEntrevista2'])) {
      $encerrar = true;
    }else{
      $encerrar = false;
    }

    $consulta = "update segunda_entrevista set coment_professor='$coment_professor', encerrado='$encerrar'
                where id='$id_entrevista'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
    header('Location: /estagio/view/menu.php?Pagina=gerenciarEstagio&id_gerenciar='.$_SESSION['id_gerenciar']);
?>
