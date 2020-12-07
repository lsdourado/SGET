<?php
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../../index.php');
}

include_once("../connection/ConnectionFactory.php");

include_once("../data_access/coordenador/listarEstagios.php");

if(isset($_POST['buscar'])) {
	include_once("../data_access/coordenador/buscarEstagio.php");
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
	<title>Coor. Estágio</title>
</header>

<body>

	<div style="padding-bottom: 1%">
		<h3><span><strong>Estágios</strong></span></h3>
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
		?>
	</div>
	<form action="" method="post">
		<div class="form-group" id="div_buscar" style="float:left; width:60%">
			<input type="text" name="estagio" class="form-control" id="estagio" placeholder="Buscar Estágio">
		</div>
		<div style="float:left; padding-left: 1%; padding-top: 8px">
			<img src="img/search.png">
		</div>
		<input type="hidden" name="buscar" value="busca">
	</form>

	<div style="float:right">
		<a href="?Pagina=cadastrarEstagio" class="btn btn-success" role="button">Cadastrar Estágio</a>
	</div>

</br>
</br>
<div id="tabela_estagios">
	<table class="table table-sm table-hover" id="tabela_estagios">
		<thead>
			<tr>
				<th scope="col">Aluno</th>
				<th scope="col">Matrícula</th>
				<th scope="col">Orientador</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php while($linha = mysqli_fetch_assoc($_SESSION['result_estagios'])){ ?>

				<tr>
					<td style="padding-top:1.3%"><?php echo $linha['nome_aluno'] ?></td>
					<td style="padding-top:1.3%"><?php echo $linha['matricula'] ?></td>
					<td style="padding-top:1.3%"><?php echo $linha['nome_professor'] ?></td>
					<td style="padding-top:1.5%">
						<a href="#" data-toggle="modal" data-target="#modalVisualizar<?php echo $linha['id_estagio'] ?>" style="float:right;"><img src="../view/img/visualizar.png" style="width:20px;height:20px"></a>
					</td>
					<td style="padding-top:1.5%;width:5%">
						<a href="#" data-toggle="modal" data-target="#modalEditar<?php echo $linha['id_estagio'] ?>" style="float:right;"><img src="../view/img/editar.png" style="width:20px;height:20px"></a>
					</td>
					<td style="padding-top:1.5%;width:5%">
						<a href="#" data-toggle="modal" data-target="#modalExcluir<?php echo $linha['id_estagio'] ?>" style="float:right;"><img src="../view/img/excluir.png" style="width:20px;height:20px"></a>
					</td>
					<td style="padding-top:1.1%;width:5%;padding-left:1.5%">
						<a href="coordenador/documentos/termoCompromisso.php?id_estagio=<?php echo $linha['id_estagio']?>" target="blank" class="btn btn-info" id="termo" name="termo" style="background:none;border:none"><img src="../view/img/print_compromisso.png" style="width:20px;height:20px"></a>
					</td>
				</tr>

				<!-- Modal Visualizar-->
				<div class="modal fade" id="modalVisualizar<?php echo $linha['id_estagio'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<p><h5 class="modal-title" id="exampleModalLabel">Estágio de <?php echo $linha['nome_aluno'] ?></h5></p>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<hr>
								<p><strong>Obrigatório: </strong>
									<?php
					        if($linha['obrigatorio']){
					          echo "Sim";
					        }else{
					          echo "Não";
					        }
					        ?></p>
								<hr>
								<p><strong>Orientação</strong></p>
								<p><strong>Professor: </strong><?php echo $linha['nome_professor'] ?></p>
								<p><strong>SIAPE: </strong><?php echo $linha['siape'] ?></p>
								<hr>
								<p><strong>Empresa</strong></p>
								<p><strong>Nome: </strong><?php echo $linha['nome_fantasia_empresa'] ?></p>
								<p><strong>Supervisor: </strong><?php echo $linha['nome_supervisor'] ?></p>
								<p><strong>Supervisor: </strong><?php echo $linha['cnpj'] ?></p>
								<hr>
								<p><strong>Datas e Horários</strong></p>
								<p><strong>Data de início: </strong><?php echo $linha['data_inicio'] ?></p>
								<p><strong>Data final: </strong><?php echo $linha['data_fim'] ?></p>
								<p><strong>Carga Semanal: </strong><?php echo $linha['carga_semanal'] ?></p>
								<p><strong>Horário de início: </strong><?php echo $linha['horario_inicio'] ?></p>
								<p><strong>Horário de fim: </strong><?php echo $linha['horario_fim'] ?></p>
								<hr>
								<p><strong>Seguro</strong></p>
								<p><strong>Apólice de Seguro: </strong><?php echo $linha['apolice_seguro'] ?></p>
								<p><strong>Nome da Seguradora: </strong><?php echo $linha['nome_seguradora'] ?></p>
								<p><strong>Valor do seguro: </strong><?php echo $linha['valor_seguro'] ?></p>
								<hr>
								<p><strong>Outros Valores</strong></p>
								<p><strong>Bolsa: </strong><?php echo $linha['bolsa_auxilio'] ?></p>
								<p><strong>Auxílio Transporte: </strong><?php echo $linha['auxilio_transporte'] ?></p>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal Visualizar-->

				<!-- Modal Editar-->
				<div class="modal fade bd-example-modal-lg" id="modalEditar<?php echo $linha['id_estagio'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Editar Estágio</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="../data_access/coordenador/alterarEstagio.php" method="post">

									<?php include("../data_access/coordenador/listarAlunos.php");
									include("../data_access/coordenador/listarProfessores.php");
									include("../data_access/coordenador/listarEmpresas.php");
									include("../data_access/coordenador/listarSupervisores.php");
									?>

									<input type="hidden" value="<?php echo $linha['id_estagio'] ?>" name="id_estagio" id="id_estagio">
									<input type="hidden" value="<?php echo $linha['id_aluno_estagio'] ?>" name="id_aluno_estagio" id="id_aluno_estagio">
									<input type="hidden" value="<?php echo $linha['id_professor_estagio'] ?>" name="id_professor_estagio" id="id_professor_estagio">
									<input type="hidden" value="<?php echo $linha['id_empresa_estagio'] ?>" name="id_empresa_estagio" id="id_empresa_estagio">
									<input type="hidden" value="<?php echo $linha['id_supervisor_estagio'] ?>" name="id_supervisor_estagio" id="id_supervisor_estagio">
									<div class="form-group">
										<label for="estagio_aluno" style="font-weight:bold;">Aluno</label></br>
										<select class="form-control" name="estagio_aluno" id="estagio_aluno" style="width:70%">
											<option value="" disabled selected>Aluno</option>
											<?php
											while($linha_aluno = mysqli_fetch_assoc($_SESSION['result_alunos'])){
												?>
												<option value="<?php echo $linha_aluno['id_aluno'] ?>" <?php if($linha['id_aluno_estagio']==$linha_aluno['id_aluno']){ echo "selected"; } ?>><?php echo $linha_aluno['nome_aluno'] ?> / Matrícula: <?php echo $linha_aluno['matricula'] ?></option>
												<?php
											}
											unset($_SESSION['result_alunos']);
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="estagio_professor" style="font-weight:bold;">Orientador</label></br>
										<select class="form-control" name="estagio_professor" id="estagio_professor" style="width:70%">
												<option value="" disabled selected>Orientador</option>
											<?php
											while($linha_professor = mysqli_fetch_assoc($_SESSION['result_professores'])){
												?>
												<option value="<?php echo $linha_professor['id_professor'] ?>" <?php if($linha['id_professor_estagio']==$linha_professor['id_professor']){ echo "selected"; } ?>><?php echo $linha_professor['nome_professor'] ?> / SIAPE: <?php echo $linha_professor['siape'] ?></option>
												<?php
											}
											unset($_SESSION['result_professores']);
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="estagio_empresa" style="font-weight:bold;">Empresa</label></br>
										<select class="form-control" name="estagio_empresa" id="estagio_empresa<?php echo $linha['id_estagio'] ?>" style="width:90%">
											<option value="default" disabled selected>Empresa</option>
											<?php
											while($linha_empresa = mysqli_fetch_assoc($_SESSION['result_empresas'])){
												?>
												<option value="<?php echo $linha_empresa['id_empresa'] ?>" <?php if($linha['id_empresa_estagio']==$linha_empresa['id_empresa']){ echo "selected"; } ?>><?php echo $linha_empresa['nome_fantasia'] ?> / CNPJ: <?php echo $linha_empresa['cnpj'] ?></option>
												<?php
											}
											unset($_SESSION['result_empresas']);
											?>
										</select>
									</div>
									<div class="form-group" id="select_supervisores">
										<label for="estagio_supervisor" style="font-weight:bold;">Supervisor</label></br>
										<select class="form-control" name="estagio_supervisor" id="estagio_supervisor<?php echo $linha['id_estagio'] ?>" style="width:60%">
											<option value="" disabled selected>Supervisor</option>
											<?php
											while($linha_supervisor = mysqli_fetch_assoc($_SESSION['result_supervisores'])){
												?>
												<option id="<?php echo $linha['id_estagio'] ?>supervisor<?php echo $linha_supervisor['id_supervisor'] ?>" value="<?php echo $linha_supervisor['id_supervisor'] ?>" <?php if($linha['id_supervisor_estagio']==$linha_supervisor['id_supervisor']){ echo "selected"; } ?>><?php echo $linha_supervisor['nome'] ?> / Nº Reg. Prof: <?php echo $linha_supervisor['num_reg_prof'] ?></option>
												<option id="<?php echo $linha['id_estagio'] ?>empresa_supervisor<?php echo $linha_supervisor['id_supervisor'] ?>" value="<?php echo $linha_supervisor['id_empresa'] ?>" style="display:none"></option>
												<?php
											}
											unset($_SESSION['result_supervisores']);
											?>
										</select>
									</div>

									<div class="form-group">
										<label for="data_inicio<?php echo $linha['id_estagio'] ?>" style="font-weight:bold;">Data de início</label></br>
										<div class="input-group date" style="width:20%">
											<input type="text" class="form-control" name="data_inicio<?php echo $linha['id_estagio'] ?>" id="data_inicio<?php echo $linha['id_estagio'] ?>" placeholder="Data de início" value="<?php echo $linha['data_inicio'] ?>">
											<div class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="data_fim<?php echo $linha['id_estagio'] ?>" style="font-weight:bold;">Data final</label></br>
										<div class="input-group date" style="width:20%">
											<input type="text" class="form-control" name="data_fim<?php echo $linha['id_estagio'] ?>" id="data_fim<?php echo $linha['id_estagio'] ?>" placeholder="Data final" value="<?php echo $linha['data_fim'] ?>">
											<div class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="carga_semanal" style="font-weight:bold;">Carga horária semanal (HH:mm)</label></br>
										<input type="text" minlength="5" maxlength="5" name="carga_semanal" class="form-control" id="carga_semanal<?php echo $linha['id_estagio'] ?>" placeholder="Carga Horária Semanal (HH:mm)" value="<?php echo $linha['carga_semanal'] ?>" style="width:30%">
									</div>
									<div class="form-group">
										<label for="horario_inicio" style="font-weight:bold;">Início do expediente (HH:mm)</label></br>
										<input type="text" minlength="5" maxlength="5" name="horario_inicio" class="form-control" id="horario_inicio<?php echo $linha['id_estagio'] ?>" placeholder="Início do expediente (HH:mm)" value="<?php echo $linha['horario_inicio'] ?>" style="width:30%">
									</div>
									<div class="form-group">
										<label for="horario_fim" style="font-weight:bold;">Fim do expediente (HH:mm)</label></br>
										<input type="text" minlength="5" maxlength="5" name="horario_fim" class="form-control" id="horario_fim<?php echo $linha['id_estagio'] ?>" placeholder="Fim do expediente (HH:mm)" value="<?php echo $linha['horario_fim'] ?>" style="width:30%">
									</div>
									<div class="form-group">
										<label for="apolice_seguro" style="font-weight:bold;">Apólice do seguro</label></br>
										<input type="text" minlength="13" maxlength="13" name="apolice_seguro" class="form-control" id="apolice_seguro<?php echo $linha['id_estagio'] ?>" placeholder="Apólice do Seguro" value="<?php echo $linha['apolice_seguro'] ?>" style="width:30%">
									</div>
									<div class="form-group">
										<label for="nome_seguradora" style="font-weight:bold;">Nome da seguradora</label></br>
										<input type="text" name="nome_seguradora" class="form-control" id="nome_seguradora" placeholder="Nome da Seguradora" value="<?php echo $linha['nome_seguradora'] ?>" style="width:80%">
									</div>
									<div class="form-group">
										<label for="valor_seguro" style="font-weight:bold;">Valor do seguro</label></br>
										<input type="text" minlength="4" name="valor_seguro" class="form-control" id="valor_seguro<?php echo $linha['id_estagio'] ?>" placeholder="Valor do Seguro" value="<?php echo $linha['valor_seguro'] ?>" style="width:30%">
									</div>
									<div id="bolsas_estagio">
										<div class="form-group">
											<label for="bolsa_auxilio" style="font-weight:bold;">Bolsa auxílio</label></br>
											<input type="text" name="bolsa_auxilio" class="form-control" id="bolsa_auxilio<?php echo $linha['id_estagio'] ?>" placeholder="Bolsa Auxílio" value="<?php echo $linha['bolsa_auxilio'] ?>" style="width:30%">
										</div>
										<div class="form-group">
											<label for="auxilio_transporte" style="font-weight:bold;">Auxílio transporte</label></br>
											<input type="text" name="auxilio_transporte" class="form-control" id="auxilio_transporte<?php echo $linha['id_estagio'] ?>" placeholder="Auxílio Transporte" value="<?php echo $linha['auxilio_transporte'] ?>" style="width:30%">
										</div>
									</div>
									<div class="form-group form-check">
						        <input type="checkbox" name="obrigatorio" id="obrigatorio" <?php if($linha['obrigatorio']){ echo "checked"; } ?>>
										<label for="obrigatorio" style="font-weight:bold;">Estágio obrigatório</label>
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

				<script type="text/javascript">
				$('#data_inicio<?php echo $linha['id_estagio'] ?>').datepicker({
					format: 'dd/mm/yyyy',
					language: "pt-BR",
					todayHighlight: true,
					autoclose: true
				})
				$('#data_fim<?php echo $linha['id_estagio'] ?>').datepicker({
					format: 'dd/mm/yyyy',
					language: "pt-BR",
					todayHighlight: true,
					autoclose: true
				});

				$("#data_inicio<?php echo $linha['id_estagio'] ?>").mask("00/00/0000");
			  $("#data_fim<?php echo $linha['id_estagio'] ?>").mask("00/00/0000");
			  $("#carga_semanal<?php echo $linha['id_estagio'] ?>").mask("00:00");
			  $("#horario_inicio<?php echo $linha['id_estagio'] ?>").mask("00:00", {reverse:true});
			  $("#horario_fim<?php echo $linha['id_estagio'] ?>").mask("00:00", {reverse:true});
			  $("#apolice_seguro<?php echo $linha['id_estagio'] ?>").mask("0.000.000.000");

				$("#valor_seguro<?php echo $linha['id_estagio'] ?>").keypress(function(){
					$("#valor_seguro<?php echo $linha['id_estagio'] ?>").mask('#.##0,00', {reverse:true});
				});

			  $("#valor_seguro<?php echo $linha['id_estagio'] ?>").blur(function(){
					$("#valor_seguro<?php echo $linha['id_estagio'] ?>").unmask();
					$("#valor_seguro<?php echo $linha['id_estagio'] ?>").mask('#.##0,00', {reverse:true});
			    $("#valor_seguro<?php echo $linha['id_estagio'] ?>").val("R$"+$("#valor_seguro<?php echo $linha['id_estagio'] ?>").val());
			  });

			  $("#bolsa_auxilio<?php echo $linha['id_estagio'] ?>").keypress(function(){
					$("#bolsa_auxilio<?php echo $linha['id_estagio'] ?>").mask('#.##0,00', {reverse:true});
				});

				$("#bolsa_auxilio<?php echo $linha['id_estagio'] ?>").blur(function(){
					$("#bolsa_auxilio<?php echo $linha['id_estagio'] ?>").unmask();
					$("#bolsa_auxilio<?php echo $linha['id_estagio'] ?>").mask('#.##0,00', {reverse:true});
			    $("#bolsa_auxilio<?php echo $linha['id_estagio'] ?>").val("R$"+$("#bolsa_auxilio<?php echo $linha['id_estagio'] ?>").val());
			  });

				$("#auxilio_transporte<?php echo $linha['id_estagio'] ?>").keypress(function(){
					$("#auxilio_transporte<?php echo $linha['id_estagio'] ?>").mask('#.##0,00', {reverse:true});
				});

			  $("#auxilio_transporte<?php echo $linha['id_estagio'] ?>").blur(function(){
					$("#auxilio_transporte<?php echo $linha['id_estagio'] ?>").unmask();
					$("#auxilio_transporte<?php echo $linha['id_estagio'] ?>").mask('#.##0,00', {reverse:true});
			    $("#auxilio_transporte<?php echo $linha['id_estagio'] ?>").val("R$"+$("#auxilio_transporte<?php echo $linha['id_estagio'] ?>").val());
			  });

				$('#estagio_empresa<?php echo $linha['id_estagio'] ?>').change(function(){
					var tamMax = $('#estagio_supervisor<?php echo $linha['id_estagio'] ?> option').length;
					var i=0;

					for(i; i < tamMax; i++){
						if($('#<?php echo $linha['id_estagio'] ?>supervisor'+(i+1)).val()!=undefined){
							if($('#<?php echo $linha['id_estagio'] ?>empresa_supervisor'+(i+1)).val() == $('#estagio_empresa<?php echo $linha['id_estagio'] ?>').val()){
								$('#<?php echo $linha['id_estagio'] ?>supervisor'+(i+1)).show();
							}else{
								$('#<?php echo $linha['id_estagio'] ?>supervisor'+(i+1)).hide();
							}
						}
					}

					$('#estagio_supervisor<?php echo $linha['id_estagio'] ?>').val($('option:contains("Supervisor")').val());
				});
				</script>
			<?php }?>
		</tbody>
	</table>
</div>
</body>
</html>
