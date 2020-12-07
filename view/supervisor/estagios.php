<?php
    @session_start();

    if(isset($_SESSION['tipo_login']) && $_SESSION['tipo_login'] != "supervisor"){
      header('Location: ../menu.php');
    }else{
      if(@$_GET['token'] != null){
        if(isset($_SESSION['token'])){

            if(@$_GET['token'] != $_SESSION['token']){
              unset($_SESSION['token']);
              unset($_SESSION['id_login']);
              unset($_SESSION['tipo_login']);

              $_SESSION['token'] = @$_GET['token'];
            }

        }else{
          $_SESSION['token'] = @$_GET['token'];
        }
      }

      include_once("../../data_access/supervisor/buscarSupervisor.php");
      $supervisor = mysqli_fetch_assoc($_SESSION['result_supervisor']);


      if($supervisor == null){
        header('Location: ../../index.php');
      }else{
        $_SESSION['id_supervisor']=$supervisor['id_supervisor'];

        include_once("../../data_access/supervisor/listarEstagios.php");

        if(isset($_POST['buscar'])){
          include_once("../../data_access/supervisor/buscarEstagio.php");
        }

        include_once("../../data_access/coordenador/buscarInstituicao.php");
        $instituicao = mysqli_fetch_assoc($_SESSION['result_instituicao']);
      }
    }
