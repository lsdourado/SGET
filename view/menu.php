<?php
include_once("../connection/ConnectionFactory.php");
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../index.php');
}

if($_SESSION['tipo_login']=="aluno") {
	include_once("../data_access/aluno/buscarAluno.php");
	$_SESSION['aluno'] = mysqli_fetch_assoc($_SESSION['result_alunos']);
}elseif($_SESSION['tipo_login']=="professor") {
	include_once("../data_access/professor/buscarProfessor.php");
	$_SESSION['professor'] = mysqli_fetch_assoc($_SESSION['result_professores']);
}

if(!isset($_SESSION['instituicao'])){
	include_once("../data_access/coordenador/buscarInstituicao.php");
	$_SESSION['instituicao']=mysqli_fetch_assoc($_SESSION['result_instituicao']);
}

?>

<html>
<header>
	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="pt-br">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link href="css/simple-sidebar.css" rel="stylesheet">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap-datepicker3.css">
	<script src="../bootstrap/js/jquery-3.2.1.slim.min.js"></script>
	<script src="../bootstrap/js/popper.min.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.mask.min.js"></script>
	<script src="../bootstrap/js/bootstrap-datepicker.js"></script>
	<script src="../bootstrap/locales/bootstrap-datepicker.pt-BR.min.js"></script>
	<title>Coord. Estágio</title>
</header>

