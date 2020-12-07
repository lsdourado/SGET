<?php
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../../index.php');
}

include_once("../connection/ConnectionFactory.php");
include_once("../data_access/coordenador/listarCursos.php");

if(isset($_POST['buscar'])) {
	include_once("../data_access/coordenador/buscarCurso.php");
}


if(isset($_SESSION['menu_completo'])){
	?>
	<script>
		$('#menu_coord').css({"pointer-events": "auto", "opacity": "1"});
		$('#menuitem_configAcesso').css({"pointer-events": "auto", "opacity": "1"});
	</script>
	<?php
}
?>
<html>
<header>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<!--<link href="css/simple-sidebar.css" rel="stylesheet">-->
	<title>Coord. Estágio</title>
</header>

<body>

	<div style="padding-bottom: 1%">
		<h3><span><strong>Cursos</strong></span></h3>
	</div>

	<hr>

	<div id="mensagem_alerta">
		<?php
		if(isset($_SESSION['sucesso_editar'])){
			?>
			<div class="alert alert-success" role="alert">
				<?php
				echo $_SESSION['sucesso_editar'];
				unset($_SESSION['sucesso_editar']);
				?>
			</div>
			<?php
		}

		if(isset($_SESSION['erro_excluir'])){
			?>
			<div class="alert alert-danger" role="alert">
				<?php
				echo $_SESSION['erro_excluir'];
				unset($_SESSION['erro_excluir']);
				?>
			</div>
			<?php
		}
		?>
	</div>
	<form action="" method="post">
		<div class="form-group" id="div_buscar" style="float:left; width:60%">
			<input type="text" name="curso" class="form-control" id="curso" placeholder="Buscar Curso">
		</div>
		<div style="float:left; padding-left: 1%; padding-top: 8px">
			<img src="img/search.png">
		</div>
		<input type="hidden" name="buscar" value="buscar">
	</form>

	<div style="float:right">
		<a href="?Pagina=cadastrarCurso" class="btn btn-success" role="button">Cadastrar Curso</a>
	</div>

</br>
</br>
<div id="tabela_cursos">
	<table class="table table-sm table-hover" id="tabela_cursos">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Tipo</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php while($linha = mysqli_fetch_assoc($_SESSION['result_cursos'])){ ?>
				<tr>
					<td style="padding-top:1.3%"><?php echo $linha['nome'] ?></td>
					<td style="padding-top:1.3%"><?php echo $linha['tipo'] ?></td>
					<td style="padding-top:1.5%">
						<a href="#" data-toggle="modal" data-target="#modalEditar<?php echo $linha['id'] ?>" style="float:right;"><img src="../view/img/editar.png" style="width:20px;height:20px"></a>
					</td>
					<td style="padding-top:1.5%;width:5%">
						<a href="#" data-toggle="modal" data-target="#modalExcluir<?php echo $linha['id'] ?>" style="float:right;"><img src="../view/img/excluir.png" style="width:20px;height:20px"></a>
					</td>
				</tr>

				<!-- Modal Editar-->
				<div class="modal fade bd-example-modal-lg" id="modalEditar<?php echo $linha['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Editar Curso</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="../data_access/coordenador/alterarCurso.php" method="post">
									<input type="hidden" value="<?php echo $linha['id'] ?>" name="id_curso" id="id_curso">
									<div class="form-group">
										<label for="nome_curso" style="font-weight:bold;">Nome</label>
										<input type="text" name="nome_curso" class="form-control" id="nome_curso" placeholder="Nome do curso" value="<?php echo $linha['nome'] ?>" style="width:90%">
									</div>
									<div class="form-group">
										<label for="tipo_curso" style="font-weight:bold;">Tipo de curso</label></br>
										<select class="form-control" name="tipo_curso" id="tipo_curso" style="width:40%">
											<option value="" disabled>Tipo de curso</option>
											<option value="Técnico"
											<?php
											if($linha['tipo']=="Técnico"){
												echo "selected";
											}
											?>>Técnico</option>
											<option value="Graduação"
											<?php
											if($linha['tipo']=="Graduação"){
												echo "selected";
											}
											?>>Graduação</option>
										</select>
									</div>

									<hr>

									<div style="float:right">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
										<input type="submit" name="salvar" id="salvar" class="btn btn-success" value="Salvar">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal Editar-->


				<!-- Modal Excluir-->
				<div class="modal fade" id="modalExcluir<?php echo $linha['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Excluir Curso</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body text-center">
								<p>O curso <strong><?php echo $linha['nome'] ?></strong> será excluído. Deseja prosseguir?</p>
								<a href="../data_access/coordenador/excluirCurso.php?id=<?php echo $linha['id'] ?>" class="btn btn-success" style="margin:2%">Sim</a>
								<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin:2%">Não</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal Excluir-->
			<?php }
			?>
		</tbody>
	</table>
</div>
</body>

</html>
