<?php
    @session_start();
    include_once("../connection/ConnectionFactory.php");

    $id_estagio = $_SESSION['estagio']['id_estagio'];

    if(isset($_SESSION['primeira_entrevista'])){
      $id_entrevista = $_SESSION['primeira_entrevista'];

      $consulta = "select *,avaliacao_entrevista.id as id_avaliacao, primeira_entrevista.id as id_entrevista
                  from avaliacao_entrevista inner join primeira_entrevista where
                  primeira_entrevista.id_av_entrevista = avaliacao_entrevista.id and
                  primeira_entrevista.id = '$id_entrevista'";

      $_SESSION['result_avaliacao_1'] = $mysqli->query($consulta) or die($mysqli->error);
    }

    if(isset($_SESSION['segunda_entrevista'])){
      $id_entrevista = $_SESSION['segunda_entrevista'];

      $consulta = "select *,avaliacao_entrevista.id as id_avaliacao, segunda_entrevista.id as id_entrevista
                  from avaliacao_entrevista inner join segunda_entrevista where
                  segunda_entrevista.id_av_entrevista = avaliacao_entrevista.id and
                  segunda_entrevista.id = '$id_entrevista'";

      $_SESSION['result_avaliacao_2'] = $mysqli->query($consulta) or die($mysqli->error);
    }
?>
