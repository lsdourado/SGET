<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_gerenciar = @$_GET['id_gerenciar'];

    $consulta = "select * from primeira_entrevista where id_estagio='$id_gerenciar'";

    $_SESSION['result_primeiraEntrevista'] = $mysqli->query($consulta) or die($mysqli->error);
?>
