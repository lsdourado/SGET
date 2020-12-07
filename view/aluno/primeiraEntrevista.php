<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
    }

		include_once("../data_access/aluno/buscarPrimeiraEntrevista.php");
    $entrevista = mysqli_fetch_assoc($_SESSION['result_entrevista']);

    $_SESSION['primeira_entrevista'] = $entrevista['id'];

    include_once("../data_access/aluno/buscarAvaliacaoEntrevista.php");
    $_SESSION['avaliacao_entrevista1'] = mysqli_fetch_assoc($_SESSION['result_avaliacao_1']);
?>
<html>
		<header>
				<meta charset="utf-8">
				<title>Coor. Estágio</title>
		</header>

    <body>
        <div id="backgroud">
            <div style="padding-bottom: 1%">
    						<h3><span><strong>1ª Entrevista</strong></span></h3>
    				</div>


            <hr>

            <?php
              if($entrevista['encerrado']) {
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

            <div class="form-group">
              <button type="button" class="btn btn-info" data-toggle="modal" id="btnAvaliacao_1" data-target="#avaliacao_entrevista_1">
                Avaliação da entrevista
              </button>
            </div>

            <hr>

            <form action="../data_access/aluno/editarPrimeiraEntrevista.php" method="post">
              <input type="hidden" name="id_entrevista" id="id_entrevista" value="<?php echo $entrevista['id'] ?>">
              <input type="hidden" name="encerrado" id="encerrado" value="<?php echo $entrevista['encerrado'] ?>">

              <div class="form-group">
                <label for="atv_desenvolvida" style="font-weight:bold;">Atividades desenvolvidas</label>
                <textarea class="form-control" id="atv_desenvolvida" name="atv_desenvolvida" rows="6"><?php echo $entrevista['atv_desenvolvida'] ?></textarea>
              </div>

              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="check_treinamento" name="check_treinamento" onClick="descVisible()" <?php if($entrevista['treinamento']){echo "checked";} ?>>
                <label class="form-check-label" for="check_treinamento">Treinamento realizado</label>
              </div>

              <div class="form-group" style="display:none;" id="div_desc_treinamento">
                <label for="desc_treinamento" style="font-weight:bold;">Descrição do treinamento</label>
                <textarea class="form-control" id="desc_treinamento" name="desc_treinamento" rows="6"><?php echo $entrevista['desc_treinamento'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="adaptacao" style="font-weight:bold;">Processo de adaptação</label>
                <textarea class="form-control" id="adaptacao" name="adaptacao" rows="6"><?php echo $entrevista['adaptacao'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="acompanhamento_emp" style="font-weight:bold;">Acompanhamento da empresa</label>
                <textarea class="form-control" id="acompanhamento_emp" name="acompanhamento_emp" rows="6"><?php echo $entrevista['acompanhamento_emp'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="exec_trabalhos" style="font-weight:bold;">Execução dos trabalhos</label>
                <textarea class="form-control" id="exec_trabalhos" name="exec_trabalhos" rows="6"><?php echo $entrevista['exec_trabalhos'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="coment_aluno" style="font-weight:bold;">Comentários e observações do (a) aluno (a)</label>
                <textarea class="form-control" id="coment_aluno" name="coment_aluno" rows="6"><?php echo $entrevista['coment_aluno'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="coment_professor" style="font-weight:bold;">Comentários e observações do (a) orientador (a)</label>
                <textarea class="form-control" id="coment_professor" name="coment_professor" rows="6" disabled><?php echo $entrevista['coment_professor'] ?></textarea>
              </div>

              <input type="submit" name="salvar" id="salvar" class="btn btn-success" value="Salvar" style="float:right;margin-bottom:1%">

            </form>
        </div>

        <!-- Modal avaliação entrevista 1-->
        <div class="modal fade bd-example-modal-lg" id="avaliacao_entrevista_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Avaliação da 1ª Entrevista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="../data_access/professor/editarAvaliacaoEntrevista.php" method="post" id="aba_avaliacao_1">
                  <input type="hidden" name="id_avaliacao_1" id="id_avaliacao_1" value="<?php echo $_SESSION['avaliacao_entrevista1']['id_avaliacao'] ?>">
                  <input type="hidden" name="av_encerrado_1" id="av_encerrado_1" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_encerrado'] ?>">
                  <div class="form-group">
                    <label for="av_criterio_1" style="font-weight:bold;">Conhecimento do estagiário sobre o setor de trabalho</label>
                    <input type="text" id="av_criterio_1" name="av_criterio_1" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_1'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="av_criterio_2" style="font-weight:bold;">Adaptação do estagiário ao ambiente de trabalho</label>
                    <input type="text" id="av_criterio_2" name="av_criterio_2" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_2'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="av_criterio_3" style="font-weight:bold;">Uso de habilidades e conhecimentos adquiridos no curso</label>
                    <input type="text" id="av_criterio_3" name="av_criterio_3" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_3'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="av_criterio_4" style="font-weight:bold;">Relacionamento interpessoal do estagiário</label>
                    <input type="text" id="av_criterio_4" name="av_criterio_4" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_4'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="av_criterio_5" style="font-weight:bold;">Proatividade e comprometimento do estagiário na execução de tarefas</label>
                    <input type="text" id="av_criterio_5" name="av_criterio_5" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_5'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="nota_entrevista_1" style="font-weight:bold;">Nota da entrevista</label>
                    <input type="text" id="nota_entrevista_1" name="nota_entrevista_1" value="<?php echo $_SESSION['avaliacao_entrevista1']['nota'] ?>" style="width:60px" disabled>
                  </div>
                  <input type="hidden" name="nota1" id="nota1" value="<?php echo $_SESSION['avaliacao_entrevista1']['nota'] ?>">

                  <div class="form-group">
                    <label for="observacao_avaliacao_1" style="font-weight:bold;">Comentários e observações</label>
                    <textarea class="form-control" id="observacao_avaliacao_1" name="observacao_avaliacao_1" rows="6"><?php echo $_SESSION['avaliacao_entrevista1']['observacao'] ?></textarea>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <script>
          window.onload = function (e){
              if($('#encerrado').val() == true) {
                $("textarea").prop("disabled",true);
                $("#check_treinamento").prop("disabled",true);
                $("#salvar").hide();
              }

              if($('#check_treinamento').is(':checked')){
                $('#div_desc_treinamento').css({display: "block"});
              }
          };

          function descVisible(){
            if(document.getElementById('div_desc_treinamento').style.display == 'none') {
              document.getElementById('div_desc_treinamento').style.display = 'block';
            }else {
              document.getElementById('div_desc_treinamento').style.display = 'none';
            }
          }
        </script>
		</body>

</html>
