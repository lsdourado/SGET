<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $consulta = "truncate coordenador";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    $consulta = "update acesso set login='admin', senha='admin' where tipo='coordenador'";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    session_destroy();
    unset($_SESSION);

    header('Location: ../../index.php');

    exit;

?>
