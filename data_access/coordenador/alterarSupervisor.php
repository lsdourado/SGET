<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$id_supervisor = filter_input(INPUT_POST, 'id_supervisor', FILTER_SANITIZE_NUMBER_INT);
$nome_supervisor = filter_input(INPUT_POST, 'nome_supervisor', FILTER_SANITIZE_STRING);
$email_supervisor = filter_input(INPUT_POST, 'email_supervisor', FILTER_SANITIZE_STRING);
$num_reg_prof = filter_input(INPUT_POST, 'num_reg_prof', FILTER_SANITIZE_STRING);
$orgao_emissor = filter_input(INPUT_POST, 'orgao_emissor', FILTER_SANITIZE_STRING);
$cargo_supervisor = filter_input(INPUT_POST, 'cargo_supervisor', FILTER_SANITIZE_STRING);
$formacao_supervisor = filter_input(INPUT_POST, 'formacao_supervisor', FILTER_SANITIZE_STRING);
$id_empresa = filter_input(INPUT_POST, 'empresa_supervisor', FILTER_SANITIZE_NUMBER_INT);

$consulta = "UPDATE supervisor SET nome = '$nome_supervisor', num_reg_prof = '$num_reg_prof', orgao_emissor = '$orgao_emissor', cargo = '$cargo_supervisor',
            formacao = '$formacao_supervisor', id_empresa = '$id_empresa', email='$email_supervisor' WHERE id = $id_supervisor";
$result = $mysqli->query($consulta) or die($mysqli->error);

$_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";
header('Location: ../../view/menu.php?Pagina=supervisores');
?>
