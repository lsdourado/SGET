<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $consulta = "select * from coordenador";

    $_SESSION['result_coordenador'] = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['result_coordenador'] = mysqli_fetch_assoc($_SESSION['result_coordenador']);
?>
