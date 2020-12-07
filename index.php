<?php
		@session_start();

		if(isset($_SESSION['id_login']) && $_SESSION['id_login'] != null){
			if(isset($_SESSION['tipo_login']) && $_SESSION['tipo_login']=="supervisor"){
				header('Location: view/supervisor/estagios.php');
			}else{
				header('Location: view/menu.php');
			}
		}
?>﻿
<html>
		<header>
				<meta charset="utf-8">
				<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
				<script src="bootstrap/js/jquery-3.2.1.slim.min.js"></script>
				<script src="bootstrap/js/popper.min.js"></script>
				<script src="bootstrap/js/bootstrap.min.js"></script>
				<title>Coord. Estágio</title>
		</header>

		<body>
			<div id="backgroud">
						<div id="centralizador" style="position:absolute; top:10% ; left:5%; right: 5%">
								<div class="container" style="width:500px">
										<div class="card text-center rounded" style="box-shadow:0px 17px 20px rgba(0,0,0,0.5);">
												<div class="card-header" style="background:#fff;border:none;">
														<img src="view/img/ifba.bmp" style="width:170px;height:170px">
														<h5><strong>Coordenação de Estágio</strong></h5>
												</div>
												<div class="card-body">
														<form action="data_access/login/efetuarLogin.php" method="POST" enctype="multipart/form-data">
																<?php
																		if(isset($_SESSION['erro_login'])){
																				?>
																				<div class="alert alert-danger" role="alert" id="login_invalido">
																						<?php
																							echo $_SESSION['erro_login'];
																							unset($_SESSION['erro_login']);
																						?>
																				</div>
																				<?php
																		}
																?>
																<div class="form-group">
																		<input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="emailHelp" placeholder="Usuário" required>
																</div>
																<div class="form-group">
																		<input type="password" name="senha" class="form-control" id="senha" placeholder="Senha" maxlength="20" required>
																</div>
																<input type="submit" class="btn btn-success" value="ENTRAR" style="width:100%">
																<input type="hidden" name="entrar" value="login">
																</form>
												</div>
												<div class="card-footer text-muted">
														<div style="float:right">
																<a href="#" data-toggle="modal" data-target="#modalLembrarSenha">Esqueceu a senha?</a>
														</div>
												</div>
										</div>
								</div>
			</div>

			<!-- Modal Recuperar-->
			<div class="modal fade" id="modalLembrarSenha" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalCenterTitle">Lembrar Senha</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
							<form action="data_access/login/recuperarSenha.php" method="post" id="formLembrar">
								<div class="form-group">
									<center><img src="view/img/recovery.png" style="width:50px;height:50px;margin-bottom:3%"></center>
									<input type="email" name="emailLembrarSenha" class="form-control" id="emailLembrarSenha" placeholder="E-mail" required>
									<small id="passwordHelpBlock" class="form-text text-muted" style="float:right">A senha será enviada para o seu e-mail</small>
								</div>

								</br>
								<hr>

								<div class="form-group">
									<button type="submit" id="btnLembrar" class="btn btn-info" style="float:right;clear:both;">Enviar</button>
								</div>
								</form>
			      </div>
			    </div>
			  </div>
			</div>

			<?php
				if(isset($_SESSION['recuperado'])){
					unset($_SESSION['recuperado']);
					?>
					<!-- Modal Recuperar Sucesso-->
					<div class="modal fade" id="modalSucesso" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalCenterTitle">Lembrar Senha</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
									<center>
										<p>
											<img src="view/img/recovery.png" style="width:50px;height:50px">
											<img src="view/img/correct.png" style="width:20px;height:20px;position: absolute;margin-top:30px;">
										</p>
										<p>Um e-mail com a nova senha foi enviado para você</p>
									</center>
					      </div>
					    </div>
					  </div>
					</div>

					<script>
						$('#modalSucesso').modal('show');

						setTimeout(function(){
								$('#modalSucesso').modal('hide');
						}, 3000);
					</script>
					<?php
				}elseif(isset($_SESSION['falha_recuperar'])){
					unset($_SESSION['falha_recuperar']);
					?>
					<!-- Modal Recuperar Erro-->
					<div class="modal fade" id="modalErro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalCenterTitle">Lembrar Senha</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
									<center>
										<p>
											<img src="view/img/recovery.png" style="width:50px;height:50px">
											<img src="view/img/wrong.png" style="width:20px;height:20px;position: absolute;margin-top:30px;">
										</p>
										<p>O e-mail informado não existe</p>
									</center>
					      </div>
					    </div>
					  </div>
					</div>
					<script>
						$('#modalErro').modal('show');

						setTimeout(function(){
								$('#modalErro').modal('hide');
						}, 3000);
					</script>
					<?php
				}
			?>

			<script>
				setTimeout(function(){
						var msg = document.getElementById("login_invalido");
						msg.parentNode.removeChild(msg);
				}, 2000);
			</script>
		</body>

</html>
