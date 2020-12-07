<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
    }

		include_once("../data_access/aluno/buscarEntrevistaFinal.php");
    $entrevista = mysqli_fetch_assoc($_SESSION['result_entrevista']);
?>
<html>
		<header>
				<meta charset="utf-8">
				<title>Coor. Estágio</title>
		</header>

    <body>
        <div id="backgroud">
            <div style="padding-bottom: 1%">
    						<h3><span><strong>Entrevista Final</strong></span></h3>
    				</div>

            <hr>

            <?php
              if($entrevista['encerrado']) {
                ?>
                <div class="alert alert-warning" role="alert">
                  Você encerrou o documento anteriormente e por isso não pode mais editá-lo.
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

            <div style="padding-bottom: 1%">
    						<h6><span><strong>Estágio</strong></span></h6>
    				</div>

            <form action="../data_access/aluno/editarEntrevistaFinal.php" method="post">
              <input type="hidden" name="id_entrevista" id="id_entrevista" value="<?php echo $entrevista['id'] ?>">
              <input type="hidden" name="encerrado" id="encerrado" value="<?php echo $entrevista['encerrado'] ?>">

              <div class="form-group">
                <label for="av_estagio_1" style="font-weight:bold;">Relação entre os conhecimentos teóricos adquiridos na formação acadêmica e os exigidos no estágio</label>
                <input type="text" name="av_estagio_1" id="av_estagio_1" value="<?php echo $entrevista['av_estagio_1'] ?>" style="width:60px">
              </div>

              <div class="form-group">
                <label for="av_estagio_2" style="font-weight:bold;">Relação entre as habilidades práticas proporcionadas na formação acadêmica e as exigidas no estágio</label>
                <input type="text" name="av_estagio_2" id="av_estagio_2" value="<?php echo $entrevista['av_estagio_2'] ?>" style="width:60px">
              </div>

              <div class="form-group">
                <label for="av_estagio_3" style="font-weight:bold;">Relação entre as disciplinas do curso e as atividades do estágio</label>
                <input type="text" name="av_estagio_3" id="av_estagio_3" value="<?php echo $entrevista['av_estagio_3'] ?>" style="width:60px">
              </div>

              <div class="form-group">
                <label for="av_estagio_4" style="font-weight:bold;">Acompanhamento do professor orientador</label>
                <input type="text" name="av_estagio_4" id="av_estagio_4" value="<?php echo $entrevista['av_estagio_4'] ?>" style="width:60px">
              </div>

              <div class="form-group">
                <label for="av_estagio_5" style="font-weight:bold;">Participação e suporte do IFBA</label>
                <input type="text" name="av_estagio_5" id="av_estagio_5" value="<?php echo $entrevista['av_estagio_5'] ?>" style="width:60px">
              </div>

              <hr>

              <div style="padding-bottom: 1%;">
      						<h6><span><strong>Empresa</strong></span></h6>
      				</div>

              <div class="form-group">
                <label for="av_empresa_1" style="font-weight:bold;">Conhecimento do setor de trabalho do estágio</label>
                <input type="text" name="av_empresa_1" id="av_empresa_1" value="<?php echo $entrevista['av_empresa_1'] ?>" style="width:60px">
              </div>

              <div class="form-group">
                <label for="av_empresa_2" style="font-weight:bold;">Acompanhamento do supervisor da empresa</label>
                <input type="text" name="av_empresa_2" id="av_empresa_2" value="<?php echo $entrevista['av_empresa_2'] ?>" style="width:60px">
              </div>

              <div class="form-group">
                <label for="av_empresa_3" style="font-weight:bold;">Treinamento e suporte da empresa</label>
                <input type="text" name="av_empresa_3" id="av_empresa_3" value="<?php echo $entrevista['av_empresa_3'] ?>" style="width:60px">
              </div>

              <div class="form-group">
                <label for="av_empresa_4" style="font-weight:bold;">Relacionamento com os colegas de trabalho</label>
                <input type="text" name="av_empresa_4" id="av_empresa_4" value="<?php echo $entrevista['av_empresa_4'] ?>" style="width:60px">
              </div>

              <div class="form-group">
                <label for="av_empresa_5" style="font-weight:bold;">Nível e quantidade de trabalho exigido</label>
                <input type="text" name="av_empresa_5" id="av_empresa_5" value="<?php echo $entrevista['av_empresa_5'] ?>" style="width:60px">
              </div>

              <hr>

              <div class="form-group">
                <label for="coment" style="font-weight:bold;">Comentários e observações</label>
                <textarea class="form-control" id="coment" name="coment" rows="6"><?php echo $entrevista['coment'] ?></textarea>
              </div>

              <span><font color="red">*Ao encerrar o documento, este não poderá mais ser editado por nenhum usuário.</font></span>

              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="check_encerrar" name="check_encerrar" <?php if($entrevista['encerrado']){echo "checked";} ?>>
                <label class="form-check-label" for="check_encerrar" style="font-weight:bold;">Encerrar a Entrevista Final</label>
              </div>

              <input type="submit" name="salvar" id="salvar" class="btn btn-success" value="Salvar" style="float:right;margin-bottom:1%">

            </form>
        </div>

        <script>
          window.onload = function (e){
              if($('#encerrado').val() == true) {
                $("textarea").prop("disabled",true);
                $("input").prop("disabled",true);
                $("#check_encerrar").prop("disabled",true);
                $("#salvar").hide();
              }
          };

          $(document).ready(function(){
						$("#av_estagio_1").mask("0#");
            $("#av_estagio_2").mask("0#");
            $("#av_estagio_3").mask("0#");
            $("#av_estagio_4").mask("0#");
            $("#av_estagio_5").mask("0#");

            $("#av_empresa_1").mask("0#");
            $("#av_empresa_2").mask("0#");
            $("#av_empresa_3").mask("0#");
            $("#av_empresa_4").mask("0#");
            $("#av_empresa_5").mask("0#");
					});

          $("#av_empresa_1").bind('input propertychange',function(){
            if(parseInt($("#av_empresa_1").val()) > 5 || parseInt($("#av_empresa_1").val()) < 0){
              $("#av_empresa_1").val($("#av_empresa_1").val().substr(0, $("#av_empresa_1").val().length-1));
            }
          });

          $("#av_empresa_2").bind('input propertychange',function(){
            if(parseInt($("#av_empresa_2").val()) > 5 || parseInt($("#av_empresa_2").val()) < 0){
              $("#av_empresa_2").val($("#av_empresa_2").val().substr(0, $("#av_empresa_2").val().length-1));
            }
          });

          $("#av_empresa_3").bind('input propertychange',function(){
            if(parseInt($("#av_empresa_3").val()) > 5 || parseInt($("#av_empresa_3").val()) < 0){
              $("#av_empresa_3").val($("#av_empresa_3").val().substr(0, $("#av_empresa_3").val().length-1));
            }
          });

          $("#av_empresa_4").bind('input propertychange',function(){
            if(parseInt($("#av_empresa_4").val()) > 5 || parseInt($("#av_empresa_4").val()) < 0){
              $("#av_empresa_4").val($("#av_empresa_4").val().substr(0, $("#av_empresa_4").val().length-1));
            }
          });

          $("#av_empresa_5").bind('input propertychange',function(){
            if(parseInt($("#av_empresa_5").val()) > 5 || parseInt($("#av_empresa_5").val()) < 0){
              $("#av_empresa_5").val($("#av_empresa_5").val().substr(0, $("#av_empresa_5").val().length-1));
            }
          });

          $("#av_estagio_1").bind('input propertychange',function(){
            if(parseInt($("#av_estagio_1").val()) > 5 || parseInt($("#av_estagio_1").val()) < 0){
              $("#av_estagio_1").val($("#av_estagio_1").val().substr(0, $("#av_estagio_1").val().length-1));
            }
          });

          $("#av_estagio_2").bind('input propertychange',function(){
            if(parseInt($("#av_estagio_2").val()) > 5 || parseInt($("#av_estagio_2").val()) < 0){
              $("#av_estagio_2").val($("#av_estagio_2").val().substr(0, $("#av_estagio_2").val().length-1));
            }
          });

          $("#av_estagio_3").bind('input propertychange',function(){
            if(parseInt($("#av_estagio_3").val()) > 5 || parseInt($("#av_estagio_3").val()) < 0){
              $("#av_estagio_3").val($("#av_estagio_3").val().substr(0, $("#av_estagio_3").val().length-1));
            }
          });

          $("#av_estagio_4").bind('input propertychange',function(){
            if(parseInt($("#av_estagio_4").val()) > 5 || parseInt($("#av_estagio_4").val()) < 0){
              $("#av_estagio_4").val($("#av_estagio_4").val().substr(0, $("#av_estagio_4").val().length-1));
            }
          });

          $("#av_estagio_5").bind('input propertychange',function(){
            if(parseInt($("#av_estagio_5").val()) > 5 || parseInt($("#av_estagio_5").val()) < 0){
              $("#av_estagio_5").val($("#av_estagio_5").val().substr(0, $("#av_estagio_5").val().length-1));
            }
          });
        </script>
		</body>

</html>
