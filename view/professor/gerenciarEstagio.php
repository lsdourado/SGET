<?php
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../../index.php');
}

$_SESSION['id_gerenciar'] = @$_GET['id_gerenciar'];

include_once("../data_access/professor/buscarEstagioAluno.php");
$_SESSION['estagio'] = mysqli_fetch_assoc($_SESSION['result_estagios']);

include_once("../data_access/professor/buscarRelatorioFinal.php");
$_SESSION['relatorio'] = mysqli_fetch_assoc($_SESSION['result_relatorio']);

include_once("../data_access/professor/buscarEntrevistaFinal.php");
$_SESSION['entrevistaFinal'] = mysqli_fetch_assoc($_SESSION['result_entrevistaFinal']);

include_once("../data_access/professor/buscarPlanoTrabalho.php");
$plano = mysqli_fetch_assoc($_SESSION['result_plano']);

include_once("../data_access/professor/buscarPrimeiraEntrevista.php");
$_SESSION['primeira_entrevista'] = mysqli_fetch_assoc($_SESSION['result_primeiraEntrevista']);

include_once("../data_access/professor/buscarSegundaEntrevista.php");
$_SESSION['segunda_entrevista'] = mysqli_fetch_assoc($_SESSION['result_segundaEntrevista']);

include_once("../data_access/professor/buscarAvaliacaoEntrevista.php");
$_SESSION['avaliacao_entrevista1'] = mysqli_fetch_assoc($_SESSION['result_avaliacao_1']);
$_SESSION['avaliacao_entrevista2'] = mysqli_fetch_assoc($_SESSION['result_avaliacao_2']);

include_once("../data_access/professor/buscarAvaliacaoEmpresa.php");
$avaliacao_empresa = mysqli_fetch_assoc($_SESSION['result_avaliacao']);

include_once("../data_access/professor/buscarBoletim.php");
$_SESSION['boletim'] = mysqli_fetch_assoc($_SESSION['result_boletim']);

$nota_orientacao = $_SESSION['boletim']['nota_orientacao'];
?>

<html>
<header>
  <meta charset="utf-8">
  <title>Coor. Estágio</title>
</header>

<style media="screen">
  .nav-active{
    background: #009933;
    color: #ffffff;
    text-decoration: none;
  }

  .nav-active:hover{
    background: #009933;
    color: #ffffff;
    text-decoration: none;
  }

  .nav,li,a {
    color: #009933;
  }

  .nav,li,a:hover {
    color: #009933;
  }

  .dropdown-menu .dropdown-item:hover{
    background: #009933;
    color: #ffffff;
  }
</style>

