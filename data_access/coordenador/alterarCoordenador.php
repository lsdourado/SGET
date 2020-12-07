<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_login = $_POST['id_login'];

    $nome = $_POST['nome_coordenador'];
    $email = $_POST['email_coordenador'];

    $consulta = "update coordenador set nome='$nome', email='$email'";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    $consulta = "update acesso set login='$email' where id='$id_login'";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";

    header('Location: ../../view/menu.php?Pagina=conf_acesso');
?>
