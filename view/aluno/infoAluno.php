<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
    }

    include_once("../data_access/aluno/buscarEstagio.php");
    $_SESSION['estagio'] = mysqli_fetch_assoc($_SESSION['result_estagios']);

?>
<html>
		<header>
				<meta charset="utf-8">
				<title>Coord. Estágio</title>

		</header>

		<body>

      <?php
        if($_SESSION['estagio']==null){
          ?>
          <div class="alert alert-warning" role="alert" id="sem_estagio">
            Você ainda não possui um estágio
          </div>
          <script>
            $('#li_doc_disabled').css({"pointer-events": "none", "opacity": "0.3"});
      			$('#li_estagio').css({"pointer-events": "none", "opacity": "0.3"});
          </script>
          <?php
        }else{
          ?>
          <script>
            $('#li_doc_disabled').css({"pointer-events": "auto", "opacity": "1"});
      			$('#li_estagio').css({"pointer-events": "auto", "opacity": "1"});
          </script>
          <?php
        }
      ?>

      <div style="padding-bottom: 1%">
        <h3><span><strong>Informações de <?php echo $_SESSION['aluno']['nome_aluno'];?></strong></span></h3>
      </div>

      <hr>

    <div id="dados_pessoais">
      <p><strong>Curso: </strong><?php echo $_SESSION['aluno']['nome_curso'] ?></p>
      <p><strong>Matrícula: </strong><?php echo $_SESSION['aluno']['matricula'] ?></p>
      <p><strong>Período: </strong><?php echo $_SESSION['aluno']['periodo'];
      if($_SESSION['aluno']['tipo_curso']=="Graduação"){
        echo "º Semestre";
      }else{
        echo "º Ano";
      }
      ?></p>
      <p><strong>RG: </strong><?php echo $_SESSION['aluno']['rg'] ?></p>
      <p><strong>CPF: </strong><?php echo $_SESSION['aluno']['cpf'] ?></p>
      <p><strong>Data de nascimento: </strong><?php echo $_SESSION['aluno']['data_nascimento'] ?></p>
      <p><strong>Sexo: </strong><?php echo $_SESSION['aluno']['sexo'] ?></p>
      <p><strong>Portador de deficiência: </strong>
        <?php
        if($_SESSION['aluno']['por_deficiencia']) {
          echo "Sim";
        }else {
          echo "Não";
        }
        ?>
      </p>

      <hr>

      <p><strong>Endereço</strong></p>
      <p><strong>Cidade: </strong><?php echo $_SESSION['aluno']['cidade'] ?></p>
      <p><strong>Estado: </strong><?php echo $_SESSION['aluno']['estado'] ?></p>
      <p><strong>Bairro: </strong><?php echo $_SESSION['aluno']['bairro'] ?></p>
      <p><strong>Rua: </strong><?php echo $_SESSION['aluno']['rua']?></p>
      <p><strong>Nº: </strong><?php echo $_SESSION['aluno']['numero']?></p>
      <p><strong>Cep: </strong><?php echo $_SESSION['aluno']['cep'] ?></p>

      <hr>

      <p><strong>Contato</strong></p>
      <p><strong>E-mail: </strong><?php echo $_SESSION['aluno']['email'] ?></p>
      <p><strong>Telefone: </strong><?php echo $_SESSION['aluno']['telefone'] ?></p>
    </div>



    <div id="info_estagio" style="display:none; margin-top: 5%">
      <p><strong>Orientador: </strong><?php echo $_SESSION['estagio']['nome_professor'] ?></p>
      <p><strong>SIAPE: </strong><?php echo $_SESSION['estagio']['siape'] ?></p>

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


		</body>

</html>
