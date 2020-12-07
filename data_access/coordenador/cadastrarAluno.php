<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$nome = filter_input(INPUT_POST, 'nome_aluno', FILTER_SANITIZE_STRING);
$rg = filter_input(INPUT_POST, 'rg_aluno', FILTER_SANITIZE_STRING);
$cpf = filter_input(INPUT_POST, 'cpf_aluno', FILTER_SANITIZE_STRING);
$data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);
$sexo = filter_input(INPUT_POST, 'sexo_aluno', FILTER_SANITIZE_STRING);
$matricula = filter_input(INPUT_POST, 'matricula_aluno', FILTER_SANITIZE_STRING);
$id_curso = filter_input(INPUT_POST, 'curso_aluno', FILTER_SANITIZE_NUMBER_INT);
$periodo = filter_input(INPUT_POST, 'periodo_aluno', FILTER_SANITIZE_STRING);
$cidade = filter_input(INPUT_POST, 'cidade_aluno', FILTER_SANITIZE_STRING);
$cep = filter_input(INPUT_POST, 'cep_aluno', FILTER_SANITIZE_STRING);
$estado = filter_input(INPUT_POST, 'estado_aluno', FILTER_SANITIZE_STRING);
$bairro = filter_input(INPUT_POST, 'bairro_aluno', FILTER_SANITIZE_STRING);
$rua = filter_input(INPUT_POST, 'rua_aluno', FILTER_SANITIZE_STRING);
$numero = filter_input(INPUT_POST, 'numero_endereco_aluno', FILTER_SANITIZE_STRING);
$bairro = filter_input(INPUT_POST, 'bairro_aluno', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email_aluno', FILTER_SANITIZE_STRING);
$telefone = filter_input(INPUT_POST, 'telefone_aluno', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha_aluno', FILTER_SANITIZE_STRING);
$senha_confirm = filter_input(INPUT_POST, 'confirmar_senha_aluno', FILTER_SANITIZE_STRING);

if(isset($_POST['check_deficiencia'])) {
  $port_deficiencia = true;
}else{
  $port_deficiencia = false;
}

$login = str_replace(".","",$matricula);
$login =  str_replace(",","",$login);
$login = str_replace("/","",$login);
$login = str_replace("-","",$login);


$consulta = "select * from aluno where cpf like '$cpf' or rg like '$rg' or matricula like '$matricula'";

$result = $mysqli->query($consulta) or die($mysqli->error);

if($result->num_rows == 0){
  $consulta = "insert into acesso (tipo,login,senha) values ('aluno','$login','$senha')";
  $result = $mysqli->query($consulta) or die($mysqli->error);

  if(mysqli_insert_id($mysqli)){
    $id_acesso = mysqli_insert_id($mysqli);

    $consulta = "insert into endereco (cidade,rua,bairro,numero,estado,cep) values ('$cidade','$rua','$bairro','$numero',
    '$estado','$cep')";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    if(mysqli_insert_id($mysqli)){
      $id_endereco = mysqli_insert_id($mysqli);

      $consulta = "insert into aluno (nome,matricula,id_curso,periodo,data_nascimento,rg,cpf,sexo,email,telefone,id_endereco,id_acesso,por_deficiencia)
      values ('$nome','$matricula','$id_curso','$periodo','$data_nascimento','$rg','$cpf','$sexo','$email','$telefone','$id_endereco',
      '$id_acesso','$port_deficiencia')";
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

  mail($email,"Acesso ao sistema da Coord. Estágios","Olá ".$nome.", agora o Sistema de Gerenciamento de Estágios está acessível para você. Seu usuário é: ".$matricula." e sua senha: ".$senha);
}else{
  $_SESSION['erro_cadastro']="O aluno já existe.";
}

header('Location: ../../view/menu.php?Pagina=cadastrarAluno');
?>
