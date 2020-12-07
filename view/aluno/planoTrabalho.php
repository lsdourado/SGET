<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
    }

		include_once("../data_access/aluno/buscarPlanoTrabalho.php");
    $plano = mysqli_fetch_assoc($_SESSION['result_plano']);
?>
<html>
		<header>
				<meta charset="utf-8">
				<title>Coor. Estágio</title>
		</header>

    <body>
        <div id="backgroud">
            <div style="padding-bottom: 1%">
    						<h3><span><strong>Plano de Trabalho</strong></span></h3>
    				</div>

            <hr>

            <?php
              if($plano['encerrado']) {
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

            <form action="../data_access/aluno/editarPlanoTrabalho.php" method="post">
              <input type="hidden" name="id_plano" id="id_plano" value="<?php echo $plano['id'] ?>">
              <input type="hidden" name="encerrado" id="encerrado" value="<?php echo $plano['encerrado'] ?>">
              <div class="form-group">
                <label for="objetivos" style="font-weight:bold;">Objetivos</label>
                <textarea class="form-control" id="objetivos" name="objetivos" rows="6"><?php echo $plano['objetivo'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="atividades" style="font-weight:bold;">Atividades</label>
                <textarea class="form-control" id="atividades" name="atividades" rows="6"><?php echo $plano['atividade'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="crono_entrevista" style="font-weight:bold;">Cronograma de entrevistas</label>
                <textarea class="form-control" id="crono_entrevista" name="crono_entrevista" rows="6"><?php echo $plano['crono_entrevista'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="instrumento_av" style="font-weight:bold;">Instrumentos de avaliação</label>
                <textarea class="form-control" id="instrumento_av" name="instrumento_av" rows="6"><?php echo $plano['instrumento_av'] ?></textarea>
              </div>

              <input type="submit" name="salvar" id="salvar" class="btn btn-success" value="Salvar" style="float:right;margin-bottom:1%">

            </form>
        </div>

        <script>
          window.onload = function (e){
              if($('#encerrado').val() == true) {
                $("textarea").prop("disabled",true);
                $("#salvar").hide();
              }
          };
        </script>
		</body>

</html>
