<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$nome_supervisor = filter_input(INPUT_POST, 'nome_supervisor', FILTER_SANITIZE_STRING);
$num_reg_prof = filter_input(INPUT_POST, 'num_reg_prof', FILTER_SANITIZE_STRING);
$orgao_emissor = filter_input(INPUT_POST, 'orgao_emissor', FILTER_SANITIZE_STRING);
$cargo_supervisor = filter_input(INPUT_POST, 'cargo_supervisor', FILTER_SANITIZE_STRING);
$formacao_supervisor = filter_input(INPUT_POST, 'formacao_supervisor', FILTER_SANITIZE_STRING);
$email_supervisor = filter_input(INPUT_POST, 'email_supervisor', FILTER_SANITIZE_STRING);
$id_empresa = filter_input(INPUT_POST, 'empresa_supervisor', FILTER_SANITIZE_NUMBER_INT);

$byPass_token = strtolower($byPass_token);

$consulta = "select * from supervisor where num_reg_prof like '$num_reg_prof' and id_empresa='$id_empresa'";

$result = $mysqli->query($consulta) or die($mysqli->error);

if($result->num_rows == 0){
  $consulta = "INSERT INTO supervisor (nome,num_reg_prof,orgao_emissor,cargo,formacao,email,byPass_token,id_empresa) VALUES ('$nome_supervisor','$num_reg_prof','$orgao_emissor','$cargo_supervisor',
  '$formacao_supervisor','$email_supervisor','$byPass_token','$id_empresa')";
  $result = $mysqli->query($consulta) or die($mysqli->error);

  $id_supervisor = mysqli_insert_id($mysqli);

  $token = md5($id_supervisor);
  $tokenCrypt = md5($token);

  $consulta = "UPDATE supervisor SET token_acesso=md5('$tokenCrypt') where id='$id_supervisor'";
  $result = $mysqli->query($consulta) or die($mysqli->error);



  if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
    $url = 'https://'.$_SERVER['HTTP_HOST'].'/estagio/view/supervisor/estagios.php?token='.md5($tokenCrypt);
  }else{
  	$url = 'http://'.$_SERVER['HTTP_HOST'].'/estagio/view/supervisor/estagios.php?token='.md5($tokenCrypt);
  }

  mail($email,"Token de acesso - Coord. Estágios | IFBA","Olá ".$nome_supervisor.", Agora o Sistema de Gerenciamento de Estágios está acessível para você. Seu token de acesso é: ".$url." e sua senha: ".$byPass_token.". RECOMENDAMOS A ALTERAÇÃO DA SENHA NO PRIMEIRO ACESSO");

  $_SESSION['sucesso_cadastro']="Cadastro efetuado com sucesso.";
}else{
  $_SESSION['erro_cadastro']="O supervisor já existe na empresa selecionada.";
}

header('Location: ../../view/menu.php?Pagina=cadastrarSupervisor');
?>