?>
<html>
		<header>
				<meta charset="utf-8">
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/supervisor.css">
				<script src="../../bootstrap/js/jquery-3.2.1.slim.min.js"></script>
				<script src="../../bootstrap/js/popper.min.js"></script>
				<script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../view/js/jquery.min.js"></script>
      	<script src="../js/jquery.mask.min.js"></script>
				<title>Coord. Estágio</title>
		</header>

    <body>
      <div class="row" style="background:#2E2E2E;color:#fff;">
        <div class="col-xs">
          <a href="#" style="text-decoration:none" data-toggle="modal" data-target="#modalInfoInstituicao">
            <img class="rounded-circle" src="../img/ifba.bmp" style="width:60px; height:60px;margin:10px;margin-left:40px">
          </a>
        </div>

        <a href="#"  id="div_supervisor" data-toggle="modal" data-target="#modalInfoSupervisor">
          <div class="col-xs" style="margin-left:15px;margin-top:35px">
            <p style="background:#151515;margin-bottom:20px;padding:5px;width:220px;height:35px;border-radius: 25px;float:right;text-align:center">
              <span>
                <?php
                $str = $supervisor['nome'];
                echo 'Painel de '.explode(' ', $str)[0];
                ?>
              </span>
            </p>
        </div>
        </a>

        <div class="col">
          <a href="../../data_access/login/efetuarLogout.php" id="logout" style="color:#FE2E2E;text-decoration:none;float:right;padding:10px"><img src="../img/logout.png" style="padding-bottom:6px;"> SAIR</a>
          <a href="#" id="config" style="float:right;padding:10px" data-toggle="modal" data-target="#modalAlterarAcesso"><img src="../img/config.png" style="padding-bottom:6px"> CONFIGURAÇÕES</a>
        </div>
      </div>

      <!-- Modal Login -->
      <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="card text-center">
              <div class="card-header" style="background:#fff;border:none;">
                  <img src="../../view/img/ifba.bmp" style="width:170px;height:170px">
                  <h5><strong>Coordenação de Estágio</strong></h5>
              </div>
              <div class="card-body">
                <form action="../../data_access/supervisor/validarToken.php" method="POST" enctype="multipart/form-data">
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
                    <input type="hidden" value="<?php echo $supervisor['id_supervisor']; ?>" name="id_supervisor">
                    <div class="form-group text-left">
                        <input type="password" name="senha_token" class="form-control" id="senha_token" placeholder="Senha do Token" maxlength="20" required>
                    </div>
                    <input type="submit" class="btn btn-success" value="ENTRAR" style="width:100%">
                    <input type="hidden" name="entrar" value="login">
                  </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
        if(!isset($_SESSION['id_login'])){
          ?>
          <script>
            $('#modalLogin').modal('show');
          </script>
          <?php
        }
      ?>


        <div id="backgroud" class="container-fluid">
            <div id"tabela" style="display:<?php if(!isset($_SESSION['id_login'])){ echo "none"; }else{ echo "block"; } ?>">
              <div style="padding-bottom: 1%; margin-top:2%;">
      						<h3><span><strong>Estágios supervisionados por você</strong></span></h3>
      				</div>

              <?php
                if($_SESSION['result_estagios']->num_rows == 0){
                  ?>
                  <div class="alert alert-warning" role="alert">
                    Ainda não há estágios
                  </div>
                  <?php
                }

                if(isset($_SESSION['sucesso_editar'])) {
                  ?>
                  <div class="alert alert-success" role="alert" id="mensagem_alerta">
                    <?php
                    echo $_SESSION['sucesso_editar'];
                    unset($_SESSION['sucesso_editar']);
                    ?>
                  </div>
                  <?php
                }
              ?>
              <?php
              if($_SESSION['result_estagios']->num_rows > 0){
                ?>
                <form action="" method="post">
              		<div class="form-group" style="float:left; width:60%">
              			<input type="text" name="estagio" class="form-control" id="estagio" placeholder="Buscar Estágio">
              		</div>
              		<div style="float:left; padding-left: 1%; padding-top: 8px">
              			<img src="../img/search.png">
              		</div>
              		<input type="hidden" name="buscar" value="buscar">
              	</form>
                </br>
                <hr>
                <table class="table table-sm table-hover" id="tabela_cursos">
              		<thead>
              			<tr>
              				<th scope="col">Aluno</th>
              				<th scope="col">Matrícula</th>
                      <th scope="col">Curso</th>
                      <th scope="col">E-mail</th>
                      <th></th>
              			</tr>
              		</thead>
              		<tbody>
                    <?php
                      while($estagio = mysqli_fetch_assoc($_SESSION['result_estagios'])){
                        ?>
                        <tr>
                					<td style="padding-top:1.3%"><?php echo $estagio['nome_aluno'] ?></td>
                					<td style="padding-top:1.3%"><?php echo $estagio['matricula'] ?></td>
                          <td style="padding-top:1.3%"><?php echo $estagio['nome_curso'] ?></td>
                          <td style="padding-top:1.3%"><?php echo $estagio['email'] ?></td>
                					<td style="padding-top:1.5%">
                						<a href="#" id="btnAvaliacao<?php echo $estagio['id_av_empresa'] ?>"  data-toggle="modal" data-target="#modalAvEmpresa<?php echo $estagio['id_estagio'] ?>" style="float:right;"><img src="../../view/img/avaliar.png" style="width:20px;height:20px"></a>
                					</td>
                				</tr>

                        <!-- Modal Avaliacao-->
                				<div class="modal fade bd-example-modal-lg" id="modalAvEmpresa<?php echo $estagio['id_estagio'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                					<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                						<div class="modal-content">
                							<div class="modal-header">
                								<h5 class="modal-title" id="exampleModalLabel">Avaliacação de <?php echo $estagio['nome_aluno'] ?></h5>
                								<a class="close" data-dismiss="modal" aria-label="Close">
                									<span aria-hidden="true">&times;</span>
                								</a>
                							</div>
                							<div class="modal-body">
                                <?php
                                  if($estagio['encerrado']) {
                                    ?>
                                    <div class="alert alert-warning" role="alert">
                                      A avaliação está encerrada e não pode ser editada.
                                    </div>
                                    <?php
                                  }
                                ?>

                								<form action="../../data_access/supervisor/editarAvaliacaoEmpresa.php" method="post" id="formAvaliacao<?php echo $estagio['id_estagio'] ?>">
                                  <input type="hidden" name="id_av_empresa" id="id_av_empresa" value="<?php echo $estagio['id_av_empresa'] ?>">
                                  <input type="hidden" name="id_estagio" id="id_estagio" value="<?php echo $estagio['id_estagio'] ?>">
                                  <input type="hidden" name="av_encerrado" id="<?php echo $estagio['id_av_empresa'] ?>av_encerrado" value="<?php echo $estagio['encerrado'] ?>">

                                  <div style="padding-bottom: 1%;">
                          						<h6><span><strong>Aspectos Profissionais</strong></span></h6>
                          				</div>

                                  <small>(Atribuir uma nota de 0 a 10 para cada critério)</small>

                                  <div class="form-group" style="padding-top:2%">
                                    <label for="av_profissional_1" style="font-weight:bold;">Qualidade no trabalho</label>
                                    <small>(organização, segurança, dedicação, e apresentação do trabalho)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_profissional_1" name="av_profissional_1" value="<?php echo $estagio['av_profissional_1'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="av_profissional_2" style="font-weight:bold;">Criatividade</label>
                                    <small>(capacidade de encontrar novas e melhores formas no desempenho das atividades)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_profissional_2" name="av_profissional_2" value="<?php echo $estagio['av_profissional_2'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="av_profissional_3" style="font-weight:bold;">Conhecimentos</label>
                                    <small>(nível de conhecimento demonstrado no desenvolvimento das atividades)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_profissional_3" name="av_profissional_3" value="<?php echo $estagio['av_profissional_3'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="av_profissional_4" style="font-weight:bold;">Cumprimento das tarefas</label>
                                    <small>(capacidade de executar tarefas de acordo com as metas e prazos)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_profissional_4" name="av_profissional_4" value="<?php echo $estagio['av_profissional_4'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="av_profissional_5" style="font-weight:bold;">Iniciativa</label>
                                    <small>(autonomia no desempenho de suas atividades e disposição para adquirir novos conhecimentos)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_profissional_5" name="av_profissional_5" value="<?php echo $estagio['av_profissional_5'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="nota_profissional" style="font-weight:bold;">Nota de Aspectos Profissionais</label>
                                    <input type="text" id="<?php echo $estagio['id_av_empresa'] ?>nota_profissional" name="nota_profissional" value="<?php echo $estagio['nota_profissional'] ?>" style="width:60px" disabled>
                                    <small>(Soma das notas de cada critério/10)</small>
                                  </div>
                                  <input type="hidden" name="notaPro" id="<?php echo $estagio['id_av_empresa'] ?>notaPro" value="<?php echo $estagio['nota_profissional'] ?>">

                                  <hr>

                                  <div style="padding-bottom: 1%;">
                          						<h6><span><strong>Aspectos Humanos</strong></span></h6>
                          				</div>

                                  <small>(Atribuir uma nota de 0 a 10 para cada critério)</small>

                                  <div class="form-group" style="padding-top:2%">
                                    <label for="av_humano_1" style="font-weight:bold;">Cooperação</label>
                                    <small>(disposição para contribuir espontaneamente no trabalho de equipe, para atingir os objetivos)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_humano_1" name="av_humano_1" value="<?php echo $estagio['av_humano_1'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="av_humano_2" style="font-weight:bold;">Responsabilidade</label>
                                    <small>(assiduidade no trabalho e zelo pelos materiais, equipamentos e bens da empresa)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_humano_2" name="av_humano_2" value="<?php echo $estagio['av_humano_2'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="av_humano_3" style="font-weight:bold;">Sociabilidade</label>
                                    <small>(facilidade de se integrar com os colegas em ambiente de trabalho)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_humano_3" name="av_humano_3" value="<?php echo $estagio['av_humano_3'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="av_humano_4" style="font-weight:bold;">Disciplina</label>
                                    <small>(observancia e cumprimento das normas e regulamentos da empresa)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_humano_4" name="av_humano_4" value="<?php echo $estagio['av_humano_4'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="av_humano_5" style="font-weight:bold;">Autocrítica</label>
                                    <small>(capacidade de reconhecer seus próprios erros e limitações)</small>
                                    <input type="text" maxlength="3" id="<?php echo $estagio['id_av_empresa'] ?>av_humano_5" name="av_humano_5" value="<?php echo $estagio['av_humano_5'] ?>" style="width:60px">
                                  </div>

                                  <div class="form-group">
                                    <label for="nota_humano" style="font-weight:bold;">Nota de Aspectos Humanos</label>
                                    <input type="text" id="<?php echo $estagio['id_av_empresa'] ?>nota_humano" name="nota_humano" value="<?php echo $estagio['nota_humano'] ?>" style="width:60px" disabled>
                                    <small>(Soma das notas de cada critério/10)</small>
                                  </div>
                                  <input type="hidden" name="notaHum" id="<?php echo $estagio['id_av_empresa'] ?>notaHum" value="<?php echo $estagio['nota_humano'] ?>">

                                  <hr>

                                  <div class="form-group">
                                    <label for="nota_final" style="font-weight:bold;">Nota Final</label>
                                    <input type="text" id="<?php echo $estagio['id_av_empresa'] ?>nota_final" name="nota_final" value="<?php echo $estagio['nota_final'] ?>" style="width:60px" disabled>
                                    <small>(Soma das notas dos dois aspectos)</small>
                                  </div>
                                  <input type="hidden" name="notaFinal" id="<?php echo $estagio['id_av_empresa'] ?>notaFinal" value="<?php echo $estagio['nota_final'] ?>">

                                  <div class="form-group">
                                    <label for="observacao" style="font-weight:bold;">Comentários e observações</label>
                                    <textarea class="form-control" id="<?php echo $estagio['id_av_empresa'] ?>observacao" name="observacao" rows="6"><?php echo $estagio['observacao'] ?></textarea>
                                  </div>

                                  <span><font color="red">*Ao encerrar o documento, este não poderá mais ser editado por nenhum usuário.</font></span>

                                  <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="<?php echo $estagio['id_av_empresa'] ?>check_encerrar" name="check_encerrar" <?php if($estagio['encerrado']){echo "checked";} ?>>
                                    <label class="form-check-label" for="check_encerrar" style="font-weight:bold;">Encerrar Avaliação</label>
                                  </div>

                                  <div style="float:right;">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" name="salvar" id="<?php echo $estagio['id_av_empresa'] ?>salvar" class="btn btn-success" value="Salvar">
                                  </div>
                								</form>
                							</div>
                						</div>
                					</div>
                				</div>
                				<!-- Modal Avaliacao-->

                        <script>
                          $('#formAvaliacao<?php echo $estagio['id_estagio'] ?> input').prop("required","false");
                          $('#btnAvaliacao<?php echo $estagio['id_av_empresa'] ?>').on('click', function (){
                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_encerrado').val()==true){
                              $('#modalAvEmpresa<?php echo $estagio['id_estagio'] ?> textarea',).prop("disabled",true);
                              $('#modalAvEmpresa<?php echo $estagio['id_estagio'] ?> input',).prop("disabled",true);
                              $('#modalAvEmpresa<?php echo $estagio['id_estagio'] ?> button',).hide();
                              $('#<?php echo $estagio['id_av_empresa'] ?>salvar').hide();
                            }
                          });

                          jQuery.fn.removeNot = function( settings ){
                      			var $this = jQuery( this );
                      			var defaults = {
                      				pattern: /[^0-9]/,
                      				replacement: ''
                      			}
                      			settings = jQuery.extend(defaults, settings);

                      			$this.keyup(function(){
                      				var new_value = $this.val().replace( settings.pattern, settings.replacement );
                      				$this.val( new_value );
                      			});
                      			return $this;
                      		}

                      		String.prototype.replaceAt=function(index, replacement) {
                      	    return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
                      		}

                      		function validaPontos(valor) {
                      			var quantidadeDePontos = 0;
                      			for (var i = 0; i < valor.length; i++) {
                      				if (valor[i] === '.') {
                      					quantidadeDePontos++;
                      				}
                      			}
                      			return quantidadeDePontos;
                      		}

                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1").val($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});

                          $("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2").val($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});

                          $("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3").val($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});

                          $("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4").val($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});

                          $("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5").val($("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});

                          $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_1").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_1").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_1").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_1").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_1").val($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_1").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_1").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});

                          $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_2").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_2").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_2").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_2").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_2").val($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_2").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_2").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});

                          $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_3").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_3").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_3").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_3").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_3").val($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_3").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_3").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});

                          $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_4").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_4").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_4").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_4").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_4").val($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_4").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_4").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});

                          $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_5").removeNot({ pattern: /[^0-9.]+/g });
                      		$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_5").bind('input propertychange',function(e){
                      			if(parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_5").val()) > 10 || parseFloat($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_5").val()) < 0){
                      				$("#<?php echo $estagio['id_av_empresa'] ?>av_humano_5").val($("#<?php echo $estagio['id_av_empresa'] ?>av_humano_5").val().substr(0, $("#<?php echo $estagio['id_av_empresa'] ?>av_humano_5").val().length-1));
                      			}

                      			var valor = this.value;
                      			var pattern = /\.(?=[^.]*$)/;

                      			if (validaPontos(valor) >= 2) {
                      				this.value = valor.replace(pattern, "");
                      			}
                      		});





                          //CONTROLE DO CAMPO DE NOTA PROFISSIONAL

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaPro').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaPro').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaPro').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaPro').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_profissional_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaPro').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });


                          //CONTROLE DO CAMPO DE NOTA HUMANO

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaHum').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaHum').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaHum').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaHum').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });

                          $('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').blur(function(){
                            let av1;
                            let av2;
                            let av3;
                            let av4;
                            let av5;

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val() != ""){
                              av1 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_1').val());
                            }else {
                              av1 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val() != ""){
                              av2 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_2').val());
                            }else {
                              av2 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val() != ""){
                              av3 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_3').val());
                            }else {
                              av3 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val() != ""){
                              av4 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_4').val());
                            }else {
                              av4 = 0;
                            }

                            if($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val() != ""){
                              av5 = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>av_humano_5').val());
                            }else {
                              av5 = 0;
                            }

                            let resultado = (av1+av2+av3+av4+av5)/10;

                            $('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val(resultado);
                            $('#<?php echo $estagio['id_av_empresa'] ?>notaHum').val(resultado);

                            let nota_pro = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_profissional').val());
                            let nota_humano = parseFloat($('#<?php echo $estagio['id_av_empresa'] ?>nota_humano').val());

                            let nota_final = nota_pro+nota_humano;

                            if(isNaN(nota_final)==false){
                              $('#<?php echo $estagio['id_av_empresa'] ?>nota_final').val(nota_final);
                              $('#<?php echo $estagio['id_av_empresa'] ?>notaFinal').val(nota_final);
                            }
                          });
                        </script>
                        <?php
                      }
                    ?>
              		</tbody>
              	</table>
                <?php
              }
              ?>
            </div>

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
                    <p><strong>Nome: </strong><?php echo $instituicao['nome'] ?></p>
                    <p><strong>CNPJ: </strong><?php echo $instituicao['cnpj'] ?></p>
                    <p><strong>Diretor: </strong><?php echo $instituicao['diretor'] ?></p>
                    <p><strong>Nº Portaria: </strong><?php echo $instituicao['portaria'] ?></p>

                    <hr>

                    <strong><span>Telefone</span></strong>
                    <p style="padding-top:1%"><?php echo $instituicao['telefone'] ?></p>

                    <hr>

                    <strong><span>Endereço</span></strong>
                    <p style="padding-top:1%">
                      <?php echo $instituicao['rua'].', '.$instituicao['numero'].', '.$instituicao['bairro'].', CEP: '.$instituicao['cep'].', '.$instituicao['cidade'].', '.$instituicao['estado']; ?>
                    </p>
    							</div>
    						</div>
    					</div>
    				</div>


            <!-- Modal Informações Supervisor-->
    				<div class="modal fade bd-example-modal-lg" id="modalInfoSupervisor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    					<div class="modal-dialog modal-dialog-centered" role="document">
    						<div class="modal-content">
    							<div class="modal-header">
    								<h5 class="modal-title" id="exampleModalLabel">Informações de <?php echo $supervisor['nome']; ?></h5>
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    									<span aria-hidden="true">&times;</span>
    								</button>
    							</div>
    							<div class="modal-body">
                    <p><strong>Empresa: </strong><?php echo $supervisor['nome_empresa'] ?></p>
                    <p><strong>Nº Registro Profissional: </strong><?php echo $supervisor['num_reg_prof'] ?></p>
                    <p><strong>Órgão Emissor: </strong><?php echo $supervisor['orgao_emissor'] ?></p>
                    <p><strong>Cargo: </strong><?php echo $supervisor['cargo'] ?></p>
                    <p><strong>Formação: </strong><?php echo $supervisor['formacao'] ?></p>
                    <p><strong>E-mail: </strong><?php echo $supervisor['email'] ?></p>
    							</div>
    						</div>
    					</div>
    				</div>


            <!-- Modal Alterar Acessos-->
    				<div class="modal fade bd-example-modal-lg" id="modalAlterarAcesso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    					<div class="modal-dialog" role="document">
    						<div class="modal-content">
    							<div class="modal-header">
    								<h5 class="modal-title" id="exampleModalLabel">Configurações do Supervisor</h5>
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    									<span aria-hidden="true">&times;</span>
    								</button>
    							</div>
    							<div class="modal-body">
                    <form action="../../data_access/supervisor/editarSupervisor.php" method="post">
                      <input type="hidden" name="id_supervisor" value="<?php echo $supervisor['id_supervisor'] ?>">
                      <input type="hidden" name="editar_email" value="true">
                      <div class="form-group">
                        <label for="email" style="font-weight:bold;">E-mail</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" value="<?php echo $supervisor['email_supervisor'] ?>" required>
                      </div>

                      <div class="form-group">
                        <input type="submit" name="editar_email" id="editar_email" class="btn btn-success" value="Salvar" style="float:right">
                      </div>
                    </form>

                    </br>
                    </br>
                    <hr>

    								<form action="../../data_access/supervisor/editarSupervisor.php" method="post">
                      <input type="hidden" name="id_supervisor" value="<?php echo $supervisor['id_supervisor'] ?>">
                      <input type="hidden" name="senha_antiga" id="senha_antiga" value="<?php echo $supervisor['byPass_token'] ?>">

                      <div class="row" id="row_password_atual" style="width:350px;padding-top:1%">
                        <div class="col">
                          <label for="senha_atual" style="font-weight:bold;">Acesso</label>
                          <input type="password" name="senha_atual" id="senha_atual" class="form-control" placeholder="Senha Atual" maxlength="20" requried>
                        </div>
                        <div id="match_atual" class="col" style="display:none;padding-top:6%">
                          <p id="combina_atual"><img src="../img/correct.png" style="width:18px;height:18px;"></p>
                        </div>
                        <div id="no_match_atual" class="col" style="display:none;padding-top:6%">
                          <p id="nao_combina_atual"><img src="../img/wrong.png" style="width:18px;height:18px;"></p>
                        </div>
                      </div>


                      <div class="form-group row" style="padding-top: 3%;width: 350px">
                        <div class="col">
                          <input type="password" name="nova_senha" id="nova_senha" class="form-control" placeholder="Nova Senha" minlength="8" maxlength="20" required>
                          <small id="passwordHelpBlock" class="form-text text-muted" style="float:right">A senha deve conter 8-20 caracteres</small>
                        </div>
                      </div>
                      <div class="row" id="row_password" style="width:350px;">
                        <div class="col">
                          <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" placeholder="Confirmar Senha" maxlength="20" required>
                        </div>
                        <div id="match" class="col" style="display:none;padding-top:1.5%">
                          <p id="combina"><img src="../img/correct.png" style="width:18px;height:18px;"></p>
                        </div>
                        <div id="no_match" class="col" style="display:none;padding-top:1.5%">
                          <p id="nao_combina"><img src="../img/wrong.png" style="width:18px;height:18px;"></p>
                        </div>
                      </div>

                      <hr>

                      <div class="form-group">
                        <input type="submit" name="editar" id="editar" class="btn btn-success" value="Salvar" style="float:right" disabled>
                      </div>
    								</form>
    							</div>
    						</div>
    					</div>
    				</div>

            <script>
              $('#senha_atual').bind('input propertychange',function(){
                if($('#senha_atual').val().length > 0){
                  if($('#senha_atual').val() == $('#senha_antiga').val()){
                    $('#row_password_atual').css("width","700px");
                    $('#match_atual').css("display","block");
                    $('#no_match_atual').css("display","none");
                    if($('#match').is(':visible')){
                      $('#editar').prop('disabled',false);
                    }
                  }else{
                    $('#row_password_atual').css("width","700px");
                    $('#match_atual').css("display","none");
                    $('#no_match_atual').css("display","block");
                    $('#editar').prop('disabled',true);
                  }
                }else{
                  $('#row_password_atual').css("width","350px");
                  $('#no_match_atual').css("display","none");
                  $('#match_atual').css("display","none");
                  $('#editar_atual').prop('disabled',true);
                }
              });

              $('#nova_senha').bind('input propertychange',function(){
                if($('#nova_senha').val() == $('#confirmar_senha').val()){
                  if($('#nova_senha').val().length > 0 && $('#confirmar_senha').val().length > 0){
                    $('#row_password').css("width","700px");
                    $('#match').css("display","block");
                    $('#no_match').css("display","none");
                    if($('#match_atual').is(':visible')){
                      $('#editar').prop('disabled',false);
                    }
                  }
                }else{
                  $('#row_password').css("width","350px");
                  $('#no_match').css("display","none");
                  $('#match').css("display","none");
                  $('#editar').prop('disabled',true);
                  if($('#nova_senha').val().length > 0 && $('#confirmar_senha').val().length > 0){
                    $('#row_password').css("width","700px");
                    $('#no_match').css("display","block");
                  }
                }
              });

              $('#confirmar_senha').bind('input propertychange',function(){
                if($('#nova_senha').val() == $('#confirmar_senha').val()){
                  if($('#nova_senha').val().length > 0 && $('#confirmar_senha').val().length > 0){
                    $('#row_password').css("width","700px");
                    $('#match').css("display","block");
                    $('#no_match').css("display","none");
                    if($('#match_atual').is(':visible')){
                      $('#editar').prop('disabled',false);
                    }
                  }
                }else{$('#row_password').css("width","350px");
                  $('#no_match').css("display","none");
                  $('#match').css("display","none");
                  $('#editar').prop('disabled',true);
                  if($('#nova_senha').val().length > 0 && $('#confirmar_senha').val().length > 0){
                    $('#row_password').css("width","700px");
                    $('#no_match').css("display","block");
                  }
                }
              });
            </script>



            <script>
      				setTimeout(function(){
      						var msg = document.getElementById("login_invalido");
      						msg.parentNode.removeChild(msg);
      				}, 2000);

        			setTimeout(function(){
        					var msg = document.getElementById("mensagem_alerta");
        					msg.parentNode.removeChild(msg);
        			}, 2000);
      			</script>
		</body>

</html>
