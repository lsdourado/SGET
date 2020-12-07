<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$id_instituicao = filter_input(INPUT_POST, 'id_instituicao', FILTER_SANITIZE_NUMBER_INT);
$id_endereco = filter_input(INPUT_POST, 'id_endereco', FILTER_SANITIZE_NUMBER_INT);
$nome_instituicao = filter_input(INPUT_POST, 'nome_instituicao', FILTER_SANITIZE_STRING);
$cnpj_instituicao = filter_input(INPUT_POST, 'cnpj_instituicao', FILTER_SANITIZE_STRING);
$telefone_instituicao = filter_input(INPUT_POST, 'telefone_instituicao', FILTER_SANITIZE_STRING);
$diretor_instituicao = filter_input(INPUT_POST, 'diretor_instituicao', FILTER_SANITIZE_STRING);
$portaria_instituicao = filter_input(INPUT_POST, 'portaria_instituicao', FILTER_SANITIZE_STRING);
$cidade_endereco = filter_input(INPUT_POST, 'cidade_endereco', FILTER_SANITIZE_STRING);
$rua_endereco = filter_input(INPUT_POST, 'rua_endereco', FILTER_SANITIZE_STRING);
$bairro_endereco = filter_input(INPUT_POST, 'bairro_endereco', FILTER_SANITIZE_STRING);
$numero_endereco = filter_input(INPUT_POST, 'numero_endereco', FILTER_SANITIZE_STRING);
$estado_endereco = filter_input(INPUT_POST, 'estado_endereco', FILTER_SANITIZE_STRING);
$cep_endereco = filter_input(INPUT_POST, 'cep_endereco', FILTER_SANITIZE_STRING);

$consulta = "UPDATE endereco SET cidade = '$cidade_endereco', rua='$rua_endereco', bairro='$bairro_endereco',
            numero='$numero_endereco', estado='$estado_endereco', cep='$cep_endereco' WHERE id = '$id_endereco'";
$result = $mysqli->query($consulta) or die($mysqli->error);

$consulta = "UPDATE instituicao SET nome ='$nome_instituicao', cnpj='$cnpj_instituicao',
            telefone='$telefone_instituicao', diretor='$diretor_instituicao', portaria='$portaria_instituicao'
            WHERE id= '$id_instituicao'";
$result = $mysqli->query($consulta) or die($mysqli->error);

$_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
header('Location: ../../view/menu.php?Pagina=instituicao');
?>
