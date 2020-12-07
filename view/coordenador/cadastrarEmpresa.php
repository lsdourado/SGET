<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
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
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
				<link rel="stylesheet" href="css/cadastro.css">
				<title>Coord. Estágio</title>
		</header>

		<body>
        <div id="backgroud">
            <div style="padding-bottom: 1%">
    						<h3><span><strong>Nova Empresa</strong></span></h3>
    				</div>

            <hr>

            <div id="mensagem_alerta">
              <?php
              if(isset($_SESSION['sucesso_cadastro'])){
                ?>
                <div class="alert alert-success" role="alert">
                  <?php
                  echo $_SESSION['sucesso_cadastro'];
                  unset($_SESSION['sucesso_cadastro']);
                  ?>
                </div>
                <?php
              }
              ?>
            </div>


            <form action="../data_access/coordenador/cadastrarEmpresa.php" method="post">
              <div class="form-group">
                <input type="text" name="nome_fantasia" class="form-control" id="nome_fantasia" placeholder="Nome Fantasia" style="width:90%">
              </div>
              <div class="form-group">
                <input type="text" name="razao_social" class="form-control" id="razao_social" placeholder="Razão Social" style="width:60%">
              </div>
              <div class="form-group">
                <input type="text" name="tipo_empregador" class="form-control" id="tipo_empregador" placeholder="Tipo de Empregador" style="width:40%">
              </div>
              <div class="form-group">
                <input type="text" minlength="18" maxlength="18" name="cnpj_empresa" class="form-control" id="cnpj_empresa" placeholder="CNPJ" style="width:30%">
              </div>
              <div class="form-group">
                <input type="text" name="representante_legal" class="form-control" id="representante_legal" placeholder="Representante Legal" style="width:60%">
              </div>
              <hr>

              <strong><span>Endereço</span></strong>

              <div class="form-group" style="padding-top:1%">
                <input type="text" name="cidade_empresa" class="form-control" id="cidade_empresa" placeholder="Cidade" style="width:50%">
              </div>
              <div class="form-group">
                <select class="form-control" name="estado_empresa" id="estado_empresa" style="width:20%">
                  <option value="" disabled selected>Estado</option>
                  <option value="AC">AC</option>
                  <option value="AL">AL</option>
                  <option value="AP">AP</option>
                  <option value="AM">AM</option>
                  <option value="BA">BA</option>
                  <option value="CE">CE</option>
                  <option value="DF">DF</option>
                  <option value="ES">ES</option>
                  <option value="GO">GO</option>
                  <option value="MA">MA</option>
                  <option value="MT">MT</option>
                  <option value="MS">MS</option>
                  <option value="MG">MG</option>
                  <option value="PA">PA</option>
                  <option value="PB">PB</option>
                  <option value="PR">PR</option>
                  <option value="PE">PE</option>
                  <option value="PI">PI</option>
                  <option value="RJ">RJ</option>
                  <option value="RN">RN</option>
                  <option value="RS">RS</option>
                  <option value="RO">RO</option>
                  <option value="RR">RR</option>
                  <option value="SC">SC</option>
                  <option value="SP">SP</option>
                  <option value="SE">SE</option>
                  <option value="TO">TO</option>
                </select>
              </div>
              <div class="form-group">
                <input type="text" name="bairro_empresa" class="form-control" id="bairro_empresa" placeholder="Bairro" style="width:50%">
              </div>
              <div class="form-group">
                <input type="text" name="rua_empresa" class="form-control" id="rua_empresa" placeholder="Rua" style="width:50%">
              </div>
              <div class="form-group">
                <input type="text" name="numero_endereco_empresa" class="form-control" id="numero_endereco_empresa" placeholder="Número" style="width:10%">
              </div>
              <div class="form-group">
                <input type="text" minlength="3" maxlength="9" name="cep_empresa" class="form-control" id="cep_empresa" placeholder="CEP" style="width:20%">
              </div>

              <hr>

              <strong><span>Contato</span></strong>

              <div class="form-group" style="padding-top:1%">
                <input type="email" name="email_empresa" class="form-control" id="email_empresa" placeholder="E-mail" style="width:50%">
              </div>
              <div class="form-group">
                <input type="text" minlength="15" maxlength="16" name="telefone_empresa" class="form-control" id="telefone_empresa" placeholder="Telefone" style="width:30%">
              </div>

              <hr>
                <input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success" value="Cadastrar" style="margin-bottom:1%;float:right">

                <div style="float:left">
                  <?php
                      if(isset($_SESSION['sucesso_cadastro'])){
                          ?>
                          <div class="alert alert-success" role="alert">
                              <?php
                                echo $_SESSION['sucesso_cadastro'];
                                unset($_SESSION['sucesso_cadastro']);
                              ?>
                          </div>
                          <?php
                      }
                  ?>
                  <?php
                      if(isset($_SESSION['erro_cadastro'])){
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
            </form>
        </div>

        <script>
        $(document).ready(function(){
          $("#cnpj_empresa").mask("00.000.000/0000-00");
          $("#cep_empresa").mask("00000-000");
          $("#telefone_empresa").mask("(00) 0 0000-0000");
        });
        </script>
		</body>
</html>
