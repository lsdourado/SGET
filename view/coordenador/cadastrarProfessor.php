<?php
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../../index.php');
}

include_once("../data_access/coordenador/listarCursos.php");

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
  <title>Coord. Estágio</title>
</header>

<body>
  <div id="backgroud">
    <div style="padding-bottom: 1%">
      <h3><span><strong>Novo Professor</strong></span></h3>
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
    <form action="../data_access/coordenador/cadastrarProfessor.php" method="post">
      <div class="form-group">
        <input type="text" name="nome_professor" class="form-control" id="nome_professor" placeholder="Nome" style="width:50%">
      </div>
      <div class="form-group">
        <input type="text" minlength="9" maxlength="9" name="siape" class="form-control" id="siape" placeholder="SIAPE" style="width:30%">
      </div>
      <div class="form-group">
        <div class="input-group date" style="width:20%">
          <input type="text" class="form-control" name="data_nascimento" id="data_nascimento" placeholder="Data de nascimento">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <select class="form-control" name="sexo_professor" id="sexo_professor" style="width:20%">
          <option value="" disabled selected>Sexo</option>
          <option value="Masculino">Masculino</option>
          <option value="Feminino">Feminino</option>
        </select>
      </div>

      <hr>

      <strong><span>Endereço</span></strong>

      <div class="form-group" style="padding-top:1%">
        <input type="text" name="cidade_professor" class="form-control" id="cidade_professor" placeholder="Cidade" style="width:50%">
      </div>
      <div class="form-group">
        <select class="form-control" name="estado_professor" id="estado_professor" style="width:20%">
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
        <input type="text" name="bairro_professor" class="form-control" id="bairro_professor" placeholder="Bairro" style="width:50%">
      </div>
      <div class="form-group">
        <input type="text" name="rua_professor" class="form-control" id="rua_professor" placeholder="Rua" style="width:50%">
      </div>
      <div class="form-group">
        <input type="text" name="numero_endereco_professor" class="form-control" id="numero_endereco_professor" placeholder="Número" style="width:10%">
      </div>
      <div class="form-group">
        <input type="text" minlength="9" maxlength="9" name="cep_professor" class="form-control" id="cep_professor" placeholder="CEP" style="width:20%">
      </div>

      <hr>

      <strong><span>Contato</span></strong>

      <div class="form-group" style="padding-top:1%">
        <input type="email" name="email_professor" class="form-control" id="email_professor" placeholder="E-mail" style="width:50%">
      </div>
      <div class="form-group">
        <input type="text" minlength="15" maxlength="16" name="telefone_professor" class="form-control" id="telefone_professor" placeholder="Telefone" style="width:30%">
      </div>

      <hr>

      <strong><span>Acesso</span></strong>

      <div style="padding-top: 1%">
          <span style="color:red">*O login do professor será seu SIAPE sem pontos e barras</span>
      </div>

      <div class="form-group row" style="padding-top: 1%;width: 350px">
        <div class="col">
          <input type="password" name="senha_professor" class="form-control" id="senha_professor" placeholder="Senha" minlength="8" maxlength="20">
          <small id="passwordHelpBlock" class="form-text text-muted" style="float:right;">A senha deve conter 8-20 caracteres</small>
        </div>
      </div>
      <div class="row" id="row_password" style="width:350px">
        <div class="col">
          <input type="password" name="confirmar_senha_professor" class="form-control" id="confirmar_senha_professor" placeholder="Confirmar senha" maxlength="20">
        </div>
        <div id="match" class="col" style="display:none;padding-top:1.5%">
          <p id="combina"><img src="img/correct.png" style="width:18px;height:18px;"></p>
        </div>
        <div id="no_match" class="col" style="display:none;padding-top:1.5%">
          <p id="nao_combina"><img src="img/wrong.png" style="width:18px;height:18px;"></p>
        </div>
      </div>

      <div id="botao_cadastrar" style="padding-bottom: 1%; float:right">
        <input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success" value="Cadastrar" disabled>
      </div>
    </form>
  </div>
</body>

<script type="text/javascript">
$('#data_nascimento').datepicker({
  format: 'dd/mm/yyyy',
  language: "pt-BR",
	todayHighlight: true,
  autoclose: true
});

$('#senha_professor').bind('input propertychange',function(){
  if($('#senha_professor').val() == $('#confirmar_senha_professor').val()){
    if($('#senha_professor').val().length > 0 && $('#confirmar_senha_professor').val().length > 0){
      $('#row_password').css("width","700px");
      $('#match').css("display","block");
      $('#no_match').css("display","none");
      $('#cadastrar').prop('disabled',false);
    }
  }else{
    $('#row_password').css("width","350px");
    $('#no_match').css("display","none");
    $('#match').css("display","none");
    $('#cadastrar').prop('disabled',true);
    if($('#senha_professor').val().length > 0 && $('#confirmar_senha_professor').val().length > 0){
      $('#row_password').css("width","700px");
      $('#no_match').css("display","block");
    }
  }
});

$('#confirmar_senha_professor').bind('input propertychange',function(){
  if($('#senha_professor').val() == $('#confirmar_senha_professor').val()){
    if($('#senha_professor').val().length > 0 && $('#confirmar_senha_professor').val().length > 0){
      $('#row_password').css("width","700px");
      $('#match').css("display","block");
      $('#no_match').css("display","none");
      $('#cadastrar').prop('disabled',false);
    }
  }else{$('#row_password').css("width","350px");
    $('#no_match').css("display","none");
    $('#match').css("display","none");
    $('#cadastrar').prop('disabled',true);
    if($('#senha_professor').val().length > 0 && $('#confirmar_senha_professor').val().length > 0){
      $('#row_password').css("width","700px");
      $('#no_match').css("display","block");
    }
  }
});

$(document).ready(function(){
  $("#siape").mask("000.000-0");
  $("#data_nascimento").mask("00/00/0000");
  $("#cep_professor").mask("00000-000");
  $("#telefone_professor").mask("(00) 0 0000-0000");
});
</script>
</html>
