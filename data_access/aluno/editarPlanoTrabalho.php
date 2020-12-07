<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_plano = filter_input(INPUT_POST, 'id_plano', FILTER_SANITIZE_NUMBER_INT);
    $objetivos = filter_input(INPUT_POST, 'objetivos', FILTER_SANITIZE_STRING);
    $atividades = filter_input(INPUT_POST, 'atividades', FILTER_SANITIZE_STRING);
    $crono_entrevista = filter_input(INPUT_POST, 'crono_entrevista', FILTER_SANITIZE_STRING);
    $instrumento_av = filter_input(INPUT_POST, 'instrumento_av', FILTER_SANITIZE_STRING);

    $consulta = "update plano_trabalho set objetivo='$objetivos', atividade='$atividades', crono_entrevista='$crono_entrevista',
                instrumento_av='$instrumento_av' where id='$id_plano'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
    header('Location: ../../view/menu.php?Pagina=plano_aluno');
?>
