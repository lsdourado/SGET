<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_acesso = $_SESSION['id_login'];

    $consulta = "select *,aluno.id as id_aluno,aluno.nome as nome_aluno,curso.nome as nome_curso,curso.tipo
                as tipo_curso from aluno inner join curso inner join endereco inner join
                acesso where aluno.id_curso = curso.id and aluno.id_endereco = endereco.id
                and aluno.id_acesso = acesso.id and id_acesso = '$id_acesso'";
    $_SESSION['result_alunos'] = $mysqli->query($consulta) or die($mysqli->error);
?>
