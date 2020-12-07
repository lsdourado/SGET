<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$nome = filter_input(INPUT_POST, 'nome_professor', FILTER_SANITIZE_STRING);
$data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);
$sexo = filter_input(INPUT_POST, 'sexo_professor', FILTER_SANITIZE_STRING);
$siape = filter_input(INPUT_POST, 'siape', FILTER_SANITIZE_STRING);
$cidade = filter_input(INPUT_POST, 'cidade_professor', FILTER_SANITIZE_STRING);
$cep = filter_input(INPUT_POST, 'cep_professor', FILTER_SANITIZE_STRING);
$estado = filter_input(INPUT_POST, 'estado_professor', FILTER_SANITIZE_STRING);
$bairro = filter_input(INPUT_POST, 'bairro_professor', FILTER_SANITIZE_STRING);
$rua = filter_input(INPUT_POST, 'rua_professor', FILTER_SANITIZE_STRING);
$numero = filter_input(INPUT_POST, 'numero_endereco_professor', FILTER_SANITIZE_STRING);
$bairro = filter_input(INPUT_POST, 'bairro_professor', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email_professor', FILTER_SANITIZE_STRING);
$telefone = filter_input(INPUT_POST, 'telefone_professor', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha_professor', FILTER_SANITIZE_STRING);
$senha_confirm = filter_input(INPUT_POST, 'confirmar_senha_professor', FILTER_SANITIZE_STRING);

$login = str_replace(".","",$siape);
$login =  str_replace(",","",$login);
$login = str_replace("/","",$login);
$login = str_replace("-","",$login);

$consulta = "select * from professor where siape like '$siape'";

$result = $mysqli->query($consulta) or die($mysqli->error);

if($result->num_rows == 0){
  $consulta = "insert into acesso (tipo,login,senha) values ('professor','$login','$senha')";
  $result = $mysqli->query($consulta) or die($mysqli->error);

  if(mysqli_insert_id($mysqli)){
    $id_acesso = mysqli_insert_id($mysqli);

    $consulta = "insert into endereco (cidade,rua,bairro,numero,estado,cep) values ('$cidade','$rua','$bairro','$numero',
    '$estado','$cep')";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    if(mysqli_insert_id($mysqli)){
      $id_endereco = mysqli_insert_id($mysqli);

      $consulta = "insert into professor (nome,siape,data_nascimento,sexo,email,telefone,id_endereco,id_acesso)
      values ('$nome','$siape','$data_nascimento','$sexo','$email','$telefone','$id_endereco','$id_acesso')";
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
    $_SESSION['erro_cadastro']="Não foi possível efetuar o cadastro.";
  }

  mail($email,"Acesso ao sistema da Coord. Estágios","Olá ".$nome.", agora o Sistema de Gerenciamento de Estágios está acessível para você. Seu usuário é: ".$siape." e sua senha: ".$senha);
}else{
  $_SESSION['erro_cadastro']="O professor já existe.";
}

header('Location: ../../view/menu.php?Pagina=cadastrarProfessor');
?>
