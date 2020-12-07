<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$id_aluno = filter_input(INPUT_POST, 'id_aluno', FILTER_SANITIZE_NUMBER_INT);
$id_acesso = filter_input(INPUT_POST, 'id_acesso', FILTER_SANITIZE_NUMBER_INT);
$id_endereco = filter_input(INPUT_POST, 'id_endereco', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome_aluno', FILTER_SANITIZE_STRING);
$rg = filter_input(INPUT_POST, 'rg_aluno', FILTER_SANITIZE_STRING);
$cpf = filter_input(INPUT_POST, 'cpf_aluno', FILTER_SANITIZE_STRING);
$data_nascimento = filter_input(INPUT_POST, 'data_nascimento'.$id_aluno, FILTER_SANITIZE_STRING);
$sexo = filter_input(INPUT_POST, 'sexo_aluno', FILTER_SANITIZE_STRING);
$id_curso = filter_input(INPUT_POST, 'curso_aluno', FILTER_SANITIZE_NUMBER_INT);
$periodo = filter_input(INPUT_POST, 'periodo_aluno', FILTER_SANITIZE_STRING);
$matricula = filter_input(INPUT_POST, 'matricula_aluno', FILTER_SANITIZE_STRING);
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

$consulta = "update endereco set cidade = '$cidade', rua='$rua', bairro='$bairro',
            numero='$numero', estado='$estado', cep='$cep' where id = $id_endereco";
$result = $mysqli->query($consulta) or die($mysqli->error);


$login = str_replace(".","",$matricula);
$login =  str_replace(",","",$login);
$login = str_replace("/","",$login);
$login = str_replace("-","",$login);

$consulta = "update acesso set login = '$login', senha='$senha' where id = $id_acesso";
$result = $mysqli->query($consulta) or die($mysqli->error);

$consulta = "update aluno set nome = '$nome', rg = '$rg', cpf = '$cpf', data_nascimento = '$data_nascimento',
            sexo = '$sexo', id_curso = '$id_curso', periodo = '$periodo', matricula = '$matricula', email = '$email',
            telefone = '$telefone', por_deficiencia = '$port_deficiencia' where id = $id_aluno";
$result = $mysqli->query($consulta) or die($mysqli->error);

$_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
header('Location: ../../view/menu.php?Pagina=alunos');
?>
