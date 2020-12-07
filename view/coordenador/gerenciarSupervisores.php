<?php
		@session_start();

		if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
				header('Location: ../../index.php');
		}

		include_once("../connection/ConnectionFactory.php");
		include_once("../data_access/coordenador/listarSupervisores.php");

		if(isset($_POST['buscar'])) {
			include_once("../data_access/coordenador/buscarSupervisor.php");
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
				<title>Coor. Estágio</title>
		</header>

		<body>

				<div style="padding-bottom: 1%">
						<h3><span><strong>Supervisores</strong></span></h3>
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
								<input type="text" name="supervisor" class="form-control" id="supervisor" placeholder="Buscar Supervisor">
						</div>
						<div style="float:left; padding-left: 1%; padding-top: 8px">
								<img src="img/search.png">
						</div>
						<input type="hidden" name="buscar" value="busca">
				</form>

				<div style="float:right">
						<a href="?Pagina=cadastrarSupervisor" class="btn btn-success" role="button">Cadastrar Supervisor</a>
				</div>

				</br>
				</br>
				<div id="tabela_supervisores">
						<table class="table table-sm table-hover" id="tabela_supervisores">
											<thead>
													<tr>
														<th scope="col">Nome</th>
														<th scope="col">Nº Reg. Profissional</th>
														<th scope="col">Empresa</th>
														<th></th>
														<th></th>
														<th></th>
													</tr>
												</thead>
												<tbody>
														<?php while($linha = mysqli_fetch_assoc($_SESSION['result_supervisores'])){ ?>
															<tr>
																<td style="padding-top:1.3%"><?php echo $linha['nome'] ?></td>
																<td style="padding-top:1.3%"><?php echo $linha['num_reg_prof'] ?></td>
																<td style="padding-top:1.3%"><?php echo $linha['nome_fantasia'] ?></td>
																<td style="padding-top:1.5%">
																	<a href="#" data-toggle="modal" data-target="#modalVisualizar<?php echo $linha['id_supervisor'] ?>" style="float:right;"><img src="../view/img/visualizar.png" style="width:20px;height:20px"></a>
																</td>
																<td style="padding-top:1.5%;width:5%">
																	<a href="#" data-toggle="modal" data-target="#modalEditar<?php echo $linha['id_supervisor'] ?>" style="float:right;"><img src="../view/img/editar.png" style="width:20px;height:20px"></a>
																</td>
																<td style="padding-top:1.5%;width:5%">
																	<a href="#" data-toggle="modal" data-target="#modalExcluir<?php echo $linha['id_supervisor'] ?>" style="float:right;"><img src="../view/img/excluir.png" style="width:20px;height:20px"></a>
																</td>
															</tr>

															<!-- Modal Excluir-->
															<div class="modal fade" id="modalExcluir<?php echo $linha['id_supervisor'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog modal-dialog-centered" role="document">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 class="modal-title" id="exampleModalLabel">Excluir Supervisor</h5>
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																				<span aria-hidden="true">&times;</span>
																			</button>
																		</div>
																		<div class="modal-body text-center">
																			<p>O supervisor <strong><?php echo $linha['nome'] ?></strong>, Nº Registro Profissional <strong><?php echo $linha['num_reg_prof']?></strong> será excluído. Deseja prosseguir?</p>
																			<a href="../data_access/coordenador/excluirSupervisor.php?id=<?php echo $linha['id_supervisor'] ?>" class="btn btn-success" style="margin:2%">Sim</a>
																			<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin:2%">Não</button>
																		</div>
																	</div>
																</div>
															</div>
															<!-- Modal Excluir-->

																			<!-- Modal Visualizar-->
																			<div class="modal fade" id="modalVisualizar<?php echo $linha['id_supervisor'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																				<div class="modal-dialog modal-dialog-centered" role="document">
																					<div class="modal-content">
																						<div class="modal-header">
																							<h5 class="modal-title" id="exampleModalLabel"><?php echo $linha['nome'] ?></h5>
																							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																								<span aria-hidden="true">&times;</span>
																							</button>
																						</div>
																						<div class="modal-body">
																							<p><strong>Nome: </strong><?php echo $linha['nome'] ?></p>
																							<p><strong>E-mail: </strong><?php echo $linha['email_supervisor'] ?></p>
																							<p><strong>Nº Registro Profissional: </strong><?php echo $linha['num_reg_prof'] ?></p>
																							<p><strong>Órgão Emissor: </strong><?php echo $linha['orgao_emissor'] ?></p>
																							<p><strong>Cargo: </strong><?php echo $linha['cargo'] ?></p>
																							<p><strong>Formação: </strong><?php echo $linha['formacao'] ?></p>
																							<p><strong>Empresa: </strong><?php echo $linha['nome_fantasia'] ?></p>
																						</div>
																					</div>
																				</div>
																			</div>
																			<!-- Modal Visualizar-->

                                      <!-- Modal Editar-->
                              				<div class="modal fade bd-example-modal-lg" id="modalEditar<?php echo $linha['id_supervisor'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              					<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                              						<div class="modal-content">
                              							<div class="modal-header">
                              								<h5 class="modal-title" id="exampleModalLabel">Editar Supervisor</h5>
                              								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              									<span aria-hidden="true">&times;</span>
                              								</button>
                              							</div>
                              							<div class="modal-body">
                              								<form action="../data_access/coordenador/alterarSupervisor.php" method="post">

                              									<?php include("../data_access/coordenador/listarEmpresas.php"); ?>

                              									<input type="hidden" value="<?php echo $linha['id_supervisor'] ?>" name="id_supervisor" id="id_supervisor">
                              						      <div class="form-group">
																									<label for="nome_supervisor" style="font-weight:bold;">Nome</label>
                              						        <input type="text" name="nome_supervisor" class="form-control" id="nome_supervisor" placeholder="Nome" style="width:80%" value="<?php echo $linha['nome'] ?>">
                              						      </div>
																								<div class="form-group">
																									<label for="email_supervisor" style="font-weight:bold;">E-mail</label>
                              						        <input type="text" name="email_supervisor" class="form-control" id="email_supervisor" placeholder="E-mail" value="<?php echo $linha['email_supervisor'] ?>" style="width:70%">
                              						      </div>
                              						      <div class="form-group">
																									<label for="num_reg_prof" style="font-weight:bold;">Nº Registro profissional</label>
                              						        <input type="text" name="num_reg_prof" class="form-control" id="num_reg_prof" placeholder="Nº Registro Profissional" style="width:30%" value="<?php echo $linha['num_reg_prof'] ?>">
                              						      </div>
                              						      <div class="form-group">
																									<label for="orgao_emissor" style="font-weight:bold;">Orgão emissor</label>
                              						        <input type="text" name="orgao_emissor" class="form-control" id="orgao_emissor" placeholder="Órgão Emissor" style="width:30%" value="<?php echo $linha['orgao_emissor'] ?>">
                              						      </div>
                              						      <div class="form-group">
																									<label for="cargo_supervisor" style="font-weight:bold;">Cargo na empresa</label>
                              						        <input type="text" name="cargo_supervisor" class="form-control" id="cargo_supervisor" placeholder="Cargo na empresa" value="<?php echo $linha['cargo'] ?>" style="width:60%">
                              						      </div>
                              						      <div class="form-group">
																									<label for="formacao_supervisor" style="font-weight:bold;">Formação acadêmica</label>
                              						        <input type="text" name="formacao_supervisor" class="form-control" id="formacao_supervisor" placeholder="Formação acadêmica" value="<?php echo $linha['formacao'] ?>" style="width:70%">
                              						      </div>
																								<div class="form-group">
																									<label for="empresa_supervisor" style="font-weight:bold;">Empresa</label></br>
																					        <select class="form-control" name="empresa_supervisor" id="empresa_supervisor">
																					          <option value="" disabled selected>Empresa</option>
																					          <?php
																					          while($linha_empresa = mysqli_fetch_assoc($_SESSION['result_empresas'])){
																					            ?>
																					            <option value="<?php echo $linha_empresa['id_empresa'] ?>" <?php if($linha['id_empresa']==$linha_empresa['id_empresa']){ echo "selected"; } ?>><?php echo $linha_empresa['nome_fantasia'] ?> / CNPJ: <?php echo $linha['cnpj']?></option>
																					            <?php
																					          }
																					          unset($_SESSION['result_cursos']);
																					          ?>
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
														<?php }?>
													</tbody>
											</table>
				</div>
		</body>

</html>
