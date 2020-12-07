<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $consulta = "SELECT *, supervisor.id AS id_supervisor, empresa.id AS id_empresa, supervisor.email as
                email_supervisor FROM supervisor INNER JOIN empresa WHERE
                  supervisor.id_empresa = empresa.id";
    $_SESSION['result_supervisores'] = $mysqli->query($consulta) or die($mysqli->error);
?>
