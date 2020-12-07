<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $nome = $_POST['professor'];

    $consulta = "select *,professor.id as id_professor,professor.nome as nome_professor
                from professor inner join endereco inner join
                acesso where professor.id_endereco = endereco.id
                and professor.id_acesso = acesso.id and professor.nome like '%$nome%'";
                
    $_SESSION['result_professores'] = $mysqli->query($consulta) or die($mysqli->error);
?>
