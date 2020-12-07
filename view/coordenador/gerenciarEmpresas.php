<?php
		@session_start();

		if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
				header('Location: ../../index.php');
		}

		include_once("../connection/ConnectionFactory.php");
		include_once("../data_access/coordenador/listarEmpresas.php");


		if(isset($_POST['buscar'])) {
			include_once("../data_access/coordenador/buscarEmpresa.php");
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
						<h3><span><strong>Empresas</strong></span></h3>
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
								<input type="text" name="empresa" class="form-control" id="empresa" placeholder="Buscar Empresa">
						</div>
						<div style="float:left; padding-left: 1%; padding-top: 8px">
								<img src="img/search.png">
						</div>
						<input type="hidden" name="buscar" value="busca">
				</form>

				<div style="float:right">
						<a href="?Pagina=cadastrarEmpresa" class="btn btn-success" role="button">Cadastrar Empresa</a>
				</div>

				</br>
				</br>
				<div id="tabela_empresas">
						<table class="table table-sm table-hover" id="tabela_empresas">
												<thead>
													<tr>
														<th scope="col">Nome Fantasia</th>
														<th scope="col">CNPJ</th>
														<th scope="col">Telefone</th>
														<th></th>
														<th></th>
														<th></th>
													</tr>
												</thead>
												<tbody>
														<?php while($linha = mysqli_fetch_assoc($_SESSION['result_empresas'])){ ?>
															<tr>
																<td style="padding-top:1.3%"><?php echo $linha['nome_fantasia'] ?></td>
																<td style="padding-top:1.3%"><?php echo $linha['cnpj'] ?></td>
																<td style="padding-top:1.3%"><?php echo $linha['telefone'] ?></td>
																<td style="padding-top:1.5%">
																	<a href="#" data-toggle="modal" data-target="#modalVisualizar<?php echo $linha['id_empresa'] ?>" style="float:right;"><img src="../view/img/visualizar.png" style="width:20px;height:20px"></a>
																</td>
																<td style="padding-top:1.5%;width:5%">
																	<a href="#" data-toggle="modal" data-target="#modalEditar<?php echo $linha['id_empresa'] ?>" style="float:right;"><img src="../view/img/editar.png" style="width:20px;height:20px"></a>
																</td>
																<td style="padding-top:1.5%;width:5%">
																	<a href="#" data-toggle="modal" data-target="#modalExcluir<?php echo $linha['id_empresa'] ?>" style="float:right;"><img src="../view/img/excluir.png" style="width:20px;height:20px"></a>
																</td>
															</tr>

															<!-- Modal Excluir-->
															<div class="modal fade" id="modalExcluir<?php echo $linha['id_empresa'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog modal-dialog-centered" role="document">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 class="modal-title" id="exampleModalLabel">Excluir Empresa</h5>
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																				<span aria-hidden="true">&times;</span>
																			</button>
																		</div>
																		<div class="modal-body text-center">
																			<p>A empresa <strong><?php echo $linha['nome_fantasia'] ?></strong>, CNPJ <strong><?php echo $linha['cnpj']?></strong> será excluída. Deseja prosseguir?</p>
																			<a href="../data_access/coordenador/excluirEmpresa.php?id=<?php echo $linha['id_empresa'] ?>" class="btn btn-success" style="margin:2%">Sim</a>
																			<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin:2%">Não</button>
																		</div>
																	</div>
																</div>
															</div>
															<!-- Modal Excluir-->

																			<!-- Modal Visualizar-->
																			<div class="modal fade" id="modalVisualizar<?php echo $linha['id_empresa'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																				<div class="modal-dialog" role="document">
																					<div class="modal-content">
																						<div class="modal-header">
																							<h5 class="modal-title" id="exampleModalLabel"><?php echo $linha['nome_fantasia'] ?></h5>
																							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																								<span aria-hidden="true">&times;</span>
																							</button>
																						</div>
																						<div class="modal-body">
																							<p><strong>Nome Fantasia: </strong><?php echo $linha['nome_fantasia'] ?></p>
																							<p><strong>Razão Social: </strong><?php echo $linha['razao_social'] ?></p>
																							<p><strong>Tipo de Empregador: </strong><?php echo $linha['tipo_empregador'] ?></p>
																							<p><strong>CNPJ: </strong><?php echo $linha['cnpj'] ?></p>
																							<p><strong>Representante Legal: </strong><?php echo $linha['representante_legal'] ?></p>

																							<hr>

																				      <p><strong>Endereço</strong></p>
																							<p><strong>Cidade: </strong><?php echo $linha['cidade'] ?></p>
																							<p><strong>Estado: </strong><?php echo $linha['estado'] ?></p>
																							<p><strong>Bairro: </strong><?php echo $linha['bairro'] ?></p>
																							<p><strong>Rua: </strong><?php echo $linha['rua']?></p>
																							<p><strong>Nº: </strong><?php echo $linha['numero']?></p>
																							<p><strong>Cep: </strong><?php echo $linha['cep'] ?></p>

																							<hr>

																				      <p><strong>Contato</strong></p>
																							<p><strong>E-mail: </strong><?php echo $linha['email'] ?></p>
																							<p><strong>Telefone: </strong><?php echo $linha['telefone'] ?></p>
																						</div>
																					</div>
																				</div>
																			</div>
																			<!-- Modal Visualizar-->

																			<!-- Modal Editar-->
																			<div class="modal fade bd-example-modal-lg" id="modalEditar<?php echo $linha['id_empresa'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																				<div class="modal-dialog modal-lg" role="document">
																					<div class="modal-content">
																						<div class="modal-header">
																							<h5 class="modal-title" id="exampleModalLabel">Editar Empresa</h5>
																							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																								<span aria-hidden="true">&times;</span>
																							</button>
																						</div>
																						<div class="modal-body">
																							<form action="../data_access/coordenador/alterarEmpresa.php" method="post">
																								<input type="hidden" value="<?php echo $linha['id_empresa'] ?>" name="id_empresa" id="id_empresa">
																								<input type="hidden" value="<?php echo $linha['id_endereco'] ?>" name="id_endereco" id="id_endereco">
																								<div class="form-group">
																									<label for="nome_fantasia" style="font-weight:bold;">Nome fantasia</label>
																	                <input type="text" name="nome_fantasia" class="form-control" id="nome_fantasia" placeholder="Nome Fantasia" style="width:90%" value="<?php echo $linha['nome_fantasia'] ?>">
																	              </div>
																	              <div class="form-group">
																									<label for="razao_social" style="font-weight:bold;">Razão Social</label>
																	                <input type="text" name="razao_social" class="form-control" id="razao_social" placeholder="Razão Social" style="width:60%" value="<?php echo $linha['razao_social'] ?>">
																	              </div>
																	              <div class="form-group">
																									<label for="tipo_empregador" style="font-weight:bold;">Tipo de empregador</label>
																	                <input type="text" name="tipo_empregador" class="form-control" id="tipo_empregador" placeholder="Tipo de Empregador" style="width:40%" value="<?php echo $linha['tipo_empregador'] ?>">
																	              </div>
																	              <div class="form-group">
																									<label for="cnpj_empresa" style="font-weight:bold;">CNPJ</label>
																	                <input type="text" minlength="18" maxlength="18" name="cnpj_empresa" class="form-control" id="cnpj_empresa<?php echo $linha['id_empresa'] ?>" placeholder="CNPJ" style="width:30%" value="<?php echo $linha['cnpj'] ?>">
																	              </div>
																	              <div class="form-group">
																									<label for="representante_legal" style="font-weight:bold;">Representante legal</label>
																	                <input type="text" name="representante_legal" class="form-control" id="representante_legal" placeholder="Representante Legal" style="width:80%" value="<?php echo $linha['representante_legal'] ?>">
																	              </div>

																	              <hr>

																	              <strong><span>Endereço</span></strong>

																	              <div class="form-group" style="padding-top:1%">
																									<label for="cidade_empresa" style="font-weight:bold;">Cidade</label>
																	                <input type="text" name="cidade_empresa" class="form-control" id="cidade_empresa" placeholder="Cidade" style="width:50%" value="<?php echo $linha['cidade'] ?>">
																	              </div>
																	              <div class="form-group">
																									<label for="estado_empresa" style="font-weight:bold;">Estado</label></br>
																	                <select class="form-control" name="estado_empresa" id="estado_empresa" style="width:20%">
																										<option value="" disabled selected>Estado</option>
																					          <option value="AC" <?php if($linha['estado']=="AC"){ echo "selected"; } ?>>AC</option>
																					          <option value="AL" <?php if($linha['estado']=="AL"){ echo "selected"; } ?>>AL</option>
																					          <option value="AP" <?php if($linha['estado']=="AP"){ echo "selected"; } ?>>AP</option>
																					          <option value="AM" <?php if($linha['estado']=="AM"){ echo "selected"; } ?>>AM</option>
																					          <option value="BA" <?php if($linha['estado']=="BA"){ echo "selected"; } ?>>BA</option>
																					          <option value="CE" <?php if($linha['estado']=="CE"){ echo "selected"; } ?>>CE</option>
																					          <option value="DF" <?php if($linha['estado']=="DF"){ echo "selected"; } ?>>DF</option>
																					          <option value="ES" <?php if($linha['estado']=="ES"){ echo "selected"; } ?>>ES</option>
																					          <option value="GO" <?php if($linha['estado']=="GO"){ echo "selected"; } ?>>GO</option>
																					          <option value="MA" <?php if($linha['estado']=="MA"){ echo "selected"; } ?>>MA</option>
																					          <option value="MT" <?php if($linha['estado']=="MT"){ echo "selected"; } ?>>MT</option>
																					          <option value="MS" <?php if($linha['estado']=="MS"){ echo "selected"; } ?>>MS</option>
																					          <option value="MG" <?php if($linha['estado']=="MG"){ echo "selected"; } ?>>MG</option>
																					          <option value="PA" <?php if($linha['estado']=="PA"){ echo "selected"; } ?>>PA</option>
																					          <option value="PB" <?php if($linha['estado']=="PB"){ echo "selected"; } ?>>PB</option>
																					          <option value="PR" <?php if($linha['estado']=="PR"){ echo "selected"; } ?>>PR</option>
																					          <option value="PE" <?php if($linha['estado']=="PE"){ echo "selected"; } ?>>PE</option>
																					          <option value="PI" <?php if($linha['estado']=="PI"){ echo "selected"; } ?>>PI</option>
																					          <option value="RJ" <?php if($linha['estado']=="RJ"){ echo "selected"; } ?>>RJ</option>
																					          <option value="RN" <?php if($linha['estado']=="RN"){ echo "selected"; } ?>>RN</option>
																					          <option value="RS" <?php if($linha['estado']=="RS"){ echo "selected"; } ?>>RS</option>
																					          <option value="RO" <?php if($linha['estado']=="RO"){ echo "selected"; } ?>>RO</option>
																					          <option value="RR" <?php if($linha['estado']=="RR"){ echo "selected"; } ?>>RR</option>
																					          <option value="SC" <?php if($linha['estado']=="SC"){ echo "selected"; } ?>>SC</option>
																					          <option value="SP" <?php if($linha['estado']=="SP"){ echo "selected"; } ?>>SP</option>
																					          <option value="SE" <?php if($linha['estado']=="SE"){ echo "selected"; } ?>>SE</option>
																					          <option value="TO" <?php if($linha['estado']=="TO"){ echo "selected"; } ?>>TO</option>
																					        </select>
																	              </div>
																	              <div class="form-group">
																									<label for="bairro_empresa" style="font-weight:bold;">Bairro</label>
																	                <input type="text" name="bairro_empresa" class="form-control" id="bairro_empresa" placeholder="Bairro" style="width:50%" value="<?php echo $linha['bairro'] ?>">
																	              </div>
																	              <div class="form-group">
																									<label for="rua_empresa" style="font-weight:bold;">Rua</label>
																	                <input type="text" name="rua_empresa" class="form-control" id="rua_empresa" placeholder="Rua" style="width:50%" value="<?php echo $linha['rua'] ?>">
																	              </div>
																	              <div class="form-group">
																									<label for="numero_endereco_empresa" style="font-weight:bold;">Número</label>
																	                <input type="text" name="numero_endereco_empresa" class="form-control" id="numero_endereco_empresa" placeholder="Número" style="width:10%" value="<?php echo $linha['numero'] ?>">
																	              </div>
																	              <div class="form-group">
																									<label for="cep_empresa" style="font-weight:bold;">CEP</label>
																	                <input type="text" minlength="9" maxlength="9" name="cep_empresa" class="form-control" id="cep_empresa<?php echo $linha['id_empresa'] ?>" placeholder="Cep" style="width:20%" value="<?php echo $linha['cep'] ?>">
																	              </div>

																	              <hr>

																	              <strong><span>Contato</span></strong>

																	              <div class="form-group" style="padding-top:1%">
																									<label for="email_empresa" style="font-weight:bold;">E-mail</label>
																	                <input type="email" name="email_empresa" class="form-control" id="email_empresa" placeholder="E-mail" style="width:50%" value="<?php echo $linha['email'] ?>">
																	              </div>
																	              <div class="form-group">
																									<label for="telefone_empresa" style="font-weight:bold;">Telefone</label>
																	                <input type="text" minlength="15" maxlength="16" name="telefone_empresa" class="form-control" id="telefone_empresa<?php echo $linha['id_empresa'] ?>" placeholder="Telefone" style="width:30%" value="<?php echo $linha['telefone'] ?>">
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

																			<script>
																				$("#cnpj_empresa<?php echo $linha['id_empresa'] ?>").mask("00.000.000/0000-00");
															          $("#cep_empresa<?php echo $linha['id_empresa'] ?>").mask("00000-000");
															          $("#telefone_empresa<?php echo $linha['id_empresa'] ?>").mask("(00) 0 0000-0000");
																			</script>
														<?php }?>
													</tbody>
											</table>
				</div>
		</body>

</html>