<body>

  <div style="padding-bottom: 3%">
    <h3><span><strong>Estágio de <?php echo $_SESSION['estagio']['nome_aluno'] ?></strong></span></h3>
  </div>

  <?php
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

  <ul class="nav nav-tabs" role="tablist" id="nav-estagio">
    <li class="nav-item">
      <a class="nav-link nav-active" href="#" id="btnEstagio">Informações</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="btnDocumentos" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Documentos</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#" id="btnPlanoDeTrabalho" >Plano de Trabalho</a>
        <a class="dropdown-item" href="#" id="btnPrimeiraEntrevista" >1ª Entrevista</a>
        <a class="dropdown-item" href="#" id="btnSegundaEntrevista" >2ª Entrevista</a>
        <a class="dropdown-item" href="#" id="btnEntrevistaFinal" >Entrevista Final</a>
        <a class="dropdown-item" href="#" id="btnRelatorioFinal">Relatório Final</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" id="btnBoletim" >Boletim</a>
    </li>
  </ul>

  <div class="tab-pane fade show" id="aba_estagio" style="margin-top: 2%">


    <p><strong>Aluno</strong></p>

    <p><strong>Matrícula: </strong><?php echo $_SESSION['estagio']['matricula']?></p>
    <p><strong>Curso: </strong><?php echo $_SESSION['estagio']['nome_curso']?></p>

    <hr>

    <p><strong>Empresa</strong></p>

    <p><strong>Nome: </strong><?php echo $_SESSION['estagio']['nome_fantasia_empresa'] ?></p>
    <p><strong>CNPJ: </strong><?php echo $_SESSION['estagio']['cnpj'] ?></p>
    <p><strong>Supervisor: </strong><?php echo $_SESSION['estagio']['nome_supervisor'] ?></p>

    <hr>

    <p><strong>Datas e horários</strong></p>

    <p><strong>Data de início: </strong><?php echo $_SESSION['estagio']['data_inicio'] ?></p>
    <p><strong>Data final: </strong><?php echo $_SESSION['estagio']['data_fim'] ?></p>
    <p><strong>Carga Semanal: </strong><?php echo $_SESSION['estagio']['carga_semanal'] ?></p>
    <p><strong>Horário de início: </strong><?php echo $_SESSION['estagio']['horario_inicio'] ?></p>
    <p><strong>Horário de fim: </strong><?php echo $_SESSION['estagio']['horario_fim'] ?></p>

    <hr>

    <p><strong>Seguro</strong></p>

    <p><strong>Apólice de Seguro: </strong><?php echo $_SESSION['estagio']['apolice_seguro'] ?></p>
    <p><strong>Nome da Seguradora: </strong><?php echo $_SESSION['estagio']['nome_seguradora'] ?></p>
    <p><strong>Valor do seguro: </strong><?php echo $_SESSION['estagio']['valor_seguro'] ?></p>

    <hr>

    <p><strong>Outros Valores</strong></p>

    <p><strong>Bolsa: </strong><?php echo $_SESSION['estagio']['bolsa_auxilio'] ?></p>
    <p><strong>Auxílio Transporte: </strong><?php echo $_SESSION['estagio']['auxilio_transporte'] ?></p>
  </div>

  <div id="aba_relatorio_final" style="display:none; margin-top: 2%">
    <?php
      if($_SESSION['relatorio']['encerrado']) {
        ?>
        <div class="alert alert-warning" role="alert">
          Você encerrou o documento anteriormente e por isso não pode mais editá-lo.
        </div>
        <?php
      }
    ?>

    <div style="padding-bottom: 1%">
        <h5><span><strong>Relatório Final</strong></span></h5>
    </div>

    <hr>

    <form action="../data_access/professor/editarRelatorioFinal.php" method="post">

      <input type="hidden" name="id_estagio" id="id_estagio" value="<?php echo $_SESSION['estagio']['id_estagio'] ?>">
      <input type="hidden" name="relatorio_encerrado" id="relatorio_encerrado" value="<?php echo $_SESSION['relatorio']['encerrado'] ?>">
      <div class="form-group">
        <label for="desc_empresa" style="font-weight:bold;">Apresentação da empresa</label>
        <textarea class="form-control" id="desc_empresa" name="desc_empresa" rows="6" disabled><?php echo $_SESSION['relatorio']['desc_empresa'] ?></textarea>
      </div>
      <div class="form-group">
        <label for="desc_atividade" style="font-weight:bold;">Descrição das atividades</label>
        <textarea class="form-control" id="desc_atividade" name="desc_atividade" rows="6" disabled><?php echo $_SESSION['relatorio']['desc_atividade'] ?></textarea>
      </div>
      <div class="form-group">
        <label for="conclusao" style="font-weight:bold;">Conclusões</label>
        <textarea class="form-control" id="conclusao" name="conclusao" rows="6" disabled><?php echo $_SESSION['relatorio']['conclusao'] ?></textarea>
      </div>
      <div class="form-group">
				<label for="nota_relatorio_final" style="font-weight:bold;">Nota do relatório final</label>
        <input type="text" maxlength="3" name="nota_relatorio_final" id="nota_relatorio_final" value="<?php echo $_SESSION['relatorio']['nota'] ?>" style="width:60px">
				<small>(Atribuir uma nota de 0 a 10)</small>
			</div>

      <span><font color="red">*Ao encerrar o documento, este não poderá mais ser editado por nenhum usuário.</font></span>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="check_encerrarRelatorio" name="check_encerrarRelatorio" <?php if($_SESSION['relatorio']['encerrado']==true){echo "checked";} ?>>
        <label class="form-check-label" for="check_encerrarRelatorio" style="font-weight:bold;">Encerrar o Relatório Final</label>
      </div>
      <input type="submit" name="salvar_relatorio" id="salvar_relatorio" class="btn btn-success" value="Salvar" style="float:right;margin-bottom:1%">
    </form>
  </div>
  <script>
		jQuery.fn.removeNot = function( settings ){
			var $this = jQuery( this );
			var defaults = {
				pattern: /[^0-9]/,
				replacement: ''
			}
			settings = jQuery.extend(defaults, settings);

			$this.keyup(function(){
				var new_value = $this.val().replace( settings.pattern, settings.replacement );
				$this.val( new_value );
			});
			return $this;
		}

		String.prototype.replaceAt=function(index, replacement) {
	    return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
		}

		function validaPontos(valor) {
			var quantidadeDePontos = 0;
			for (var i = 0; i < valor.length; i++) {
				if (valor[i] === '.') {
					quantidadeDePontos++;
				}
			}
			return quantidadeDePontos;
		}

		$("#nota_relatorio_final").removeNot({ pattern: /[^0-9.]+/g });
		$("#nota_relatorio_final").bind('input propertychange',function(e){
			if(parseFloat($("#nota_relatorio_final").val()) > 10 || parseFloat($("#nota_relatorio_final").val()) < 0){
				$("#nota_relatorio_final").val($("#nota_relatorio_final").val().substr(0, $("#nota_relatorio_final").val().length-1));
			}

			var valor = this.value;
			var pattern = /\.(?=[^.]*$)/;

			if (validaPontos(valor) >= 2) {
				this.value = valor.replace(pattern, "");
			}
		});
  </script>

  <div id="aba_entrevista_final" style="display:none; margin-top: 2%">
    <div style="padding-bottom: 1%">
        <h5><span><strong>Entrevista Final</strong></span></h5>
    </div>

    <hr>

    <h5><span><strong>Estágio</strong></span></h5>

		<small>(Nota de 1 a 5:  1-Insuficiente, 2-Regular, 3-Suficiente, 4-Bom, 5-Excelente)</small>

    <div class="form-group" style="padding-top:2%">
      <label for="av_estagio_1" style="font-weight:bold;">Relação entre os conhecimentos teóricos adquiridos na formação acadêmica e os exigidos no estágio</label>
      <input type="text" id="av_estagio_1" name="av_estagio_1" value="<?php echo $_SESSION['entrevistaFinal']['av_estagio_1'] ?>" style="width:60px" disabled>
    </div>

    <div class="form-group">
      <label for="av_estagio_2" style="font-weight:bold;">Relação entre as habilidades práticas proporcionadas na formação acadêmica e as exigidas no estágio</label>
      <input type="text" id="av_estagio_2" name="av_estagio_2" value="<?php echo $_SESSION['entrevistaFinal']['av_estagio_2'] ?>" style="width:60px" disabled>
    </div>

    <div class="form-group">
      <label for="av_estagio_3" style="font-weight:bold;">Relação entre as disciplinas do curso e as atividades do estágio</label>
      <input type="text" id="av_estagio_3" name="av_estagio_3" value="<?php echo $_SESSION['entrevistaFinal']['av_estagio_3'] ?>" style="width:60px" disabled>
    </div>

    <div class="form-group">
      <label for="av_estagio_4" style="font-weight:bold;">Acompanhamento do professor orientador</label>
      <input type="text" id="av_estagio_4" name="av_estagio_4" value="<?php echo $_SESSION['entrevistaFinal']['av_estagio_4'] ?>" style="width:60px" disabled>
    </div>

    <div class="form-group">
      <label for="av_estagio_5" style="font-weight:bold;">Participação e suporte do IFBA</label>
      <input type="text" id="av_estagio_5" name="av_estagio_5" value="<?php echo $_SESSION['entrevistaFinal']['av_estagio_5'] ?>" style="width:60px" disabled>
    </div>

    <hr>

    <h5><span><strong>Empresa</strong></span></h5>

		<small>(Nota de 1 a 5:  1-Insuficiente, 2-Regular, 3-Suficiente, 4-Bom, 5-Excelente)</small>

    <div class="form-group" style="padding-top:2%">
      <label for="av_empresa_1" style="font-weight:bold;">Conhecimento do setor de trabalho do estágio</label>
      <input type="text" id="av_empresa_1" name="av_empresa_1" value="<?php echo $_SESSION['entrevistaFinal']['av_empresa_1'] ?>" style="width:60px" disabled>
    </div>

    <div class="form-group">
      <label for="av_empresa_2" style="font-weight:bold;">Acompanhamento do supervisor da empresa</label>
      <input type="text" id="av_empresa_2" name="av_empresa_2" value="<?php echo $_SESSION['entrevistaFinal']['av_empresa_2'] ?>" style="width:60px" disabled>
    </div>

    <div class="form-group">
      <label for="av_empresa_3" style="font-weight:bold;">Treinamento e suporte da empresa</label>
      <input type="text" id="av_empresa_3" name="av_empresa_3" value="<?php echo $_SESSION['entrevistaFinal']['av_empresa_3'] ?>" style="width:60px" disabled>
    </div>

    <div class="form-group">
      <label for="av_empresa_4" style="font-weight:bold;">Relacionamento com os colegas de trabalho</label>
      <input type="text" id="av_empresa_4" name="av_empresa_4" value="<?php echo $_SESSION['entrevistaFinal']['av_empresa_4'] ?>" style="width:60px" disabled>
    </div>

    <div class="form-group">
      <label for="av_empresa_5" style="font-weight:bold;">Nível e quantidade de trabalho exigido</label>
      <input type="text" id="av_empresa_5" name="av_empresa_5" value="<?php echo $_SESSION['entrevistaFinal']['av_empresa_5'] ?>" style="width:60px" disabled>
    </div>

    <hr>

    <div class="form-group">
      <label for="comentario" style="font-weight:bold;">Comentários e observações do (a) aluno (a)</label>
      <textarea class="form-control" id="comentario" name="comentario" rows="6" disabled><?php echo $_SESSION['entrevistaFinal']['coment'] ?></textarea>
    </div>
  </div>

  <div id="aba_plano_trabalho" style="display:none; margin-top: 2%">
    <?php
      if($plano['encerrado']) {
        ?>
        <div class="alert alert-warning" role="alert">
          Você encerrou o documento anteriormente e por isso não pode mais editá-lo.
        </div>
        <?php
      }
    ?>

    <div style="padding-bottom: 1%">
        <h5><span><strong>Plano de Trabalho</strong></span></h5>
    </div>

    <hr>

    <form action="../data_access/professor/editarPlanoTrabalho.php" method="post">
      <input type="hidden" name="id_plano" id="id_plano" value="<?php echo $plano['id'] ?>">
      <input type="hidden" name="plano_encerrado" id="plano_encerrado" value="<?php echo $plano['encerrado'] ?>">


      <div class="form-group">
        <label for="objetivos" style="font-weight:bold;">Objetivos</label>
        <textarea class="form-control" id="objetivos" name="objetivos" rows="6" disabled><?php echo $plano['objetivo'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="atividades" style="font-weight:bold;">Atividades</label>
        <textarea class="form-control" id="atividades" name="atividades" rows="6" disabled><?php echo $plano['atividade'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="crono_entrevista" style="font-weight:bold;">Cronograma de entrevistas</label>
        <textarea class="form-control" id="crono_entrevista" name="crono_entrevista" rows="6"><?php echo $plano['crono_entrevista'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="instrumento_av" style="font-weight:bold;">Instrumentos de avaliação</label>
        <textarea class="form-control" id="instrumento_av" name="instrumento_av" rows="6"><?php echo $plano['instrumento_av'] ?></textarea>
      </div>

      <span><font color="red">*Ao encerrar o documento, este não poderá mais ser editado por nenhum usuário.</font></span>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="check_encerrarPlano" name="check_encerrarPlano" <?php if($plano['encerrado']){ echo "checked"; } ?>>
        <label class="form-check-label" for="check_encerrarPlano" style="font-weight:bold;">Encerrar o Plano de Trabalho</label>
      </div>

      <input type="submit" name="salvar_plano" id="salvar_plano" class="btn btn-success" value="Salvar" style="float:right;margin-bottom:1%">

    </form>
  </div>

  <div id="aba_primeira_entrevista" style="display:none; margin-top: 2%">
    <?php
      if($_SESSION['primeira_entrevista']['encerrado']) {
        ?>
        <div class="alert alert-warning" role="alert">
          Você encerrou o documento anteriormente e por isso não pode mais editá-lo.
        </div>
        <?php
      }
    ?>

    <button type="button" class="btn btn-info" data-toggle="modal" id="btnAvaliacao_1" data-target="#avaliacao_entrevista_1" style="float:right;">
      Avaliação da Entrevista
    </button>

    <div style="padding-bottom: 1%">
        <h5><span><strong>1ª Entrevista</strong></span></h5>
    </div>



    <hr>

    <form action="../data_access/professor/editarPrimeiraEntrevista.php" method="post">
      <input type="hidden" name="id_entrevista" id="id_entrevista" value="<?php echo $_SESSION['primeira_entrevista']['id'] ?>">
      <input type="hidden" name="entrevista_encerrado_1" id="entrevista_encerrado_1" value="<?php echo $_SESSION['primeira_entrevista']['encerrado'] ?>">

      <div class="form-group">
        <label for="atv_desenvolvida" style="font-weight:bold;">Atividades desenvolvidas</label>
        <textarea class="form-control" id="atv_desenvolvida" name="atv_desenvolvida" rows="6" disabled><?php echo $_SESSION['primeira_entrevista']['atv_desenvolvida'] ?></textarea>
      </div>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="check_treinamento_1" name="check_treinamento_1" onClick="descVisible()" <?php if($_SESSION['primeira_entrevista']['treinamento']){echo "checked";} ?> disabled>
        <label class="form-check-label" for="check_treinamento_1" style="font-weight:bold;">Treinamento realizado</label>
      </div>

      <div class="form-group" style="display:none;" id="div_desc_treinamento_1">
        <label for="desc_treinamento_1" style="font-weight:bold;">Descrição do treinamento</label>
        <textarea class="form-control" id="desc_treinamento_1" name="desc_treinamento_1" rows="6" disabled><?php echo $_SESSION['primeira_entrevista']['desc_treinamento'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="adaptacao" style="font-weight:bold;">Processo de adaptação</label>
        <textarea class="form-control" id="adaptacao" name="adaptacao" rows="6" disabled><?php echo $_SESSION['primeira_entrevista']['adaptacao'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="acompanhamento_emp" style="font-weight:bold;">Acompanhamento da empresa</label>
        <textarea class="form-control" id="acompanhamento_emp" name="acompanhamento_emp" rows="6" disabled><?php echo $_SESSION['primeira_entrevista']['acompanhamento_emp'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="exec_trabalhos" style="font-weight:bold;">Execução dos trabalhos</label>
        <textarea class="form-control" id="exec_trabalhos" name="exec_trabalhos" rows="6" disabled><?php echo $_SESSION['primeira_entrevista']['exec_trabalhos'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="coment_aluno" style="font-weight:bold;">Comentários e observações do (a) aluno (a)</label>
        <textarea class="form-control" id="coment_aluno" name="coment_aluno" rows="6" disabled><?php echo $_SESSION['primeira_entrevista']['coment_aluno'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="coment_professor" style="font-weight:bold;">Comentários e observações do (a) orientador (a)</label>
        <textarea class="form-control" id="coment_professor" name="coment_professor" rows="6"><?php echo $_SESSION['primeira_entrevista']['coment_professor'] ?></textarea>
      </div>

      <span><font color="red">*Ao encerrar o documento, este não poderá mais ser editado por nenhum usuário.</font></span>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="check_encerrarEntrevista1" name="check_encerrarEntrevista1" <?php if($_SESSION['primeira_entrevista']['encerrado']){ echo "checked"; } ?>>
        <label class="form-check-label" for="check_encerrarEntrevista1" style="font-weight:bold;">Encerrar a 1ª Entrevista</label>
      </div>

      <input type="submit" name="salvar_entrevista_1" id="salvar_entrevista_1" class="btn btn-success" value="Salvar" style="float:right;margin-bottom:1%">

    </form>
  </div>

  <div id="aba_segunda_entrevista" style="display:none; margin-top: 2%">
    <?php
      if($_SESSION['segunda_entrevista']['encerrado']) {
        ?>
        <div class="alert alert-warning" role="alert">
          Você encerrou o documento anteriormente e por isso não pode mais editá-lo.
        </div>
        <?php
      }
    ?>

    <button type="button" class="btn btn-info" data-toggle="modal" id="btnAvaliacao_2" data-target="#avaliacao_entrevista_2" style="float:right;">
      Avaliação da entrevista
    </button>

    <div style="padding-bottom: 1%">
        <h5><span><strong>2ª Entrevista</strong></span></h5>
    </div>

    <hr>

    <form action="../data_access/professor/editarSegundaEntrevista.php" method="post">
      <input type="hidden" name="id_entrevista" id="id_entrevista" value="<?php echo $_SESSION['segunda_entrevista']['id'] ?>">
      <input type="hidden" name="entrevista_encerrado_2" id="entrevista_encerrado_2" value="<?php echo $_SESSION['segunda_entrevista']['encerrado'] ?>">

      <div class="form-group">
        <label for="atv_desenvolvida" style="font-weight:bold;">Atividades desenvolvidas</label>
        <textarea class="form-control" id="atv_desenvolvida" name="atv_desenvolvida" rows="6" disabled><?php echo $_SESSION['segunda_entrevista']['atv_desenvolvida'] ?></textarea>
      </div>

      <div class="form-group form-check">
        <input type="checkbox" disabled class="form-check-input" id="check_treinamento_2" name="check_treinamento_2" onClick="descVisible()" <?php if($_SESSION['segunda_entrevista']['treinamento']){echo "checked";} ?>>
        <label class="form-check-label" for="check_treinamento_2">Treinamento após 1ª entrevista realizado</label>
      </div>

      <div class="form-group" style="display:none;" id="div_desc_treinamento_2">
        <label for="desc_treinamento_2" style="font-weight:bold;">Descrição do treinamento</label>
        <textarea class="form-control" id="desc_treinamento_2" name="desc_treinamento_2" rows="6" disabled><?php echo $_SESSION['segunda_entrevista']['desc_treinamento'] ?></textarea>
      </div>

      <div class="form-group form-check">
        <input type="checkbox" disabled class="form-check-input" id="check_dif_superada" name="check_dif_superada" onClick="superadaVisible()" <?php if($_SESSION['segunda_entrevista']['dif_superada']){echo "checked";} ?>>
        <label class="form-check-label" for="check_dif_superada">Dificuldades anteriores foram superadas</label>
      </div>

      <div class="form-group" style="display:none;" id="div_desc_superada">
        <label for="desc_dif_superada" style="font-weight:bold;">Descrição das dificuldades anteriores</label>
        <textarea class="form-control" id="desc_dif_superada" name="desc_dif_superada" rows="6" disabled><?php echo $_SESSION['segunda_entrevista']['desc_dificuldade_ant'] ?></textarea>
      </div>

      <div class="form-group form-check">
        <input type="checkbox" disabled class="form-check-input" id="check_nova_dificuldade" name="check_nova_dificuldade" onclick="novaDificuldadeVisible()" <?php if($_SESSION['segunda_entrevista']['nova_dificuldade']){echo "checked";} ?>>
        <label class="form-check-label" for="check_nova_dificuldade">Novas dificuldades</label>
      </div>

      <div class="form-group" style="display:none;" id="div_desc_nova_dificuldade">
        <label for="desc_nova_dificuldade" style="font-weight:bold;">Descrição das novas dificuldades</label>
        <textarea class="form-control" id="desc_nova_dificuldade" name="desc_nova_dificuldade" rows="6" disabled><?php echo $_SESSION['segunda_entrevista']['desc_nova_dificuldade'] ?></textarea>
      </div>

      <div class="form-group form-check">
        <input type="checkbox" disabled class="form-check-input" id="check_acompanhamento" name="check_acompanhamento" onClick="acompVisible()" <?php if($_SESSION['segunda_entrevista']['acomp_mantido']){echo "checked";} ?>>
        <label class="form-check-label" for="check_acompanhamento">Acompanhamento da empresa foi mantido</label>
      </div>

      <div class="form-group" style="display:none;" id="div_desc_acompanhamento">
        <label for="desc_acompanhamento_2" style="font-weight:bold;">Descrição do acompanhamento</label>
        <textarea class="form-control" id="desc_acompanhamento_2" name="desc_acompanhamento_2" rows="6" disabled><?php echo $_SESSION['segunda_entrevista']['desc_acompanhamento'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="relacao" style="font-weight:bold;">Relação entre disciplinas e estágio</label>
        <textarea class="form-control" id="relacao" name="relacao" rows="6" disabled><?php echo $_SESSION['segunda_entrevista']['desc_relacao'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="coment_aluno" style="font-weight:bold;">Comentários e observações do (a) aluno (a)</label>
        <textarea class="form-control" id="coment_aluno" name="coment_aluno" rows="6" disabled><?php echo $_SESSION['segunda_entrevista']['coment_aluno'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="coment_professor" style="font-weight:bold;">Comentários e observações do (a) orientador (a)</label>
        <textarea class="form-control" id="coment_professor" name="coment_professor" rows="6"><?php echo $_SESSION['segunda_entrevista']['coment_professor'] ?></textarea>
      </div>

      <span><font color="red">*Ao encerrar o documento, este não poderá mais ser editado por nenhum usuário.</font></span>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="check_encerrarEntrevista2" name="check_encerrarEntrevista2" <?php if($_SESSION['segunda_entrevista']['encerrado']){echo "checked";} ?>>
        <label class="form-check-label" for="check_encerrarEntrevista2" style="font-weight:bold;">Encerrar a 2ª Entrevista</label>
      </div>

      <input type="submit" name="salvar_entrevista_2" id="salvar_entrevista_2" class="btn btn-success" value="Salvar" style="float:right;margin-bottom:1%">

    </form>
  </div>

  <div id="aba_boletim" style="display:none; margin-top: 2%">

    <?php
      if($_SESSION['boletim']['encerrado']) {
        ?>
        <div class="alert alert-warning" role="alert">
          Você encerrou o documento anteriormente e por isso não pode mais editá-lo.
        </div>
        <?php
      }
    ?>

    <table class="table table-sm table-bordered table-light">
      <thead class="card-header">
        <tr>
          <th scope="col" style="padding-left:5%; width:80%">Orientação do professor</th>
          <th scope="col" style="padding-left:5%">Nota</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding-left:5%">Nota da 1ª entrevista</td>
          <td style="padding-left:5%">
            <?php
            if($_SESSION['avaliacao_entrevista1']['nota'] > 0){
                echo $_SESSION['avaliacao_entrevista1']['nota'];
            }
            ?>
          </td>
        </tr>
        <tr>
          <td style="padding-left:5%">Nota da 2ª entrevista</td>
          <td style="padding-left:5%">
            <?php
            if($_SESSION['avaliacao_entrevista2']['nota'] > 0){
                echo $_SESSION['avaliacao_entrevista2']['nota'];
            }
            ?>
          </td>
        </tr>
      </tbody>
      <thead class="card-header">
        <tr>
          <th style="padding-left:5%"><span style="float:right; margin-right:2%">Nota da orientação</span></th>
          <th style="padding-left:5%">
            <?php
            if($nota_orientacao > 0){
              echo number_format($nota_orientacao,1,",",".");
            }
            ?>
          </th>
        </tr>
      </thead>
    </table>

    <hr>

    <table class="table table-sm table-bordered table-light">
      <thead class="card-header">
        <tr>
          <th scope="col" style="padding-left:5%; width:80%">Supervisão da empresa</th>
          <th scope="col" style="padding-left:5%">Nota</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding-left:5%">Aspectos humanos</td>
          <td style="padding-left:5%">
            <?php
            if($avaliacao_empresa['nota_humano'] > 0){
                echo $avaliacao_empresa['nota_humano'];
            }
            ?>
          </td>
        </tr>
        <tr>
          <td style="padding-left:5%">Aspectos profissionais</td>
          <td style="padding-left:5%">
            <?php
            if($avaliacao_empresa['nota_profissional'] > 0){
                echo $avaliacao_empresa['nota_profissional'];
            }
            ?>
          </td>
        </tr>
      </tbody>
      <thead class="card-header">
        <tr>
          <th style="padding-left:5%"><span style="float:right; margin-right:2%">Nota da empresa</span></th>
          <th style="padding-left:5%">
            <?php
              if($avaliacao_empresa['nota_final'] > 0){
                echo number_format($avaliacao_empresa['nota_final'],1,",",".");
              }
            ?>
          </th>
        </tr>
      </thead>
    </table>

    <hr>

    <table class="table table-sm table-bordered table-light">
      <thead class="card-header">
        <tr>
          <th scope="col" style="padding-left:5%; width:80%">Estágio</th>
          <th scope="col" style="padding-left:5%">Nota</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding-left:5%">Nota do relatório final</td>
          <td style="padding-left:5%">
            <?php
            if($_SESSION['relatorio']['nota'] > 0){
                echo number_format($_SESSION['relatorio']['nota'],1,",",".");
            }
            ?>
          </td>
        </tr>
      </tbody>
      <thead class="card-header">
        <tr>
          <th scope="col" style="padding-left:5%; width:79.3%"><span style="float:right; margin-right:2%">NOTA FINAL</span></th>
          <th scope="col" style="padding-left:5%">
            <?php
            if($_SESSION['boletim']['nota_final'] > 0) {
              echo number_format($_SESSION['boletim']['nota_final'],1,",",".");
            }
            ?>
          </th>
        </tr>
      </thead>

      <thead class="card-header">
        <tr>
          <th scope="col" style="padding-left:5%; width:79.3%"><span style="float:right; margin-right:2%">Situação</span></th>
          <td scope="col" style="padding-left:5%">
            <?php
              if($_SESSION['boletim']['encerrado']){
                if($_SESSION['boletim']['situacao']=="Aprovado"){
                  ?>
                  <span style="color:green">Aprovado</span>
                  <?php
                }elseif($_SESSION['boletim']['situacao']=="Reprovado"){
                  ?>
                  <span style="color:red">Reprovado</span>
                  <?php
                }
              }
            ?>
          </td>
        </tr>
      </thead>
  </table>

  <form action="../data_access/professor/editarBoletim.php" method="post">
    <input type="hidden" name="boletim_encerrado" id="boletim_encerrado" value="<?php echo $_SESSION['boletim']['encerrado'] ?>">
    <input type="hidden" name="id_boletim" id="id_boletim" value="<?php echo $_SESSION['boletim']['id'] ?>">
    <input type="hidden" name="nota_final" id="nota_final" value="<?php echo $_SESSION['boletim']['nota_final'] ?>">

    <div class="form-group">
      <label for="observacao" style="font-weight:bold;">Comentários e observações</label>
      <textarea class="form-control" id="observacao" name="observacao" rows="6"><?php echo $_SESSION['boletim']['observacao'] ?></textarea>
    </div>

    <span><font color="red">*Ao encerrar o documento, <strong>TODOS</strong> os documentos do estágio não poderão mais ser editados por nenhum usuário.</font></span>

    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input" id="check_encerrarBoletim" name="check_encerrarBoletim" <?php if($_SESSION['boletim']['encerrado']){echo "checked";} ?>>
      <label class="form-check-label" for="check_encerrarBoletim" style="font-weight:bold;">Encerrar o Boletim</label>
    </div>


    <input type="submit" name="salvar_boletim" id="salvar_boletim" class="btn btn-success" value="Salvar" style="float:right;margin-bottom:1%">
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
        <?php
          if($_SESSION['avaliacao_entrevista1']['av_encerrado']) {
            ?>
            <div class="alert alert-warning" role="alert">
              Você encerrou o documento anteriormente e por isso não pode mais editá-lo.
            </div>
            <?php
          }
        ?>

        <form action="../data_access/professor/editarAvaliacaoEntrevista.php" method="post" id="aba_avaliacao_1">
          <input type="hidden" name="id_avaliacao_1" id="id_avaliacao_1" value="<?php echo $_SESSION['avaliacao_entrevista1']['id_avaliacao'] ?>">
          <input type="hidden" name="av_encerrado_1" id="av_encerrado_1" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_encerrado'] ?>">
					<small>(Atribuir uma nota de 0 a 10 para cada critério)</small>
					<div class="form-group" style="padding-top:2%">
            <label for="av_criterio_1" style="font-weight:bold;">Conhecimento do estagiário sobre o setor de trabalho</label>
            <input type="text" class="only-number" maxlength="3" data-aceppt-dot="1" size="10" id="av_criterio_1" name="av_criterio_1" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_1'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="av_criterio_2" style="font-weight:bold;">Adaptação do estagiário ao ambiente de trabalho</label>
            <input type="text" id="av_criterio_2" maxlength="3" name="av_criterio_2" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_2'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="av_criterio_3" style="font-weight:bold;">Uso de habilidades e conhecimentos adquiridos no curso</label>
            <input type="text" id="av_criterio_3" maxlength="3" name="av_criterio_3" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_3'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="av_criterio_4" style="font-weight:bold;">Relacionamento interpessoal do estagiário</label>
            <input type="text" id="av_criterio_4" maxlength="3" name="av_criterio_4" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_4'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="av_criterio_5" style="font-weight:bold;">Proatividade e comprometimento do estagiário na execução de tarefas</label>
            <input type="text" id="av_criterio_5" maxlength="3" name="av_criterio_5" value="<?php echo $_SESSION['avaliacao_entrevista1']['av_criterio_5'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="nota_entrevista_1" style="font-weight:bold;">Nota da entrevista</label>
            <input type="text" id="nota_entrevista_1" name="nota_entrevista_1" value="<?php echo $_SESSION['avaliacao_entrevista1']['nota_avaliacao'] ?>" style="width:60px" disabled>
						<small>((Soma das notas de cada critério*2)/10)</small>
					</div>
          <input type="hidden" name="nota1" id="nota1" value="<?php echo $_SESSION['avaliacao_entrevista1']['nota_avaliacao'] ?>">

          <div class="form-group">
            <label for="observacao_avaliacao_1" style="font-weight:bold;">Comentários e observações</label>
            <textarea class="form-control" id="observacao_avaliacao_1" name="observacao_avaliacao_1" rows="6"><?php echo $_SESSION['avaliacao_entrevista1']['observacao'] ?></textarea>
          </div>

          <span><font color="red">*Ao encerrar o documento, este não poderá mais ser editado por nenhum usuário.</font></span>

          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="check_encerrar_av_1" name="check_encerrar_av_1" <?php if($_SESSION['avaliacao_entrevista1']['av_encerrado']){echo "checked";} ?>>
            <label class="form-check-label" for="check_encerrar_av_1" style="font-weight:bold;">Encerrar Avaliação</label>
          </div>

          <div style="float:right;">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <input type="submit" name="salvar_avaliacao_1" id="salvar_avaliacao_1" class="btn btn-success" value="Salvar">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
	$("#av_criterio_1").removeNot({ pattern: /[^0-9.]+/g });
	$("#av_criterio_1").bind('input propertychange',function(e){
		if(parseFloat($("#av_criterio_1").val()) > 10 || parseFloat($("#av_criterio_1").val()) < 0){
			$("#av_criterio_1").val($("#av_criterio_1").val().substr(0, $("#av_criterio_1").val().length-1));
		}

		var valor = this.value;
	  var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});

	$("#av_criterio_2").removeNot({ pattern: /[^0-9.]+/g });
	$("#av_criterio_2").bind('input propertychange',function(){
		if(parseFloat($("#av_criterio_2").val()) > 10 || parseFloat($("#av_criterio_2").val()) < 0){
			$("#av_criterio_2").val($("#av_criterio_2").val().substr(0, $("#av_criterio_2").val().length-1));
		}

		var valor = this.value;
	  var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});

	$("#av_criterio_3").removeNot({ pattern: /[^0-9.]+/g });
	$("#av_criterio_3").bind('input propertychange',function(){
		if(parseFloat($("#av_criterio_3").val()) > 10 || parseFloat($("#av_criterio_3").val()) < 0){
			$("#av_criterio_3").val($("#av_criterio_3").val().substr(0, $("#av_criterio_3").val().length-1));
		}

		var valor = this.value;
	  var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});

	$("#av_criterio_4").removeNot({ pattern: /[^0-9.]+/g });
	$("#av_criterio_4").bind('input propertychange',function(){
		if(parseFloat($("#av_criterio_4").val()) > 10 || parseFloat($("#av_criterio_4").val()) < 0){
			$("#av_criterio_4").val($("#av_criterio_4").val().substr(0, $("#av_criterio_4").val().length-1));
		}

		var valor = this.value;
	  var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});

	$("#av_criterio_5").removeNot({ pattern: /[^0-9.]+/g });
	$("#av_criterio_5").bind('input propertychange',function(){
		if(parseFloat($("#av_criterio_5").val()) > 10 || parseFloat($("#av_criterio_5").val()) < 0){
			$("#av_criterio_5").val($("#av_criterio_5").val().substr(0, $("#av_criterio_5").val().length-1));
		}

		var valor = this.value;
	  var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});
</script>

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
        <?php
          if($_SESSION['avaliacao_entrevista2']['av_encerrado']) {
            ?>
            <div class="alert alert-warning" role="alert">
              Você encerrou o documento anteriormente e por isso não pode mais editá-lo.
            </div>
            <?php
          }
        ?>

        <form action="../data_access/professor/editarAvaliacaoEntrevista.php" method="post" id="aba_avaliacao_2">
          <input type="hidden" name="id_avaliacao_2" id="id_avaliacao_2" value="<?php echo $_SESSION['avaliacao_entrevista2']['id_avaliacao'] ?>">
          <input type="hidden" name="av_encerrado_2" id="av_encerrado_2" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_encerrado'] ?>">

					<small>(Atribuir uma nota de 0 a 10 para cada critério)</small>

					<div class="form-group" style="padding-top:2%">
            <label for="av2_criterio_1" style="font-weight:bold;">Conhecimento do estagiário sobre o setor de trabalho</label>
            <input type="text" maxlength="3" id="av2_criterio_1" name="av2_criterio_1" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_1'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="av2_criterio_2" style="font-weight:bold;">Adaptação do estagiário ao ambiente de trabalho</label>
            <input type="text" maxlength="3" id="av2_criterio_2" name="av2_criterio_2" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_2'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="av2_criterio_3" style="font-weight:bold;">Uso de habilidades e conhecimentos adquiridos no curso</label>
            <input type="text" maxlength="3" id="av2_criterio_3" name="av2_criterio_3" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_3'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="av2_criterio_4" style="font-weight:bold;">Relacionamento interpessoal do estagiário</label>
            <input type="text" maxlength="3" id="av2_criterio_4" name="av2_criterio_4" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_4'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="av2_criterio_5" style="font-weight:bold;">Proatividade e comprometimento do estagiário na execução de tarefas</label>
            <input type="text" maxlength="3" id="av2_criterio_5" name="av2_criterio_5" value="<?php echo $_SESSION['avaliacao_entrevista2']['av_criterio_5'] ?>" style="width:60px">
          </div>

          <div class="form-group">
            <label for="nota_entrevista_2" style="font-weight:bold;">Nota da entrevista</label>
            <input type="text" id="nota_entrevista_2" name="nota_entrevista_2" value="<?php echo $_SESSION['avaliacao_entrevista2']['nota_avaliacao'] ?>" style="width:60px" disabled>
						<small>((Soma das notas de cada critério*2)/10)</small>
					</div>
          <input type="hidden" name="nota2" id="nota2" value="<?php echo $_SESSION['avaliacao_entrevista2']['nota_avaliacao'] ?>">

          <div class="form-group">
            <label for="observacao_avaliacao_2" style="font-weight:bold;">Comentários e observações</label>
            <textarea class="form-control" id="observacao_avaliacao_2" name="observacao_avaliacao_2" rows="6"><?php echo $_SESSION['avaliacao_entrevista2']['observacao'] ?></textarea>
          </div>

          <span><font color="red">*Ao encerrar o documento, este não poderá mais ser editado por nenhum usuário.</font></span>

          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="check_encerrar_av_2" name="check_encerrar_av_2" <?php if($_SESSION['avaliacao_entrevista2']['av_encerrado']){echo "checked";} ?>>
            <label class="form-check-label" for="check_encerrar_av_2" style="font-weight:bold;">Encerrar Avaliação</label>
          </div>

          <div style="float:right;">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <input type="submit" name="salvar_avaliacao_2" id="salvar_avaliacao_2" class="btn btn-success" value="Salvar">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
	$("#av2_criterio_1").removeNot({ pattern: /[^0-9.]+/g });
	$("#av2_criterio_1").bind('input propertychange',function(e){
		if(parseFloat($("#av2_criterio_1").val()) > 10 || parseFloat($("#av2_criterio_1").val()) < 0){
			$("#av2_criterio_1").val($("#av2_criterio_1").val().substr(0, $("#av2_criterio_1").val().length-1));
		}

		var valor = this.value;
		var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});

	$("#av2_criterio_2").removeNot({ pattern: /[^0-9.]+/g });
	$("#av2_criterio_2").bind('input propertychange',function(){
		if(parseFloat($("#av2_criterio_2").val()) > 10 || parseFloat($("#av2_criterio_2").val()) < 0){
			$("#av2_criterio_2").val($("#av2_criterio_2").val().substr(0, $("#av2_criterio_2").val().length-1));
		}

		var valor = this.value;
		var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});

	$("#av2_criterio_3").removeNot({ pattern: /[^0-9.]+/g });
	$("#av2_criterio_3").bind('input propertychange',function(){
		if(parseFloat($("#av2_criterio_3").val()) > 10 || parseFloat($("#av2_criterio_3").val()) < 0){
			$("#av2_criterio_3").val($("#av2_criterio_3").val().substr(0, $("#av2_criterio_3").val().length-1));
		}

		var valor = this.value;
		var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});

	$("#av2_criterio_4").removeNot({ pattern: /[^0-9.]+/g });
	$("#av2_criterio_4").bind('input propertychange',function(){
		if(parseFloat($("#av2_criterio_4").val()) > 10 || parseFloat($("#av2_criterio_4").val()) < 0){
			$("#av2_criterio_4").val($("#av2_criterio_4").val().substr(0, $("#av2_criterio_4").val().length-1));
		}

		var valor = this.value;
		var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});

	$("#av2_criterio_5").removeNot({ pattern: /[^0-9.]+/g });
	$("#av2_criterio_5").bind('input propertychange',function(){
		if(parseFloat($("#av2_criterio_5").val()) > 10 || parseFloat($("#av2_criterio_5").val()) < 0){
			$("#av2_criterio_5").val($("#av2_criterio_5").val().substr(0, $("#av2_criterio_5").val().length-1));
		}

		var valor = this.value;
		var pattern = /\.(?=[^.]*$)/;

		if (validaPontos(valor) >= 2) {
			this.value = valor.replace(pattern, "");
		}
	});
</script>


  <script>
    function hideAll() {
      document.getElementById('aba_estagio').style.display = 'none';
      document.getElementById('aba_relatorio_final').style.display = 'none';
      document.getElementById('aba_entrevista_final').style.display = 'none';
      document.getElementById('aba_plano_trabalho').style.display = 'none';
      document.getElementById('aba_primeira_entrevista').style.display = 'none';
      document.getElementById('aba_segunda_entrevista').style.display = 'none';
      document.getElementById('aba_boletim').style.display = 'none';
      $('#nav-estagio a').removeClass('nav-active');
      $('#btnDocumentos').removeClass('nav-active');
    }

    $('#btnEstagio').on('click', function (){
      hideAll();
      $('#btnEstagio').addClass('nav-active');
      $('#aba_estagio').show();
    });

    $('#btnRelatorioFinal').on('click', function (){
      hideAll();
      $('#btnRelatorioFinal').addClass('nav-active');
      $('#btnDocumentos').addClass('nav-active');
      $('#aba_relatorio_final').show();

      if($('#relatorio_encerrado').val()==true){
        $('#aba_relatorio_final textarea',).prop("disabled",true);
        $('#aba_relatorio_final input',).prop("disabled",true);
        $('#salvar_relatorio').hide();
      }
    });

    $('#btnEntrevistaFinal').on('click', function (){
      hideAll();
      $('#btnEntrevistaFinal').addClass('nav-active');
      $('#btnDocumentos').addClass('nav-active');
      $('#aba_entrevista_final').show();
    });

    $('#btnPlanoDeTrabalho').on('click', function (){
      hideAll();
      $('#btnPlanoDeTrabalho').addClass('nav-active');
      $('#btnDocumentos').addClass('nav-active');
      $('#aba_plano_trabalho').show();

      if($('#plano_encerrado').val()==true){
        $('#aba_plano_trabalho textarea',).prop("disabled",true);
        $('#aba_plano_trabalho input',).prop("disabled",true);
        $('#salvar_plano').hide();
      }
    });

    $('#btnPrimeiraEntrevista').on('click', function (){
      hideAll();
      $('#btnPrimeiraEntrevista').addClass('nav-active');
      $('#btnDocumentos').addClass('nav-active');
      $('#aba_primeira_entrevista').show();

      if($('#check_treinamento_1').is(':checked')){
        $('#div_desc_treinamento_1').css({display: "block"});
      }

      if($('#entrevista_encerrado_1').val()==true){
        $('#aba_primeira_entrevista textarea',).prop("disabled",true);
        $('#aba_primeira_entrevista input',).prop("disabled",true);
        $('#salvar_entrevista_1').hide();
      }
    });

    $('#btnSegundaEntrevista').on('click', function (){
      hideAll();
      $('#btnSegundaEntrevista').addClass('nav-active');
      $('#btnDocumentos').addClass('nav-active');
      $('#aba_segunda_entrevista').show();

      if($('#check_treinamento_2').is(':checked')){
        $('#div_desc_treinamento_2').css({display: "block"});
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

      if($('#entrevista_encerrado_2').val()==true){
        $('#aba_segunda_entrevista textarea',).prop("disabled",true);
        $('#aba_segunda_entrevista input',).prop("disabled",true);
        $('#salvar_entrevista_2').hide();
      }
    });

    $('#btnBoletim').on('click', function (){
      hideAll();
      $('#btnBoletim').addClass('nav-active');
      $('#aba_boletim').show();

      if($('#boletim_encerrado').val()==true){
        $('#aba_boletim textarea',).prop("disabled",true);
        $('#aba_boletim input',).prop("disabled",true);
        $('#salvar_boletim').hide();
      }
    });

    $('#btnAvaliacao_1').on('click', function (){
      if($('#av_encerrado_1').val()==true){
        $('#aba_avaliacao_1 textarea',).prop("disabled",true);
        $('#aba_avaliacao_1 input',).prop("disabled",true);
        $('#aba_avaliacao_1 button',).hide();
        $('#salvar_avaliacao_1').hide();
      }
    });

    $('#btnAvaliacao_2').on('click', function (){
      if($('#av_encerrado_2').val()==true){
        $('#aba_avaliacao_2 textarea',).prop("disabled",true);
        $('#aba_avaliacao_2 input',).prop("disabled",true);
        $('#aba_avaliacao_2 button',).hide();
        $('#salvar_avaliacao_2').hide();
      }
    });

    //CONTROLE DO CAMPO DE NOTA ENTREVISTA 1

    $('#av_criterio_1').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av_criterio_1').val() != ""){
        av1 = parseFloat($('#av_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av_criterio_2').val() != ""){
        av2 = parseFloat($('#av_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av_criterio_3').val() != ""){
        av3 = parseFloat($('#av_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av_criterio_4').val() != ""){
        av4 = parseFloat($('#av_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av_criterio_5').val() != ""){
        av5 = parseFloat($('#av_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_1').val(resultado);
      $('#nota1').val(resultado);
    });

    $('#av_criterio_2').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av_criterio_1').val() != ""){
        av1 = parseFloat($('#av_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av_criterio_2').val() != ""){
        av2 = parseFloat($('#av_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av_criterio_3').val() != ""){
        av3 = parseFloat($('#av_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av_criterio_4').val() != ""){
        av4 = parseFloat($('#av_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av_criterio_5').val() != ""){
        av5 = parseFloat($('#av_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_1').val(resultado);
      $('#nota1').val(resultado);
    });

    $('#av_criterio_3').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av_criterio_1').val() != ""){
        av1 = parseFloat($('#av_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av_criterio_2').val() != ""){
        av2 = parseFloat($('#av_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av_criterio_3').val() != ""){
        av3 = parseFloat($('#av_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av_criterio_4').val() != ""){
        av4 = parseFloat($('#av_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av_criterio_5').val() != ""){
        av5 = parseFloat($('#av_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_1').val(resultado);
      $('#nota1').val(resultado);
    });

    $('#av_criterio_4').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av_criterio_1').val() != ""){
        av1 = parseFloat($('#av_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av_criterio_2').val() != ""){
        av2 = parseFloat($('#av_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av_criterio_3').val() != ""){
        av3 = parseFloat($('#av_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av_criterio_4').val() != ""){
        av4 = parseFloat($('#av_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av_criterio_5').val() != ""){
        av5 = parseFloat($('#av_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_1').val(resultado);
      $('#nota1').val(resultado);
    });

    $('#av_criterio_5').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av_criterio_1').val() != ""){
        av1 = parseFloat($('#av_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av_criterio_2').val() != ""){
        av2 = parseFloat($('#av_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av_criterio_3').val() != ""){
        av3 = parseFloat($('#av_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av_criterio_4').val() != ""){
        av4 = parseFloat($('#av_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av_criterio_5').val() != ""){
        av5 = parseFloat($('#av_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_1').val(resultado);
      $('#nota1').val(resultado);
    });

    //CONTROLE DO CAMPO DE NOTA ENTREVISTA 2

    $('#av2_criterio_1').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av2_criterio_1').val() != ""){
        av1 = parseFloat($('#av2_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av2_criterio_2').val() != ""){
        av2 = parseFloat($('#av2_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av2_criterio_3').val() != ""){
        av3 = parseFloat($('#av2_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av2_criterio_4').val() != ""){
        av4 = parseFloat($('#av2_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av2_criterio_5').val() != ""){
        av5 = parseFloat($('#av2_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_2').val(resultado);
      $('#nota2').val(resultado);
    });

    $('#av2_criterio_2').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av2_criterio_1').val() != ""){
        av1 = parseFloat($('#av2_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av2_criterio_2').val() != ""){
        av2 = parseFloat($('#av2_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av2_criterio_3').val() != ""){
        av3 = parseFloat($('#av2_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av2_criterio_4').val() != ""){
        av4 = parseFloat($('#av2_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av2_criterio_5').val() != ""){
        av5 = parseFloat($('#av2_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_2').val(resultado);
      $('#nota2').val(resultado);
    });

    $('#av2_criterio_3').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av2_criterio_1').val() != ""){
        av1 = parseFloat($('#av2_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av2_criterio_2').val() != ""){
        av2 = parseFloat($('#av2_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av2_criterio_3').val() != ""){
        av3 = parseFloat($('#av2_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av2_criterio_4').val() != ""){
        av4 = parseFloat($('#av2_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av2_criterio_5').val() != ""){
        av5 = parseFloat($('#av2_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_2').val(resultado);
      $('#nota2').val(resultado);
    });

    $('#av2_criterio_4').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av2_criterio_1').val() != ""){
        av1 = parseFloat($('#av2_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av2_criterio_2').val() != ""){
        av2 = parseFloat($('#av2_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av2_criterio_3').val() != ""){
        av3 = parseFloat($('#av2_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av2_criterio_4').val() != ""){
        av4 = parseFloat($('#av2_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av2_criterio_5').val() != ""){
        av5 = parseFloat($('#av2_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_2').val(resultado);
      $('#nota2').val(resultado);
    });

    $('#av2_criterio_5').blur(function(){
      let av1;
      let av2;
      let av3;
      let av4;
      let av5;

      if($('#av2_criterio_1').val() != ""){
        av1 = parseFloat($('#av2_criterio_1').val());
      }else {
        av1 = 0;
      }

      if($('#av2_criterio_2').val() != ""){
        av2 = parseFloat($('#av2_criterio_2').val());
      }else {
        av2 = 0;
      }

      if($('#av2_criterio_3').val() != ""){
        av3 = parseFloat($('#av2_criterio_3').val());
      }else {
        av3 = 0;
      }

      if($('#av2_criterio_4').val() != ""){
        av4 = parseFloat($('#av2_criterio_4').val());
      }else {
        av4 = 0;
      }

      if($('#av2_criterio_5').val() != ""){
        av5 = parseFloat($('#av2_criterio_5').val());
      }else {
        av5 = 0;
      }

      let resultado = ((av1+av2+av3+av4+av5)*2)/10;

      $('#nota_entrevista_2').val(resultado);
      $('#nota2').val(resultado);
    });
  </script>
</body>

</html>
