<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$id_professor = filter_input(INPUT_POST, 'id_professor', FILTER_SANITIZE_NUMBER_INT);
$id_acesso = filter_input(INPUT_POST, 'id_acesso', FILTER_SANITIZE_NUMBER_INT);
$id_endereco = filter_input(INPUT_POST, 'id_endereco', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome_professor', FILTER_SANITIZE_STRING);
$data_nascimento = filter_input(INPUT_POST, 'data_nascimento'.$id_professor, FILTER_SANITIZE_STRING);
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

$consulta = "update endereco set cidade = '$cidade', rua='$rua', bairro='$bairro',
            numero='$numero', estado='$estado', cep='$cep' where id = $id_endereco";
$result = $mysqli->query($consulta) or die($mysqli->error);

$login = str_replace(".","",$siape);
$login =  str_replace(",","",$login);
$login = str_replace("/","",$login);
$login = str_replace("-","",$login);


$consulta = "update acesso set login = '$login', senha='$senha' where id = $id_acesso";
$result = $mysqli->query($consulta) or die($mysqli->error);

$consulta = "update professor set nome = '$nome', data_nascimento = '$data_nascimento',
            sexo = '$sexo', siape = '$siape', email = '$email', telefone = '$telefone' where id = $id_professor";
$result = $mysqli->query($consulta) or die($mysqli->error);

$_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
header('Location: ../../view/menu.php?Pagina=professores');
?>
