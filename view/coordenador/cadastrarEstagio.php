<?php
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../../index.php');
}

include_once("../data_access/coordenador/listarAlunos.php");
include_once("../data_access/coordenador/listarProfessores.php");
include_once("../data_access/coordenador/listarEmpresas.php");
include_once("../data_access/coordenador/listarSupervisores.php");

$supervisores = $_SESSION['result_supervisores'];

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
      <h3><span><strong>Novo Estágio</strong></span></h3>
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
          <a href="coordenador/documentos/termoCompromisso.php?id_estagio=<?php echo $_SESSION['id_estagio']?>" target="blank"><button type="button" id="termo_link" style="display:none"></button></a>
        </div>
        <?php
        unset($_SESSION['id_estagio']);
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

    <form action="../data_access/coordenador/cadastrarEstagio.php" method="post">
      <div class="form-group">
        <select class="form-control" name="estagio_aluno" id="estagio_aluno" style="width:60%">
          <option value="" disabled selected>Aluno</option>
          <?php
          while($linha = mysqli_fetch_assoc($_SESSION['result_alunos'])){
            ?>
            <option value="<?php echo $linha['id_aluno'] ?>"><?php echo $linha['nome_aluno'] ?> / Matrícula: <?php echo $linha['matricula'] ?></option>
            <?php
          }
          unset($_SESSION['result_alunos']);
          ?>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" name="estagio_professor" id="estagio_professor" style="width:60%">
          <option value="" disabled selected>Orientador</option>
          <?php
          while($linha = mysqli_fetch_assoc($_SESSION['result_professores'])){
            ?>
            <option value="<?php echo $linha['id_professor'] ?>"><?php echo $linha['nome_professor'] ?> / SIAPE: <?php echo $linha['siape'] ?></option>
            <?php
          }
          unset($_SESSION['result_professores']);
          ?>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" name="estagio_empresa" id="estagio_empresa" style="width:70%">
          <option value="" disabled selected>Empresa</option>
          <?php
          while($linha = mysqli_fetch_assoc($_SESSION['result_empresas'])){
            ?>
            <option value="<?php echo $linha['id_empresa'] ?>"><?php echo $linha['nome_fantasia'] ?> / CNPJ: <?php echo $linha['cnpj'] ?></option>
            <?php
          }
          unset($_SESSION['result_empresas']);
          ?>
        </select>
      </div>
      <div class="form-group" id="select_supervisores" style="display:none;">
        <select class="form-control" name="estagio_supervisor" id="estagio_supervisor" style="width:60%;">
          <option value="default" disabled selected>Supervisor</option>
          <?php
          while($linha = mysqli_fetch_assoc($_SESSION['result_supervisores'])){
            ?>
            <option id="supervisor<?php echo $linha['id_supervisor'] ?>" value="<?php echo $linha['id_supervisor'] ?>"><?php echo $linha['nome'] ?> / Nº Reg. Prof: <?php echo $linha['num_reg_prof'] ?></option>
            <option id="empresa_supervisor<?php echo $linha['id_supervisor'] ?>" value="<?php echo $linha['id_empresa'] ?>" style="display:none"></option>
            <?php
          }
          unset($_SESSION['result_supervisores']);
          ?>
        </select>
      </div>
      <div class="form-group">
        <div class="input-group date" style="width:20%">
          <input type="text" class="form-control" name="data_inicio" id="data_inicio" placeholder="Data de Início">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group date" style="width:20%">
          <input type="text" class="form-control" name="data_fim" id="data_fim" placeholder="Data Final">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <input type="text" minlength="5" maxlength="5" name="carga_semanal" class="form-control" id="carga_semanal" placeholder="Carga Horária Semanal (HH:mm)" style="width:30%">
      </div>
      <div class="form-group">
        <input type="text" minlength="5" maxlength="5" name="horario_inicio" class="form-control" id="horario_inicio" placeholder="Início do Expediente (HH:mm)" style="width:30%">
      </div>
      <div class="form-group">
        <input type="text" minlength="5" maxlength="5" name="horario_fim" class="form-control" id="horario_fim" placeholder="Fim do Expediente (HH:mm)" style="width:30%">
      </div>
      <div class="form-group">
        <input type="text" minlength="13" maxlength="13" name="apolice_seguro" class="form-control" id="apolice_seguro" placeholder="Apólice do Seguro" style="width:30%">
      </div>
      <div class="form-group">
        <input type="text" name="nome_seguradora" class="form-control" id="nome_seguradora" placeholder="Nome da Seguradora" style="width:70%">
      </div>
      <div class="form-group">
        <input type="text" minlength="4" name="valor_seguro" class="form-control" id="valor_seguro" placeholder="Valor do Seguro" style="width:30%">
      </div>
      <div id="bolsas_estagio">
				<div class="form-group">
	        <input type="text" name="bolsa_auxilio" class="form-control" id="bolsa_auxilio" placeholder="Bolsa Auxílio" style="width:30%">
	      </div>
	      <div class="form-group">
	        <input type="text" name="auxilio_transporte" class="form-control" id="auxilio_transporte" placeholder="Auxílio Transporte" style="width:30%">
	      </div>
			</div>
      <div class="form-group form-check">
        <input type="checkbox" name="obrigatorio" id="obrigatorio">
        <label for="obrigatorio" style="font-weight:bold;">Estágio obrigatório</label>
      </div>
      <div id="botao_cadastrar" style="padding-bottom: 1%; float:right">
        <input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success" value="Cadastrar">
      </div>
    </form>
  </div>

  <script>
  $(document).ready(function(){
    $("#data_inicio").mask("00/00/0000");
    $("#data_fim").mask("00/00/0000");
    $("#carga_semanal").mask("00:00");
    $("#horario_inicio").mask("00:00", {reverse:true});
    $("#horario_fim").mask("00:00", {reverse:true});
    $("#apolice_seguro").mask("0.000.000.000");
    $("#valor_seguro").mask('#.##0,00', {reverse:true});
    $("#bolsa_auxilio").mask('#.##0,00', {reverse:true});
    $("#auxilio_transporte").mask('#.##0,00', {reverse:true});

    $('#termo_link').click();
  });

  $("#valor_seguro").blur(function(){
    $("#valor_seguro").val("R$"+$("#valor_seguro").val());
  });

  $("#bolsa_auxilio").blur(function(){
    $("#bolsa_auxilio").val("R$"+$("#bolsa_auxilio").val());
  });

  $("#auxilio_transporte").blur(function(){
    $("#auxilio_transporte").val("R$"+$("#auxilio_transporte").val());
  });

  $('#data_inicio').datepicker({
    format: 'dd/mm/yyyy',
    language: "pt-BR",
		todayHighlight: true,
    autoclose: true
  })


  $('#data_fim').datepicker({
    format: 'dd/mm/yyyy',
    language: "pt-BR",
		todayHighlight: true,
    autoclose: true
  });

  $('#estagio_empresa').change(function(){
    var tamMax = $('#estagio_supervisor option').length;
    var i=0;

    if($('#select_supervisores').is(':visible')==false){
      $('#select_supervisores').show();
    }

    for(i; i < tamMax; i++){
      if($('#supervisor'+(i+1)).val()!=undefined){
        if($('#empresa_supervisor'+(i+1)).val() == $('#estagio_empresa').val()){
          $('#supervisor'+(i+1)).show();
        }else{
          $('#supervisor'+(i+1)).hide();
        }
      }
    }

    $('#estagio_supervisor').val($('option:contains("Supervisor")').val());
  });
  </script>

</body>
</html>
