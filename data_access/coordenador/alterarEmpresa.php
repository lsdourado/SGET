<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$id_empresa = filter_input(INPUT_POST, 'id_empresa', FILTER_SANITIZE_NUMBER_INT);
$id_endereco = filter_input(INPUT_POST, 'id_endereco', FILTER_SANITIZE_NUMBER_INT);
$razao_social = filter_input(INPUT_POST, 'razao_social', FILTER_SANITIZE_STRING);
$nome_fantasia = filter_input(INPUT_POST, 'nome_fantasia', FILTER_SANITIZE_STRING);
$tipo_empregador = filter_input(INPUT_POST, 'tipo_empregador', FILTER_SANITIZE_STRING);
$cnpj_empresa = filter_input(INPUT_POST, 'cnpj_empresa', FILTER_SANITIZE_STRING);
$representante_legal = filter_input(INPUT_POST, 'representante_legal', FILTER_SANITIZE_STRING);
$telefone_empresa = filter_input(INPUT_POST, 'telefone_empresa', FILTER_SANITIZE_STRING);
$email_empresa = filter_input(INPUT_POST, 'email_empresa', FILTER_SANITIZE_STRING);
$cidade_empresa = filter_input(INPUT_POST, 'cidade_empresa', FILTER_SANITIZE_STRING);
$rua_empresa = filter_input(INPUT_POST, 'rua_empresa', FILTER_SANITIZE_STRING);
$bairro_empresa = filter_input(INPUT_POST, 'bairro_empresa', FILTER_SANITIZE_STRING);
$numero_endereco_empresa = filter_input(INPUT_POST, 'numero_endereco_empresa', FILTER_SANITIZE_STRING);
$estado_empresa = filter_input(INPUT_POST, 'estado_empresa', FILTER_SANITIZE_STRING);
$cep_empresa = filter_input(INPUT_POST, 'cep_empresa', FILTER_SANITIZE_STRING);

$consulta = "UPDATE endereco SET cidade = '$cidade_empresa', rua='$rua_empresa', bairro='$bairro_empresa',
            numero='$numero_endereco_empresa', estado='$estado_empresa', cep='$cep_empresa' WHERE id = $id_endereco";
$result = $mysqli->query($consulta) or die($mysqli->error);

$consulta = "UPDATE empresa SET razao_social ='$razao_social', nome_fantasia='$nome_fantasia',
            tipo_empregador='$tipo_empregador', cnpj='$cnpj_empresa', representante_legal='$representante_legal',
            telefone='$telefone_empresa', email='$email_empresa' WHERE id= $id_empresa";
$result = $mysqli->query($consulta) or die($mysqli->error);

$_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
header('Location: ../../view/menu.php?Pagina=empresas');
?>
