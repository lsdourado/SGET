<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
    }

    include_once("../data_access/login/buscarLogin.php");
    $acesso = mysqli_fetch_assoc($_SESSION['result_login']);
?>
<html>
		<header>
				<meta charset="utf-8">
				<title>Coord. Estágio</title>
		</header>

		<body>
        <div id="backgroud">
            <div style="padding-bottom: 1%">
    						<h3><span><strong>Configuração de acesso</strong></span></h3>
    				</div>

            <hr>

            <?php
              if($_SESSION['tipo_login']=="aluno"){
                if($_SESSION['estagio']==null){
                  ?>
                  <div class="alert alert-warning" role="alert" id="sem_estagio">
                    Você ainda não possui um estágio
                  </div>
                  <script>
                    $('#li_doc_disabled').css({"pointer-events": "none", "opacity": "0.3"});
              			$('#li_estagio').css({"pointer-events": "none", "opacity": "0.3"});
                  </script>
                  <?php
                }else{
                  ?>
                  <script>
                    $('#li_doc_disabled').css({"pointer-events": "auto", "opacity": "1"});
              			$('#li_estagio').css({"pointer-events": "auto", "opacity": "1"});
                  </script>
                  <?php
                }
              }else{
                if(isset($_SESSION['menu_completo'])){
                	?>
                	<script>
                		$('#menu_coord').css({"pointer-events": "auto", "opacity": "1"});
                		$('#menuitem_configAcesso').css({"pointer-events": "auto", "opacity": "1"});
                	</script>
                	<?php
                }
              }
            ?>

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
              <?php
              if(isset($_SESSION['erro_editar'])){
                ?>
                <div class="alert alert-danger" role="alert">
                  <?php
                  echo $_SESSION['erro_editar'];
                  unset($_SESSION['erro_editar']);
                  ?>
                </div>
                <?php
              }
              ?>
            </div>

            <?php
            if($_SESSION['tipo_login']=="coordenador"){
              include_once("../data_access/coordenador/buscarCoordenador.php");
              if(!isset($_SESSION['primeiro_login'])){
                ?>
                <strong><span>Identificação</span></strong>

                <form action="../data_access/coordenador/alterarCoordenador.php?" method="post">
                  <input type="hidden" name="id_login" value="<?php echo $acesso['id'] ?>">
                  <div class="row" id="row_coordenador" style="padding-top:1%">
                    <div class="col form-group">
                      <label for="nome_coordenador" style="font-weight:bold;">Nome</label>
                      <input type="text" name="nome_coordenador" class="form-control" placeholder="Nome" value="<?php echo $_SESSION['result_coordenador']['nome'] ?>">
                    </div>
                    <div class="col form-group">
                      <label for="email_coordenador" style="font-weight:bold;">E-mail</label><span style="color:red"> (este email será utilizado como login da conta)</span>
                      <input type="email" name="email_coordenador" class="form-control" placeholder="E-mail" value="<?php echo $_SESSION['result_coordenador']['email'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="editar_coordenador" id="editar_coordenador" class="btn btn-success" value="Salvar" style="float:right">
                  </div>

                </form>

                <hr style="margin-top:5%">

                <strong><span>Acesso</span></strong>
                <?php
              }
            }
            ?>

            <form action="../data_access/login/alterarLogin.php?Login=<?php echo $_SESSION['id_login'] ?>" method="post">
              <?php
              if(isset($_SESSION['primeiro_login'])){
                ?>
                <strong><span>Identificação</span></strong>

                  <div class="row" id="row_coordenador" style="padding-top:1%">
                    <div class="col form-group">
                      <label for="nome_coordenador" style="font-weight:bold;">Nome</label>
                      <input type="text" name="nome_coordenador" class="form-control" placeholder="Nome" value="<?php echo $_SESSION['result_coordenador']['nome'] ?>">
                    </div>
                    <div class="col form-group">
                      <label for="email_coordenador" style="font-weight:bold;">E-mail</label><span style="color:red"> (este email será utilizado como login da conta)</span>
                      <input type="email" name="email_coordenador" class="form-control" placeholder="E-mail" value="<?php echo $_SESSION['result_coordenador']['email'] ?>">
                    </div>
                  </div>

                <hr>

                <strong><span>Acesso</span></strong>
                <?php
              }
              ?>
              <input type="hidden" name="id_login" value="<?php echo $acesso['id'] ?>">
              <input type="hidden" name="senha_antiga" id="senha_antiga" value="<?php echo $acesso['senha'] ?>">

              <div class="row" id="row_password_atual" style="width:350px;padding-top:1%">
                <div class="col">
                  <input type="password" name="senha_atual" id="senha_atual" class="form-control" placeholder="Senha Atual" maxlength="20">
                </div>
                <div id="match_atual" class="col" style="display:none;padding-top:1.5%">
                  <p id="combina_atual"><img src="img/correct.png" style="width:18px;height:18px;"></p>
                </div>
                <div id="no_match_atual" class="col" style="display:none;padding-top:1.5%">
                  <p id="nao_combina_atual"><img src="img/wrong.png" style="width:18px;height:18px;"></p>
                </div>
              </div>


              <div class="form-group row" style="padding-top: 3%;width: 350px">
                <div class="col">
                  <input type="password" name="nova_senha" id="nova_senha" class="form-control" placeholder="Nova Senha" minlength="8" maxlength="20">
                  <small id="passwordHelpBlock" class="form-text text-muted" style="float:right">A senha deve conter 8-20 caracteres</small>
                </div>
              </div>
              <div class="row" id="row_password" style="width:350px;">
                <div class="col">
                  <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" placeholder="Confirmar Senha" maxlength="20">
                </div>
                <div id="match" class="col" style="display:none;padding-top:1.5%">
                  <p id="combina"><img src="img/correct.png" style="width:18px;height:18px;"></p>
                </div>
                <div id="no_match" class="col" style="display:none;padding-top:1.5%">
                  <p id="nao_combina"><img src="img/wrong.png" style="width:18px;height:18px;"></p>
                </div>
              </div>


              <div class="form-group">
                <input type="submit" name="editar" id="editar" class="btn btn-success" value="Salvar" style="float:right" disabled>
              </div>
            </form>
        </div>

        <?php
        if(!isset($_SESSION['primeiro_login']) && $_SESSION['tipo_login']=="coordenador"){
          ?>
          <a href="#" class="btn btn-secondary" style="float:right;clear:both;margin-top:3%" data-toggle="modal" data-target="#modalRedefinir">Redefinir Coordenação</a>

          <!-- Modal Redefinir Coordenação-->
          <div class="modal fade" id="modalRedefinir" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Redefinir Coordenação</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-center">
                  <p><strong>Os dados do (a) coordenador (a) serão apagados e a configuração de acesso retornará ao valor padrão.</strong> Deseja prosseguir?</p>
                  <a href="../data_access/coordenador/redefinirCoordenacao.php" class="btn btn-success" style="margin:2%">Sim</a>
                  <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin:2%">Não</button>
                </div>
              </div>
            </div>
          </div>
          <?php
        }
        ?>

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
		</body>
</html>
