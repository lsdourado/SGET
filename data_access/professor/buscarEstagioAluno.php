<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");
    $id_professor = $_SESSION['professor']['id_professor'];
    $id_gerenciar = @$_GET['id_gerenciar'];

    $consulta = "SELECT *, estagio.id AS id_estagio, estagio.id_professor AS id_professor_estagio,
                curso.id as id_curso, curso.nome as nome_curso,
                professor.nome AS nome_professor, estagio.id_empresa AS id_empresa_estagio, aluno.nome AS nome_aluno,
                empresa.nome_fantasia AS nome_fantasia_empresa, estagio.id_supervisor AS id_supervisor_estagio,
                supervisor.nome AS nome_supervisor FROM estagio INNER JOIN professor INNER JOIN empresa
                INNER JOIN curso 
                INNER JOIN supervisor INNER JOIN aluno WHERE estagio.id_professor = '$id_professor'
                AND estagio.id_aluno = aluno.id AND estagio.id_empresa = empresa.id AND
                estagio.id_supervisor = supervisor.id AND aluno.id_curso = curso.id AND estagio.id = '$id_gerenciar'";

    $_SESSION['result_estagios'] = $mysqli->query($consulta) or die($mysqli->error);
?>
