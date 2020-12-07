<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_login = $_SESSION['id_login'];

    $consulta = "select * from acesso where id = '$id_login'";
    $_SESSION['result_login'] = $mysqli->query($consulta) or die($mysqli->error);
?>
