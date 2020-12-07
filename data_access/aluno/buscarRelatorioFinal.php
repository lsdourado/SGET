<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_estagio = $_SESSION['estagio']['id_estagio'];

    $consulta = "select * from relatorio_final where id_estagio='$id_estagio'";

    $_SESSION['result_relatorio'] = $mysqli->query($consulta) or die($mysqli->error);
?>
