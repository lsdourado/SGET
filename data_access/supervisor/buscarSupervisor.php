<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $token = $_SESSION['token'];

    $consulta = "select *,supervisor.id as id_supervisor, empresa.id as id_empresa,
                supervisor.nome as nome_supervisor, supervisor.email as email_supervisor,
                empresa.nome_fantasia as nome_empresa, empresa.email as email_empresa
                from supervisor inner join empresa where supervisor.id_empresa = empresa.id and
                supervisor.token_acesso='$token'";

    $_SESSION['result_supervisor'] = $mysqli->query($consulta) or die($mysqli->error);
?>
