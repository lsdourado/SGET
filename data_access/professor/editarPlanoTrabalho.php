<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_plano = filter_input(INPUT_POST, 'id_plano', FILTER_SANITIZE_NUMBER_INT);
    $crono_entrevista = filter_input(INPUT_POST, 'crono_entrevista', FILTER_SANITIZE_STRING);
    $instrumento_av = filter_input(INPUT_POST, 'instrumento_av', FILTER_SANITIZE_STRING);

    if(isset($_POST['check_encerrarPlano'])) {
      $encerrar = true;
    }else{
      $encerrar = false;
    }

    $consulta = "update plano_trabalho set crono_entrevista='$crono_entrevista',
                instrumento_av='$instrumento_av', encerrado='$encerrar' where id='$id_plano'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
    header('Location: /estagio/view/menu.php?Pagina=gerenciarEstagio&id_gerenciar='.$_SESSION['id_gerenciar']);
?>
