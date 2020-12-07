<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
    }

		include_once("../data_access/aluno/buscarRelatorioFinal.php");
    $relatorio = mysqli_fetch_assoc($_SESSION['result_relatorio']);
?>
<html>
		<header>
				<meta charset="utf-8">
				<title>Coor. Estágio</title>
		</header>

    <body>
        <div id="backgroud">
            <div style="padding-bottom: 1%">
    						<h3><span><strong>Relatório Final</strong></span></h3>
    				</div>

            <hr>

            <?php
              if($relatorio['encerrado']) {
                ?>
                <div class="alert alert-warning" role="alert">
                  O documento foi encerrado pelo orientador.
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

            <form action="../data_access/aluno/editarRelatorioFinal.php" method="post">
              <input type="hidden" name="id_entrevista" id="id_entrevista" value="<?php echo $relatorio['id'] ?>">
              <input type="hidden" name="encerrado" id="encerrado" value="<?php echo $relatorio['encerrado'] ?>">

              <div class="form-group">
                <label for="desc_empresa" style="font-weight:bold;">Apresentação da empresa</label>
                <textarea class="form-control" id="desc_empresa" name="desc_empresa" rows="6"><?php echo $relatorio['desc_empresa'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="desc_atividade" style="font-weight:bold;">Descrição das atividades</label>
                <textarea class="form-control" id="desc_atividade" name="desc_atividade" rows="6"><?php echo $relatorio['desc_atividade'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="conclusao" style="font-weight:bold;">Conclusões</label>
                <textarea class="form-control" id="conclusao" name="conclusao" rows="6"><?php echo $relatorio['conclusao'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="nota" style="font-weight:bold;">Nota do relatório final</label>
                <input type="text" name="nota" id="nota" value="<?php echo $relatorio['nota'] ?>" style="width:60px" disabled>
              </div>

              <input type="submit" name="salvar" id="salvar" class="btn btn-success" value="Salvar" style="float:right;margin-bottom:1%">

            </form>
        </div>

        <script>
          window.onload = function (e){
              if($('#encerrado').val() == true) {
                $("textarea").prop("disabled",true);
                $("#check_encerrar").prop("disabled",true);
                $("#salvar").hide();
              }
          };
        </script>
		</body>

</html>
