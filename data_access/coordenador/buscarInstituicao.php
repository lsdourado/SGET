<?php
    @session_start();

    if(isset($_SESSION['token'])){
      include_once("../../connection/ConnectionFactory.php");
    }else{
      include_once("../connection/ConnectionFactory.php");
    }


    $consulta = "SELECT *,instituicao.id AS id_instituicao, endereco.id as id_endereco, endereco.cidade AS
                cidade_endereco, endereco.rua AS rua_endereco, endereco.bairro AS bairro_endereco, endereco.numero
                AS numero_endereco, endereco.estado AS estado_endereco, endereco.cep AS cep_endereco FROM instituicao
                INNER JOIN endereco WHERE instituicao.id_endereco = endereco.id";


    $_SESSION['result_instituicao'] = $mysqli->query($consulta) or die($mysqli->error);
?>
