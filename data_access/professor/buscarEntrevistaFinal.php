<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_gerenciar = @$_GET['id_gerenciar'];

    $consulta = "select * from entrevista_final where id_estagio='$id_gerenciar'";

    $_SESSION['result_entrevistaFinal'] = $mysqli->query($consulta) or die($mysqli->error);
?>
