<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");
    $nome = $_POST['supervisor'];
    $consulta = "SELECT * FROM supervisor WHERE nome LIKE '%$nome%'";
    $_SESSION['result_supervisores'] = $mysqli->query($consulta) or die($mysqli->error);
?>
