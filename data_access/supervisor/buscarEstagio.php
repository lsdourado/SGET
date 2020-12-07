<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $nome = $_POST['estagio'];

    $consulta = "select *, estagio.id as id_estagio, aluno.id as id_aluno, aluno.nome as nome_aluno,
                avaliacao_empresa.id as id_av_empresa, curso.id as id_curso, curso.nome as nome_curso from estagio
                inner join aluno inner join avaliacao_empresa inner join curso where estagio.id_aluno = aluno.id and
                avaliacao_empresa.id_estagio = estagio.id and aluno.id_curso = curso.id and
                estagio.id_supervisor ='$id_supervisor' and aluno.nome like '%$nome%'";

    $_SESSION['result_estagios'] = $mysqli->query($consulta) or die($mysqli->error);
?>
