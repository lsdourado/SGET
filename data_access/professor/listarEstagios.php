<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_professor = $_SESSION['professor']['id_professor'];

    $consulta = "SELECT *, estagio.id as id_estagio, professor.id as id_professor_estagio, curso.id as id_curso,
                empresa.id as id_empresa_estagio, supervisor.id as id_supervisor_estagio, curso.nome as nome_curso,
                aluno.id as id_aluno, empresa.nome_fantasia as nome_fantasia_empresa, aluno.nome as nome_aluno,
                professor.nome as nome_professor, supervisor.nome as nome_supervisor FROM estagio
                INNER JOIN aluno INNER JOIN curso INNER JOIN professor INNER JOIN supervisor INNER JOIN empresa WHERE
                estagio.id_aluno = aluno.id AND estagio.id_supervisor = supervisor.id AND aluno.id_curso = curso.id AND 
                estagio.id_professor = professor.id AND estagio.id_empresa = empresa.id AND
                estagio.id_professor = '$id_professor'";

    $_SESSION['result_estagios'] = $mysqli->query($consulta) or die($mysqli->error);
?>
