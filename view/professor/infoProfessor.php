<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
    }
?>
<html>
		<header>
				<meta charset="utf-8">
				<title>Coor. Estágio</title>
		</header>

		<body>

      <div style="padding-bottom: 3%">
        <h3><span><strong>Informações de <?php echo $_SESSION['professor']['nome_professor'];?></strong></span></h3>
      </div>


    <div id="dados_pessoais">
      <p><strong>SIAPE: </strong><?php echo $_SESSION['professor']['siape'] ?></p>
      <p><strong>Data de nascimento: </strong><?php echo $_SESSION['professor']['data_nascimento'] ?></p>
      <p><strong>Sexo: </strong><?php echo $_SESSION['professor']['sexo'] ?></p>

      <hr>

      <p><strong>Endereço</strong></p>
      <p><strong>Cidade: </strong><?php echo $_SESSION['professor']['cidade'] ?></p>
      <p><strong>Estado: </strong><?php echo $_SESSION['professor']['estado'] ?></p>
      <p><strong>Bairro: </strong><?php echo $_SESSION['professor']['bairro'] ?></p>
      <p><strong>Rua: </strong><?php echo $_SESSION['professor']['rua']?></p>
      <p><strong>Nº: </strong><?php echo $_SESSION['professor']['numero']?></p>
      <p><strong>Cep: </strong><?php echo $_SESSION['professor']['cep'] ?></p>

      <hr>

      <p><strong>Contato</strong></p>
      <p><strong>E-mail: </strong><?php echo $_SESSION['professor']['email'] ?></p>
      <p><strong>Telefone: </strong><?php echo $_SESSION['professor']['telefone'] ?></p>
    </div>

		</body>

</html>
