<?php
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../../index.php');
}

include_once("../data_access/coordenador/listarEmpresas.php");

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
      <h3><span><strong>Novo Supervisor</strong></span></h3>
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

    <form action="../data_access/coordenador/cadastrarSupervisor.php" method="post">
      <div class="form-group">
        <input type="text" name="nome_supervisor" class="form-control" id="nome_supervisor" placeholder="Nome" style="width:70%">
      </div>
			<div class="form-group">
        <input type="email" name="email_supervisor" class="form-control" id="email_supervisor" placeholder="E-mail" style="width:70%">
      </div>
      <div class="form-group">
        <input type="text" name="num_reg_prof" class="form-control" id="num_reg_prof" placeholder="Nº Registro Profissional" style="width:30%">
      </div>
      <div class="form-group">
        <input type="text" name="orgao_emissor" class="form-control" id="orgao_emissor" placeholder="Orgão Emissor" style="width:30%">
      </div>
      <div class="form-group">
        <input type="text" name="cargo_supervisor" class="form-control" id="cargo_supervisor" placeholder="Cargo" style="width:30%">
      </div>
      <div class="form-group">
        <input type="text" name="formacao_supervisor" class="form-control" id="formacao_supervisor" placeholder="Formação Acadêmica" style="width:70%">
      </div>
      <div class="form-group">
        <select class="form-control" name="empresa_supervisor" id="empresa_supervisor" style="width:70%">
          <option value="" disabled selected>Empresa</option>
          <?php
          while($linha = mysqli_fetch_assoc($_SESSION['result_empresas'])){
            ?>
            <option value="<?php echo $linha['id_empresa'] ?>"><?php echo $linha['nome_fantasia'] ?> / CNPJ: <?php echo $linha['cnpj']?></option>
            <?php
          }
          unset($_SESSION['result_empresas']);
          ?>
        </select>
      </div>

      <div id="botao_cadastrar" style="padding-bottom: 1%; float:right">
        <input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success" value="Cadastrar">
      </div>
    </form>
  </div>
</body>
</html>
