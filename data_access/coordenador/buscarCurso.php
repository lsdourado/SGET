<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");
    $nome = $_POST['curso'];
    $consulta = "select * from curso where nome like '%$nome%'";
    $_SESSION['result_cursos'] = $mysqli->query($consulta) or die($mysqli->error);
?>
