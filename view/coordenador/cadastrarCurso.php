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
    						<h3><span><strong>Novo Curso</strong></span></h3>
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
            <form action="../data_access/coordenador/cadastrarCurso.php" method="post">
                <div class="form-group">
                    <input type="text" name="nome_curso" class="form-control" id="nome_curso" placeholder="Nome do curso" style="width:70%">
                </div>
                <div class="form-group">
                    <select class="form-control" name="tipo_curso" id="tipo_curso" style="width:30%">
                      <option value="" disabled selected>Tipo de curso</option>
                      <option value="Técnico">Técnico</option>
                      <option value="Graduação">Graduação</option>
                    </select>
                </div>
                <input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success" value="Cadastrar" style="float:right">

                <div style="float:left; width:30%">
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
		</body>
</html>
