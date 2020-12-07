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
    						<h3><span><strong>Instituição</strong></span></h3>
    				</div>

            <hr>

            <form action="../data_access/coordenador/cadastrarInstituicao.php" method="post">
              <div class="form-group">
                <input type="text" name="nome_instituicao" class="form-control" id="nome_instituicao" placeholder="Nome" style="width:100%;">
              </div>
              <div class="form-group">
                <input type="text" minlength="18" maxlength="18" name="cnpj_instituicao" class="form-control" id="cnpj_instituicao" placeholder="CNPJ" style="width:30%">
              </div>

              <div class="form-group">
                <input type="text" name="diretor_instituicao" class="form-control" id="diretor_instituicao" placeholder="Diretor" style="width:50%" >
              </div>
              <div class="form-group">
                <input type="text" name="portaria_instituicao" class="form-control" id="portaria_instituicao" placeholder="Nº Portaria" style="width:30%">
              </div>

              <hr>

              <span><strong>Contato</strong></span>

              <div class="form-group" style="padding-top:1%">
                <input type="text" minlength="15" maxlength="16" name="telefone_instituicao" class="form-control" id="telefone_instituicao" placeholder="Telefone" style="width:30%">
              </div>

              <hr>

              <span><strong>Endereço</strong></span>

              <div class="form-group" style="padding-top:1%">
                <input type="text" name="cidade_endereco" class="form-control" id="cidade_endereco" placeholder="Cidade" style="width:30%" >
              </div>
              <div class="form-group">
                <input type="text" name="rua_endereco" class="form-control" id="rua_endereco" placeholder="Rua" style="width:30%" >
              </div>
              <div class="form-group">
                <input type="text" name="bairro_endereco" class="form-control" id="bairro_endereco" placeholder="Bairro" style="width:30%" >
              </div>
              <div class="form-group">
                <input type="text" name="numero_endereco" class="form-control" id="numero_endereco" placeholder="Número" style="width:30%" >
              </div>
              <div class="form-group">
                <select class="form-control" name="estado_endereco" id="estado_endereco" style="width:20%">
                  <option value=""  selected>Estado</option>
                  <option value="AC" >AC</option>
                  <option value="AL" >AL</option>
                  <option value="AP" >AP</option>
                  <option value="AM" >AM</option>
                  <option value="BA" >BA</option>
                  <option value="CE" >CE</option>
                  <option value="DF" >DF</option>
                  <option value="ES" >ES</option>
                  <option value="GO" >GO</option>
                  <option value="MA" >MA</option>
                  <option value="MT" >MT</option>
                  <option value="MS" >MS</option>
                  <option value="MG" >MG</option>
                  <option value="PA" >PA</option>
                  <option value="PB" >PB</option>
                  <option value="PR" >PR</option>
                  <option value="PE" >PE</option>
                  <option value="PI" >PI</option>
                  <option value="RJ" >RJ</option>
                  <option value="RN" >RN</option>
                  <option value="RS" >RS</option>
                  <option value="RO" >RO</option>
                  <option value="RR" >RR</option>
                  <option value="SC" >SC</option>
                  <option value="SP" >SP</option>
                  <option value="SE" >SE</option>
                  <option value="TO" >TO</option>
                </select>
              </div>
              <div class="form-group">
                  <input type="text" minlength="9" maxlength="9" name="cep_endereco" class="form-control" id="cep_endereco" placeholder="CEP" style="width:30%" >
              </div>


                <input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success" value="Cadastrar" style="float:right;margin-bottom:1%">
                </div>
            </form>
        </div>

        <script>
          $(document).ready(function(){
            $("#cnpj_instituicao").mask("00.000.000/0000-00");
            $("#cep_endereco").mask("00000-000");
            $("#portaria_instituicao").mask("#.##0", {reverse:true});
            $("#telefone_instituicao").mask("(00) 0 0000-0000");
          });
        </script>
		</body>
</html>
