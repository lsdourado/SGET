<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_acesso = $_SESSION['id_login'];

    $consulta = "SELECT *,professor.id AS id_professor,professor.nome AS nome_professor
                FROM professor INNER JOIN endereco INNER JOIN acesso WHERE
                professor.id_endereco = endereco.id AND professor.id_acesso = acesso.id
                AND id_acesso = '$id_acesso'";
    $_SESSION['result_professores'] = $mysqli->query($consulta) or die($mysqli->error);
?>
