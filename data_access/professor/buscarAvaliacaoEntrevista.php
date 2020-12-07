<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_gerenciar = @$_GET['id_gerenciar'];

    $consulta = "SELECT *,avaliacao_entrevista.id AS id_avaliacao, primeira_entrevista.id AS id_entrevista,
                avaliacao_entrevista.encerrado as av_encerrado, avaliacao_entrevista.nota as nota_avaliacao
                FROM avaliacao_entrevista INNER JOIN primeira_entrevista WHERE
                primeira_entrevista.id_av_entrevista = avaliacao_entrevista.id AND
                primeira_entrevista.id_estagio = '$id_gerenciar'";

    $_SESSION['result_avaliacao_1'] = $mysqli->query($consulta) or die($mysqli->error);


    $consulta = "SELECT *,avaliacao_entrevista.id AS id_avaliacao, segunda_entrevista.id AS id_entrevista,
                avaliacao_entrevista.encerrado as av_encerrado, avaliacao_entrevista.nota as nota_avaliacao
                FROM avaliacao_entrevista INNER JOIN segunda_entrevista WHERE
                segunda_entrevista.id_av_entrevista = avaliacao_entrevista.id AND
                segunda_entrevista.id_estagio = '$id_gerenciar'";

    $_SESSION['result_avaliacao_2'] = $mysqli->query($consulta) or die($mysqli->error);
?>
