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

      <div style="padding-bottom: 1%">
        <h3><span><strong>Informações do Estágio</strong></span></h3>
      </div>

      <hr>

    <div id="info_estagio">
      <p><strong>Obrigatório: </strong>
        <?php
        if($_SESSION['estagio']['obrigatorio']){
          echo "Sim";
        }else{
          echo "Não";
        }
        ?></p>

      <hr>

      <p><strong>Orientação</strong></p>

      <p><strong>Professor: </strong><?php echo $_SESSION['estagio']['nome_professor'] ?></p>
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
