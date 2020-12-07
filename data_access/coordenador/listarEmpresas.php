<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $consulta = "SELECT *, empresa.id AS id_empresa FROM empresa INNER JOIN endereco
                WHERE empresa.id_endereco = endereco.id";
    $_SESSION['result_empresas'] = $mysqli->query($consulta) or die($mysqli->error);
?>
