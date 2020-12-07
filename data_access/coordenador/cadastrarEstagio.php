<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$id_aluno = filter_input(INPUT_POST, 'estagio_aluno', FILTER_SANITIZE_STRING);
$id_professor = filter_input(INPUT_POST, 'estagio_professor', FILTER_SANITIZE_STRING);
$id_empresa = filter_input(INPUT_POST, 'estagio_empresa', FILTER_SANITIZE_STRING);
$id_supervisor = filter_input(INPUT_POST, 'estagio_supervisor', FILTER_SANITIZE_STRING);
$data_inicio = filter_input(INPUT_POST, 'data_inicio', FILTER_SANITIZE_STRING);
$data_fim = filter_input(INPUT_POST, 'data_fim', FILTER_SANITIZE_STRING);
$carga_semanal = filter_input(INPUT_POST, 'carga_semanal', FILTER_SANITIZE_STRING);
$horario_inicio = filter_input(INPUT_POST, 'horario_inicio', FILTER_SANITIZE_STRING);
$horario_fim = filter_input(INPUT_POST, 'horario_fim', FILTER_SANITIZE_STRING);
$apolice_seguro = filter_input(INPUT_POST, 'apolice_seguro', FILTER_SANITIZE_STRING);
$nome_seguradora = filter_input(INPUT_POST, 'nome_seguradora', FILTER_SANITIZE_STRING);
$valor_seguro = filter_input(INPUT_POST, 'valor_seguro', FILTER_SANITIZE_STRING);
$bolsa_auxilio = filter_input(INPUT_POST, 'bolsa_auxilio', FILTER_SANITIZE_STRING);
$auxilio_transporte = filter_input(INPUT_POST, 'auxilio_transporte', FILTER_SANITIZE_STRING);
if(isset($_POST['obrigatorio'])) {
  $obrigatorio = true;
}else{
  $obrigatorio = false;
}

$consulta = "select * from estagio where id_aluno='$id_aluno' and id_empresa='$id_empresa' and data_inicio like '$data_inicio' and data_fim like '$data_fim'";

$result = $mysqli->query($consulta) or die($mysqli->error);

if($result->num_rows == 0){
  $consulta = "INSERT INTO estagio (id_aluno,id_professor,id_empresa,id_supervisor,data_inicio,data_fim,
              carga_semanal,horario_inicio,horario_fim,apolice_seguro,nome_seguradora,valor_seguro,
              bolsa_auxilio,auxilio_transporte, obrigatorio) VALUES ('$id_aluno','$id_professor','$id_empresa',
              '$id_supervisor','$data_inicio','$data_fim','$carga_semanal','$horario_inicio',
              '$horario_fim','$apolice_seguro','$nome_seguradora','$valor_seguro','$bolsa_auxilio',
              '$auxilio_transporte', '$obrigatorio')";
  $result = $mysqli->query($consulta) or die($mysqli->error);
  $_SESSION['id_estagio'] = mysqli_insert_id($mysqli);

  if(mysqli_insert_id($mysqli)){
    $id_estagio = mysqli_insert_id($mysqli);
    $consulta = "INSERT INTO avaliacao_empresa (id_estagio) VALUES ('$id_estagio')";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    $id_av_empresa = mysqli_insert_id($mysqli);

    $consulta = "INSERT INTO avaliacao_entrevista (id_estagio) VALUES ('$id_estagio')";
    $result = $mysqli->query($consulta) or die($mysqli->error);
    if(mysqli_insert_id($mysqli)){
      $id_entrevista1 = mysqli_insert_id($mysqli);
      $consulta = "INSERT INTO primeira_entrevista (id_estagio, id_av_entrevista) VALUES ('$id_estagio','$id_entrevista1')";
      $result = $mysqli->query($consulta) or die($mysqli->error);
      $id_primeira_entrevista = mysqli_insert_id($mysqli);
    }else{
      $_SESSION['erro_cadastro']="Não foi possível efetuar o cadastro.";
    }

    $consulta = "INSERT INTO avaliacao_entrevista (id_estagio) VALUES ('$id_estagio')";
    $result = $mysqli->query($consulta) or die($mysqli->error);
    if(mysqli_insert_id($mysqli)){
      $id_entrevista2 = mysqli_insert_id($mysqli);
      $consulta = "INSERT INTO segunda_entrevista (id_estagio, id_av_entrevista) VALUES ('$id_estagio','$id_entrevista2')";
      $result = $mysqli->query($consulta) or die($mysqli->error);
      $id_segunda_entrevista = mysqli_insert_id($mysqli);
    }else{
      $_SESSION['erro_cadastro']="Não foi possível efetuar o cadastro.";
    }

    $consulta = "INSERT INTO boletim (id_estagio,id_entrevista_1,id_entrevista_2,id_av_empresa) VALUES ('$id_estagio','$id_primeira_entrevista',
                '$id_segunda_entrevista','$id_av_empresa')";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    $consulta = "INSERT INTO entrevista_final (id_estagio) VALUES ('$id_estagio')";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    $consulta = "INSERT INTO plano_trabalho (id_estagio) VALUES ('$id_estagio')";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    $consulta = "INSERT INTO relatorio_final (id_estagio) VALUES ('$id_estagio')";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    if(mysqli_insert_id($mysqli)){
      $_SESSION['sucesso_cadastro']="Cadastro efetuado com sucesso.";
    }else{
      $_SESSION['erro_cadastro']="Não foi possível efetuar o cadastro.";
    }
  }else{
    $_SESSION['erro_cadastro']="Não foi possível efetuar o cadastro.";
  }
}else{
  $_SESSION['erro_cadastro']="O estágio já existe.";
}

header('Location: ../../view/menu.php?Pagina=cadastrarEstagio');
?>
