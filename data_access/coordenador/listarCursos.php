<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $consulta = "select * from curso";
    $_SESSION['result_cursos'] = $mysqli->query($consulta) or die($mysqli->error);
?>
