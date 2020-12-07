<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $id_avaliacao = filter_input(INPUT_POST, 'id_av_empresa', FILTER_SANITIZE_NUMBER_INT);
    $id_estagio = filter_input(INPUT_POST, 'id_estagio', FILTER_SANITIZE_NUMBER_INT);
    $av_pro_1 = $_POST['av_profissional_1'];
    $av_pro_2 = $_POST['av_profissional_2'];
    $av_pro_3 = $_POST['av_profissional_3'];
    $av_pro_4 = $_POST['av_profissional_4'];
    $av_pro_5 = $_POST['av_profissional_5'];
    $nota_pro = $_POST['notaPro'];
    $av_hum_1 = $_POST['av_humano_1'];
    $av_hum_2 = $_POST['av_humano_2'];
    $av_hum_3 = $_POST['av_humano_3'];
    $av_hum_4 = $_POST['av_humano_4'];
    $av_hum_5 = $_POST['av_humano_5'];
    $nota_humano = $_POST['notaHum'];
    $nota_empresa = $_POST['notaFinal'];
    $observacao = $_POST['observacao'];

    if(isset($_POST['check_encerrar'])) {
      $encerrar = true;
    }else{
      $encerrar = false;
    }


    $consulta = "UPDATE avaliacao_empresa SET av_profissional_1='$av_pro_1', av_profissional_2='$av_pro_2',
                av_profissional_3='$av_pro_3', av_profissional_4='$av_pro_4', av_profissional_5='$av_pro_5',
                av_humano_1='$av_hum_1', av_humano_2='$av_hum_2', av_humano_3='$av_hum_3', av_humano_4='$av_hum_4',
                av_humano_5='$av_hum_5', nota_profissional='$nota_pro', nota_humano='$nota_humano',
                nota_final='$nota_empresa', observacao='$observacao', encerrado='$encerrar' where id='$id_avaliacao'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $consulta = "SELECT * FROM boletim WHERE id_estagio = '$id_estagio'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $boletim = mysqli_fetch_assoc($result);

    $id_boletim = $boletim['id'];
    $nota_final = ($boletim['nota_orientacao']+$nota_empresa+$boletim['nota_relatorio'])/3;

    $consulta = "UPDATE boletim SET nota_empresa='$nota_empresa', nota_final='$nota_final' WHERE id='$id_boletim'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    $_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
    header('Location: ../../view/supervisor/estagios.php');
?>
