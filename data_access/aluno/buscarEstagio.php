<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_aluno = $_SESSION['aluno']['id_aluno'];

    $consulta = "SELECT *, estagio.id AS id_estagio, estagio.id_professor AS id_professor_estagio, professor.nome AS nome_professor,
                estagio.id_empresa AS id_empresa_estagio, empresa.nome_fantasia AS nome_fantasia_empresa,
                estagio.id_supervisor AS id_supervisor_estagio, supervisor.nome AS nome_supervisor
                FROM estagio INNER JOIN professor INNER JOIN empresa INNER JOIN supervisor
                WHERE estagio.id_aluno = '$id_aluno' AND estagio.id_professor = professor.id AND
                estagio.id_empresa = empresa.id AND estagio.id_supervisor = supervisor.id";

    $_SESSION['result_estagios'] = $mysqli->query($consulta) or die($mysqli->error);
?>
