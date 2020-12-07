<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");
    $nome = $_POST['empresa'];
    $consulta = "SELECT *, empresa.id AS id_empresa FROM empresa INNER JOIN endereco
                WHERE empresa.id_endereco = endereco.id AND nome_fantasia LIKE '%$nome%'";
    $_SESSION['result_empresas'] = $mysqli->query($consulta) or die($mysqli->error);
?>
