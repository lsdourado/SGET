<?php
@session_start();
include_once("../../connection/ConnectionFactory.php");

$id_estagio = filter_input(INPUT_POST, 'id_estagio', FILTER_SANITIZE_STRING);
$id_aluno = filter_input(INPUT_POST, 'estagio_aluno', FILTER_SANITIZE_STRING);
$id_professor = filter_input(INPUT_POST, 'estagio_professor', FILTER_SANITIZE_STRING);
$id_empresa = filter_input(INPUT_POST, 'estagio_empresa', FILTER_SANITIZE_STRING);
$id_supervisor = filter_input(INPUT_POST, 'estagio_supervisor', FILTER_SANITIZE_STRING);
$data_inicio = filter_input(INPUT_POST, 'data_inicio'.$id_estagio, FILTER_SANITIZE_STRING);
$data_fim = filter_input(INPUT_POST, 'data_fim'.$id_estagio, FILTER_SANITIZE_STRING);
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

$consulta = "UPDATE estagio SET id_aluno='$id_aluno', id_professor='$id_professor', id_empresa='$id_empresa',
            id_supervisor='$id_supervisor', data_inicio='$data_inicio', data_fim='$data_fim', carga_semanal='$carga_semanal',
            horario_inicio='$horario_inicio', horario_fim='$horario_fim', apolice_seguro='$apolice_seguro',
            nome_seguradora='$nome_seguradora', valor_seguro='$valor_seguro', bolsa_auxilio='$bolsa_auxilio',
            auxilio_transporte='$auxilio_transporte', obrigatorio='$obrigatorio' WHERE id='$id_estagio'";

$result = $mysqli->query($consulta) or die($mysqli->error);

$_SESSION['sucesso_editar']="Alteração efetuada com sucesso.";

header('Location: ../../view/menu.php?Pagina=estagios');
?>
