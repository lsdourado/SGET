<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
    }

		include_once("../data_access/aluno/buscarSegundaEntrevista.php");
    $entrevista = mysqli_fetch_assoc($_SESSION['result_entrevista']);

    $_SESSION['segunda_entrevista'] = $entrevista['id'];

    include_once("../data_access/aluno/buscarAvaliacaoEntrevista.php");
    $_SESSION['avaliacao_entrevista2'] = mysqli_fetch_assoc($_SESSION['result_avaliacao_2']);
?>
<html>
		<header>
				<meta charset="utf-8">
				<title>Coord. Estágio</title>
		</header>

    <body>
        <div id="backgroud">
            <div style="padding-bottom: 1%">
    						<h3><span><strong>2ª Entrevista</strong></span></h3>
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
              <button type="button" class="btn btn-info" data-toggle="modal" id="btnAvaliacao_2" data-target="#avaliacao_entrevista_2">
                Avaliação da entrevista
              </button>
            </div>

            <hr>

            <form action="../data_access/aluno/editarSegundaEntrevista.php" method="post">
              <input type="hidden" name="id_entrevista" id="id_entrevista" value="<?php echo $entrevista['id'] ?>">
              <input type="hidden" name="encerrado" id="encerrado" value="<?php echo $entrevista['encerrado'] ?>">

              <div class="form-group">
                <label for="atv_desenvolvida" style="font-weight:bold;">Atividades desenvolvidas</label>
                <textarea class="form-control" id="atv_desenvolvida" name="atv_desenvolvida" rows="6"><?php echo $entrevista['atv_desenvolvida'] ?></textarea>
              </div>

              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="check_treinamento" name="check_treinamento" onClick="descVisible()" <?php if($entrevista['treinamento']){echo "checked";} ?>>
                <label class="form-check-label" for="check_treinamento">Treinamento após 1ª entrevista realizado</label>
              </div>

              <div class="form-group" style="display:none;" id="div_desc_treinamento">
                <label for="desc_treinamento" style="font-weight:bold;">Descrição do treinamento</label>
                <textarea class="form-control" id="desc_treinamento" name="desc_treinamento" rows="6"><?php echo $entrevista['desc_treinamento'] ?></textarea>
              </div>

              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="check_dif_superada" name="check_dif_superada" onClick="superadaVisible()" <?php if($entrevista['dif_superada']){echo "checked";} ?>>
                <label class="form-check-label" for="check_dif_superada">Dificuldades anteriores foram superadas</label>
              </div>

              <div class="form-group" style="display:none;" id="div_desc_superada">
                <label for="desc_dif_superada" style="font-weight:bold;">Descrição das dificuldades anteriores</label>
                <textarea class="form-control" id="desc_dif_superada" name="desc_dif_superada" rows="6"><?php echo $entrevista['desc_dificuldade_ant'] ?></textarea>
              </div>

              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="check_nova_dificuldade" name="check_nova_dificuldade" onclick="novaDificuldadeVisible()" <?php if($entrevista['nova_dificuldade']){echo "checked";} ?>>
                <label class="form-check-label" for="check_nova_dificuldade">Novas dificuldades</label>
              </div>

              <div class="form-group" style="display:none;" id="div_desc_nova_dificuldade">
                <label for="desc_nova_dificuldade" style="font-weight:bold;">Descrição das novas dificuldades</label>
                <textarea class="form-control" id="desc_nova_dificuldade" name="desc_nova_dificuldade" rows="6"><?php echo $entrevista['desc_nova_dificuldade'] ?></textarea>
              </div>

              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="check_acompanhamento" name="check_acompanhamento" onClick="acompVisible()" <?php if($entrevista['acomp_mantido']){echo "checked";} ?>>
                <label class="form-check-label" for="check_acompanhamento">Acompanhamento da empresa foi mantido</label>
              </div>

              <div class="form-group" style="display:none;" id="div_desc_acompanhamento">
                <label for="desc_acompanhamento" style="font-weight:bold;">Descrição do acompanhamento</label>
                <textarea class="form-control" id="desc_acompanhamento" name="desc_acompanhamento" rows="6"><?php echo $entrevista['desc_acompanhamento'] ?></textarea>
              </div>

              <div class="form-group">
                <label for="relacao" style="font-weight:bold;">Relação entre disciplinas e estágio</label>
                <textarea class="form-control" id="relacao" name="relacao" rows="6"><?php echo $entrevista['desc_relacao'] ?></textarea>
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

        <!-- Modal avaliação entrevista 2-->
        <div class="modal fade bd-example-modal-lg" id="avaliacao_entrevista_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Avaliação da 2ª Entrevista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="../data_access/professor/editarAvaliacaoEntrevista.php" method="post" id="aba_avaliacao_2">
                  <input type="hidden" name="id_avaliacao_2" id="id_avaliacao_2" value="<?php echo $_SESSION['avaliacao_entrevista2']['id_avaliacao'] ?>">
                  <input type="hidden" name="av_encerrado_2" id="av_encerrado_2" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_encerrado'] ?>">
                  <div class="form-group">
                    <label for="av2_criterio_1" style="font-weight:bold;">Conhecimento do estagiário sobre o setor de trabalho</label>
                    <input type="text" id="av2_criterio_1" name="av2_criterio_1" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_1'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="av2_criterio_2" style="font-weight:bold;">Adaptação do estagiário ao ambiente de trabalho</label>
                    <input type="text" id="av2_criterio_2" name="av2_criterio_2" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_2'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="av2_criterio_3" style="font-weight:bold;">Uso de habilidades e conhecimentos adquiridos no curso</label>
                    <input type="text" id="av2_criterio_3" name="av2_criterio_3" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_3'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="av2_criterio_4" style="font-weight:bold;">Relacionamento interpessoal do estagiário</label>
                    <input type="text" id="av2_criterio_4" name="av2_criterio_4" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_4'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="av2_criterio_5" style="font-weight:bold;">Proatividade e comprometimento do estagiário na execução de tarefas</label>
                    <input type="text" id="av2_criterio_5" name="av2_criterio_5" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_5'] ?>" style="width:60px" disabled>
                  </div>

                  <div class="form-group">
                    <label for="nota_entrevista_2" style="font-weight:bold;">Nota da entrevista</label>
                    <input type="text" id="nota_entrevista_2" name="nota_entrevista_2" value="<?php echo $_SESSION['avaliacao_entrevista2']['nota'] ?>" style="width:60px" disabled>
                  </div>
                  <input type="hidden" name="nota2" id="nota2" value="<?php echo $_SESSION['avaliacao_entrevista2']['nota'] ?>">

                  <div class="form-group">
                    <label for="observacao_avaliacao_2" style="font-weight:bold;">Comentários e observações</label>
                    <textarea class="form-control" id="observacao_avaliacao_2" name="observacao_avaliacao_2" rows="6"><?php echo $_SESSION['avaliacao_entrevista2']['observacao'] ?></textarea>
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
                $("#check_dif_superada").prop("disabled",true);
                $("#check_nova_dificuldade").prop("disabled",true);
                $("#check_acompanhamento").prop("disabled",true);
                $("#salvar").hide();
              }

              if($('#check_treinamento').is(':checked')){
                $('#div_desc_treinamento').css({display: "block"});
              }

              if($('#check_dif_superada').is(':checked')){
                $('#div_desc_superada').css({display: "block"});
              }

              if($('#check_nova_dificuldade').is(':checked')){
                $('#div_desc_nova_dificuldade').css({display: "block"});
              }

              if($('#check_acompanhamento').is(':checked')){
                $('#div_desc_acompanhamento').css({display: "block"});
              }
          };

          function descVisible(){
            if(document.getElementById('div_desc_treinamento').style.display == 'none') {
              document.getElementById('div_desc_treinamento').style.display = 'block';
            }else {
              document.getElementById('div_desc_treinamento').style.display = 'none';
            }
          }

          function superadaVisible(){
            if(document.getElementById('div_desc_superada').style.display == 'none') {
              document.getElementById('div_desc_superada').style.display = 'block';
            }else {
              document.getElementById('div_desc_superada').style.display = 'none';
            }
          }

          function novaDificuldadeVisible(){
            if(document.getElementById('div_desc_nova_dificuldade').style.display == 'none') {
              document.getElementById('div_desc_nova_dificuldade').style.display = 'block';
            }else {
              document.getElementById('div_desc_nova_dificuldade').style.display = 'none';
            }
          }

          function acompVisible(){
            if(document.getElementById('div_desc_acompanhamento').style.display == 'none') {
              document.getElementById('div_desc_acompanhamento').style.display = 'block';
            }else {
              document.getElementById('div_desc_acompanhamento').style.display = 'none';
            }
          }
        </script>
		</body>

</html>
