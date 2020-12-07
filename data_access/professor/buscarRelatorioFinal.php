<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_gerenciar = @$_GET['id_gerenciar'];

    $consulta = "select * from relatorio_final where id_estagio='$id_gerenciar'";

    $_SESSION['result_relatorio'] = $mysqli->query($consulta) or die($mysqli->error);
?>