<body>

	<div id="wrapper" class="toggled">

		<!-- Sidebar -->
		<div id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<li class="sidebar-brand" style="padding-left:60px;padding-top:15px;margin-bottom:80px">
					<a href="#" style="text-decoration:none" data-toggle="modal" data-target="#modalInfoInstituicao">
						<img class="rounded-circle" src="img/ifba.bmp" style="width:90px; height:90px;">
					</a>
				</li>
			<?php
			if($_SESSION['tipo_login']=="coordenador"){
				?>
				<center>
					<a href="?Pagina=conf_acesso" id="painel_coord">
						<li style="padding-right:15px;background:#151515;margin-bottom:20px;width:200px;border-radius: 25px;">
							<span style="color:#fff">Painel da Coordenação</span>
						</li>
					</a>
				</center>
				<div id="menu_coord" style="pointer-events:none;opacity:0.3;">
					<li>
						<a href="?Pagina=instituicao"><img src="img/instituicao.png" style="padding-bottom:3px"> INSTITUIÇÃO</a>
					</li>
					<li>
						<a href="?Pagina=cursos"><img src="img/cursos.png" style="padding-bottom:3px"> CURSOS</a>
					</li>
					<li>
						<a href="?Pagina=alunos"><img src="img/alunos.png" style="padding-bottom:3px"> ALUNOS</a>
					</li>
					<li>
						<a href="?Pagina=professores"><img src="img/professores.png" style="padding-bottom:3px"> PROFESSORES</a>
					</li>
					<li>
						<a href="?Pagina=empresas"><img src="img/empresas.png" style="padding-bottom:3px"> EMPRESAS</a>
					</li>
					<li>
						<a href="?Pagina=supervisores"><img src="img/supervisores.png" style="padding-bottom:3px"> SUPERVISORES</a>
					</li>
					<li>
						<a href="?Pagina=estagios"><img src="img/estagios.png" style="padding-bottom:3px"> ESTÁGIOS</a>
					</li>
				</div>
				<?php
			}elseif($_SESSION['tipo_login']=="aluno"){
				?>
				<?php
					if(isset($_SESSION['aluno'])){
						?>
						<center>
							<a href="?Pagina=info_aluno" id="painel_aluno">
								<li style="padding-right:15px;background:#151515;margin-bottom:20px;width:200px;border-radius: 25px;">
									<span style="color:#fff;width:auto">
										<?php
											$str = $_SESSION['aluno']['nome_aluno'];
											echo 'Painel de '.explode(' ', $str)[0];
										?>
									</span>
								</li>
							</a>
						</center>
						<?php
					}
				?>
				<li>
					<a href="?Pagina=info_aluno"><img src="img/inicio.png" style="padding-bottom:3px"> INÍCIO</a>
				</li>
				<li id="li_estagio">
					<a href="#" id="li_meu_estagio"><img src="img/estagios.png" style="padding-bottom:3px"> MEU ESTÁGIO</a>
				</li>
				<div id="list_meu_estagio" style="display:none; background: #2E2E2E;">
					<li>
						<a href="?Pagina=info_estagio_aluno">
							<span>Informações</span>
							<hr>
						</a>
					</li>
					<li>
						<a href="?Pagina=boletim">
							<span>Boletim</span>
							<hr>
						</a>
					</li>
				</div>
				<li id="li_doc_disabled">
					<a href="#" id='li_documentos'><img src="img/documentos.png" style="padding-bottom:3px"> DOCUMENTOS</a>
				</li>
				<div id="list_documentos" style="display: none; background: #2E2E2E;">
					<li>
						<a href="?Pagina=plano_aluno">
							<span>Plano de trabalho</span>
							<hr>
						</a>
					</li>
					<li>
						<a href="?Pagina=entrevista_1">
							<span>1ª Entrevista</span>
							<hr>
						</a>
					</li>
					<li>
						<a href="?Pagina=entrevista_2">
							<span>2ª Entrevista</span>
							<hr>
						</a>
					</li>
					<li>
						<a href="?Pagina=entrevista_final">
							<span>Entrevista final</span>
							<hr style="height:2px;">
						</a>
					</li>
					<li>
						<a href="?Pagina=relatorio_final">
							<span>Relatório final</span>
							<hr>
						</a>
					</li>
				</div>
				<?php
			}elseif($_SESSION['tipo_login']=="professor"){
				?>
				<?php
					if(isset($_SESSION['professor'])){
						?>
						<center>
							<a href="?Pagina=info_professor" id="painel_professor">
								<li style="padding-right:15px;background:#151515;margin-bottom:20px;width:200px;border-radius: 25px;">
									<span style="color:#fff;width:auto">
										<?php
											$str = $_SESSION['professor']['nome_professor'];
											echo 'Painel de '.explode(' ', $str)[0];
										?>
									</span>
								</li>
							</a>
						</center>
						<?php
					}
				?>
				<li>
					<a href="?Pagina=info_professor"><img src="img/inicio.png" style="padding-bottom:3px"> INÍCIO</a>
				</li>
				<li>
					<a href="?Pagina=estagios_professor"><img src="img/estagios.png" style="padding-bottom:3px"> ESTÁGIOS</a>
				</li>
				<?php
			}
			?>

			<li id="menuitem_configAcesso" <?php if($_SESSION['tipo_login'] != "aluno" && $_SESSION['tipo_login'] != "professor"){ echo 'style=pointer-events:none;opacity:0.3'; }?>>
				<a href="?Pagina=conf_acesso"><img src="img/config.png" style="padding-bottom:3px"> CONFIG. ACESSO</a>
			</li>
			<li>
				<a href="?Pagina=logout" style="color:#FE2E2E;"><img src="img/logout.png" style="padding-bottom:6px"> SAIR</a>
			</li>
		</ul>
	</div>
	<!-- /#sidebar-wrapper -->

	<!-- Page Content -->
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div id="pagina">
				<?php
				$Pagina = @$_GET['Pagina'];

				if($Pagina == "instituicao"){
					include('coordenador/gerenciarInstituicao.php');
				}elseif($Pagina == "cadastrarInstituicao"){
					include('coordenador/cadastrarInstituicao.php');
				}elseif ($Pagina == "alunos") {
					include('coordenador/gerenciarAlunos.php');
				}elseif ($Pagina == "cadastrarAluno") {
					include('coordenador/cadastrarAluno.php');
				}elseif ($Pagina == "cursos") {
					include('coordenador/gerenciarCursos.php');
				}elseif ($Pagina == "cadastrarCurso") {
					include('coordenador/cadastrarCurso.php');
				}elseif ($Pagina == "professores") {
					include('coordenador/gerenciarProfessores.php');
				}elseif ($Pagina == "cadastrarProfessor") {
					include('coordenador/cadastrarProfessor.php');
				}elseif ($Pagina == "empresas") {
					include('coordenador/gerenciarEmpresas.php');
				}elseif ($Pagina == "cadastrarEmpresa") {
					include('coordenador/cadastrarEmpresa.php');
				}elseif ($Pagina == "supervisores") {
					include('coordenador/gerenciarSupervisores.php');
				}elseif ($Pagina == "cadastrarSupervisor") {
					include('coordenador/cadastrarSupervisor.php');
				}elseif ($Pagina == "estagios") {
					include('coordenador/gerenciarEstagios.php');
				}elseif ($Pagina == "cadastrarEstagio") {
					include('coordenador/cadastrarEstagio.php');
				}elseif ($Pagina == "logout") {
					include('../data_access/login/efetuarLogout.php');
				}elseif ($Pagina == "conf_acesso") {
					include('login/alterarLogin.php');
				}elseif ($Pagina == "info_aluno") {
					include('aluno/infoAluno.php');
				}elseif ($Pagina == "info_estagio_aluno") {
					include('aluno/infoEstagio.php');
				}elseif ($Pagina == "plano_aluno") {
					include('aluno/planoTrabalho.php');
				}elseif ($Pagina == "entrevista_1") {
					include('aluno/primeiraEntrevista.php');
				}elseif ($Pagina == "entrevista_2") {
					include('aluno/segundaEntrevista.php');
				}elseif ($Pagina == "entrevista_final") {
					include('aluno/entrevistaFinal.php');
				}elseif ($Pagina == "relatorio_final") {
					include('aluno/relatorioFinal.php');
				}elseif ($Pagina == "boletim") {
					include('aluno/boletimEstagio.php');
				}elseif ($Pagina == "info_professor") {
					include('professor/infoProfessor.php');
				}elseif ($Pagina == "estagios_professor") {
					include('professor/estagios_professor.php');
				}elseif ($Pagina == "gerenciarEstagio") {
					include('professor/gerenciarEstagio.php');
				}else{
					if($_SESSION['tipo_login']=='coordenador'){
						header('Location: ?Pagina=instituicao');
					}elseif($_SESSION['tipo_login']=='aluno'){
						header('Location: ?Pagina=info_aluno');
					}elseif($_SESSION['tipo_login']=='professor'){
						header('Location: ?Pagina=info_professor');
					}
				}
				?>
			</div>
		</div>
	</div>
	<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->


