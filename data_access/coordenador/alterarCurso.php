<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_curso = filter_input(INPUT_POST, 'id_curso', FILTER_SANITIZE_NUMBER_INT);
    $nome_curso = filter_input(INPUT_POST, 'nome_curso', FILTER_SANITIZE_STRING);
    $tipo_curso = filter_input(INPUT_POST, 'tipo_curso', FILTER_SANITIZE_STRING);

    $consulta = "update curso set nome = '$nome_curso', tipo='$tipo_curso' where id = $id_curso";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
    header('Location: ../../view/menu.php?Pagina=cursos');
?>
