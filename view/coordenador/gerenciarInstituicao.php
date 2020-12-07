<?php
	@session_start();

	if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
			header('Location: ../../index.php');
	}


	include_once("../data_access/coordenador/buscarInstituicao.php");
	include_once("../data_access/coordenador/buscarCoordenador.php");


?>
<html>
		<header>
				<meta charset="utf-8">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!--<link href="css/simple-sidebar.css" rel="stylesheet">-->
				<title>Coor. Estágio</title>
		</header>

		<body>
			<?php
				if($_SESSION['result_coordenador']['nome'] == null && $_SESSION['result_coordenador']['email'] == null){
					$_SESSION['primeiro_login']=true;
					?>
					<div class="jumbotron" id="jumbo_coord">
						<h1 class="display-4">Bem-vindo(a)</h1>
						<p class="lead">Esse é o sistema de gerenciamento de estágios.</p>
						<hr class="my-4">
						<p>Ainda não temos as informações do (a) coordenador (a)</p>
						<a class="btn btn-success btn" href="?Pagina=conf_acesso" role="button">Cadastrar</a>
					</div>
					<?php
				}else{
					if(mysqli_num_rows($_SESSION['result_instituicao'])==0){
						?>
						<div class="jumbotron" id="jumbo_instituicao">
						  <h1 class="display-4">Estamos quase lá</h1>
						  <hr class="my-4">
						  <p>Ainda não temos as informações da instituição</p>
						  <a class="btn btn-success btn" href="?Pagina=cadastrarInstituicao" role="button">Cadastrar</a>
						</div>
						<?php
					}else{
						$_SESSION['menu_completo']=true;
						?>
						<script>
							$('#menu_coord').css({"pointer-events": "auto", "opacity": "1"});
							$('#menuitem_configAcesso').css({"pointer-events": "auto", "opacity": "1"});
						</script>
						<?php
						while($linha = mysqli_fetch_assoc($_SESSION['result_instituicao'])){ ?>
							<div style="padding-bottom: 1%">
									<h3><span><strong>Instituição</strong></span></h3>
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
								}elseif(isset($_SESSION['sucesso_cadastro'])){
									?>
									<div class="alert alert-success" role="alert">
										<?php
										echo $_SESSION['sucesso_cadastro'];
										unset($_SESSION['sucesso_cadastro']);
										?>
									</div>
									<?php
								}elseif(isset($_SESSION['erro_cadastro'])){
									?>
									<div class="alert alert-danger" role="alert">
										<?php
										echo $_SESSION['erro_cadastro'];
										unset($_SESSION['erro_cadastro']);
										?>
									</div>
									<?php
								}
								?>
							</div>
							<div class="modal-body">
								<form action="../data_access/coordenador/alterarInstituicao.php" method="post" name="form1">

										<input type="hidden" value="<?php echo $linha['id_instituicao'] ?>" name="id_instituicao" id="id_instituicao">
										<input type="hidden" value="<?php echo $linha['id_endereco'] ?>" name="id_endereco" id="id_endereco">
										<div class="form-group">
											<label for="nome_instituicao" style="font-weight:bold;">Nome</label>
											<input type="text" name="nome_instituicao" class="form-control" id="nome_instituicao" placeholder="Nome" style="width:100%;" value="<?php echo $linha['nome'] ?>">
										</div>
										<div class="form-group">
											<label for="cnpj_instituicao" style="font-weight:bold;">CNPJ</label>
											<input type="text" minlength="18" maxlength="18" name="cnpj_instituicao" class="form-control" id="cnpj_instituicao" placeholder="CNPJ" style="width:30%" value="<?php echo $linha['cnpj'] ?>"  >
										</div>

										<div class="form-group">
											<label for="diretor_instituicao" style="font-weight:bold;">Diretor</label>
											<input type="text" name="diretor_instituicao" class="form-control" id="diretor_instituicao" placeholder="Diretor" value="<?php echo $linha['diretor'] ?>" style="width:50%" >
										</div>
										<div class="form-group">
											<label for="portaria_instituicao" style="font-weight:bold;">Nº Portaria</label>
											<input type="text" name="portaria_instituicao" class="form-control" id="portaria_instituicao" placeholder="Portaria" value="<?php echo $linha['portaria'] ?>" style="width:30%">
										</div>

										<hr>

										<span><strong>Contato</strong></span>

										<div class="form-group" style="padding-top:1%">
											<label for="telefone_instituicao" style="font-weight:bold;">Telefone</label>
											<input type="text" minlength="15" maxlength="16" name="telefone_instituicao" class="form-control" id="telefone_instituicao" placeholder="Telefone" style="width:30%" value="<?php echo $linha['telefone'] ?>" >
										</div>

										<hr>

										<span><strong>Endereço</strong></span>

										<div class="form-group" style="padding-top:1%">
											<label for="cidade_endereco" style="font-weight:bold;">Cidade</label>
											<input type="text" name="cidade_endereco" class="form-control" id="cidade_endereco" placeholder="Cidade" value="<?php echo $linha['cidade_endereco'] ?>" style="width:30%" >
										</div>
										<div class="form-group">
											<label for="rua_endereco" style="font-weight:bold;">Rua</label>
											<input type="text" name="rua_endereco" class="form-control" id="rua_endereco" placeholder="Rua" value="<?php echo $linha['rua_endereco'] ?>" style="width:30%" >
										</div>
										<div class="form-group">
											<label for="bairro_endereco" style="font-weight:bold;">Bairro</label>
											<input type="text" name="bairro_endereco" class="form-control" id="bairro_endereco" placeholder="Bairro" value="<?php echo $linha['bairro_endereco'] ?>" style="width:30%" >
										</div>
										<div class="form-group">
											<label for="numero_endereco" style="font-weight:bold;">Número</label>
											<input type="text" name="numero_endereco" class="form-control" id="numero_endereco" placeholder="Número" value="<?php echo $linha['numero_endereco'] ?>" style="width:30%" >
										</div>
										<div class="form-group">
											<label for="estado_endereco" style="font-weight:bold;">Estado</label></br>
											<select class="form-control" name="estado_endereco" id="estado_endereco" style="width:20%">
												<option value=""  selected>Estado</option>
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
												<label for="cep_endereco" style="font-weight:bold;">CEP</label>
												<input type="text" minlength="9" maxlength="9" name="cep_endereco" class="form-control" id="cep_endereco" placeholder="CEP" value="<?php echo $linha['cep_endereco'] ?>" style="width:30%" >
										</div>


										<div style="float:right;padding-bottom:1%">
											<button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelar">Cancelar</button>
											<input type="submit" name="salvar" id="salvar" class="btn btn-success" value="Salvar" id="salvar">
										</div>
									</form>

									<div style="float:right; padding-bottom:1%">
											<button type="button" name="editar" id="editar" class="btn btn-info">Editar Instituição</button>
									</div>
							</div>
							<?php
							}
					}
				}
			?>
				<script>
					$(document).ready(function(){
						$("#cnpj_instituicao").mask("00.000.000/0000-00");
						$("#cep_endereco").mask("00000-000");
						$("#portaria_instituicao").mask("#.##0", {reverse:true});
						$("#telefone_instituicao").mask("(00) 0 0000-0000");
					});

					function habilitaCampos(){
						$("input").prop("disabled",false);
						$("select").prop("disabled",false);
						$("#cancelar").toggle();
						$("#salvar").toggle();
						$("#editar").hide();
						window.scrollTo(0, 0);
					};

					function desabilitaCampos(){
						$("input").prop("disabled",true);
						$("select").prop("disabled",true);
						$("#cancelar").hide();
						$("#salvar").hide();
						window.scrollTo(0, 0);
					};

					window.onload = function (e){
							desabilitaCampos();
					};

					document.getElementById("cancelar").onclick = function(){
						desabilitaCampos();
						$("#editar").toggle();
					};

					document.getElementById("editar").onclick = function(){
						habilitaCampos();
					};
				</script>
		</body>

</html>