<!-- Modal Informações Instituição-->
<div class="modal fade bd-example-modal-lg" id="modalInfoInstituicao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Instituição</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p><strong>Nome: </strong><?php echo $_SESSION['instituicao']['nome'] ?></p>
				<p><strong>CNPJ: </strong><?php echo $_SESSION['instituicao']['cnpj'] ?></p>
				<p><strong>Diretor: </strong><?php echo $_SESSION['instituicao']['diretor'] ?></p>
				<p><strong>Nº Portaria: </strong><?php echo $_SESSION['instituicao']['portaria'] ?></p>

				<hr>

				<strong><span>Telefone</span></strong>
				<p style="padding-top:1%"><?php echo $_SESSION['instituicao']['telefone'] ?></p>

				<hr>

				<strong><span>Endereço</span></strong>
				<p style="padding-top:1%">
					<?php echo $_SESSION['instituicao']['rua'].', '.$_SESSION['instituicao']['numero'].', '.$_SESSION['instituicao']['bairro'].', CEP: '.$_SESSION['instituicao']['cep'].', '.$_SESSION['instituicao']['cidade'].', '.$_SESSION['instituicao']['estado']; ?>
				</p>
			</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function(){
		$("input").prop("required",true);
		$("select").prop("required",true);
		$(".form-check input").prop("required",false);
		$("#bolsas_estagio input").prop("required",false);
		$("#div_buscar input").prop("required",false);


		$('#li_documentos').click(function(){
			if($('#list_documentos').css('display') == 'none'){
				$('#li_documentos').css({background: "rgba(255, 255, 255, 0.2)", color: "#fff"});
				$('#list_documentos').slideUp();
				$('#li_documentos').css({background: "#2E2E2E", color: "#fff"});
				$('#list_documentos').slideDown();
				return false;
			}else{
				$('#list_documentos').slideUp();
			}
		});

		$('#li_documentos').blur(function(){
			$('#list_documentos').slideUp();
			$('#li_documentos').css({background: "#2E2E2E", color: "#fff"});
		});

		$('#li_meu_estagio').click(function(){
			if($('#list_meu_estagio').css('display') == 'none'){
				$('#li_meu_estagio').css({background: "rgba(255, 255, 255, 0.2)", color: "#fff"});
				$('#list_documentos').slideUp();
				$('#li_documentos').css({background: "#2E2E2E", color: "#fff"});
				$('#list_meu_estagio').slideDown();
				return false;
			}else{
				$('#list_meu_estagio').slideUp();
			}
		});

		$('#li_meu_estagio').blur(function(){
			$('#list_meu_estagio').slideUp();
			$('#li_meu_estagio').css({background: "#2E2E2E", color: "#fff"});
		});

		$("#li_meu_estagio").hover(function(){
        $('#li_meu_estagio').css("background", "#1C1C1C");
				$('#li_meu_estagio').css("color", "#298A08");
        }, function(){
        $("#li_meu_estagio").css("background", "#2E2E2E");
				$('#li_meu_estagio').css("color", "#fff");
    });

		$("#li_documentos").hover(function(){
        $('#li_documentos').css("background", "#1C1C1C");
				$('#li_documentos').css("color", "#298A08");
        }, function(){
        $("#li_documentos").css("background", "#2E2E2E");
				$('#li_documentos').css("color", "#fff");
    });
	});

	setTimeout(function(){
			var msg = document.getElementById("mensagem_alerta");
			msg.parentNode.removeChild(msg);
	}, 3000);
</script>
</body>

</html>
