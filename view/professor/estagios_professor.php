<?php
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../../index.php');
}

include_once("../connection/ConnectionFactory.php");
include_once("../data_access/professor/listarEstagios.php");

if(isset($_POST['buscar'])) {
	include_once("../data_access/professor/buscarEstagio.php");
}

?>
<html>
<header>
	<meta charset="utf-8">
	<title>Coor. Estágio</title>
</header>

<body>

	<div style="padding-bottom: 1%">
		<h3><span><strong>Estágios</strong></span></h3>
	</div>
	<form action="" method="post">
		<div class="form-group" style="float:left; width:60%">
			<input type="text" name="estagio" class="form-control" id="estagio" placeholder="Buscar Estágio" <?php if($_SESSION['result_estagios']->num_rows == 0){ echo "disabled";}?>>
		</div>
		<div style="float:left; padding-left: 1%; padding-top: 8px">
			<img src="img/search.png">
		</div>
		<input type="hidden" name="buscar" value="busca">
	</form>
</br>
</br>
<div id="tabela_estagios">
	<table class="table table-sm table-hover" id="tabela_estagios">
		<thead>
			<tr>
				<th scope="col">Aluno</th>
				<th scope="col">Matrícula</th>
				<th scope="col">Curso</th>
				<th></th>
			</tr>
		</thead>
		<?php
		if($_SESSION['result_estagios']->num_rows > 0){
			?>
			<tbody>
				<?php while($linha = mysqli_fetch_assoc($_SESSION['result_estagios'])){ ?>

					<tr>
						<input type="hidden" value="<?php echo $linha['id']?>" name="id_estagio" id="id_estagio">
						<td style="padding-top:1.3%"><?php echo $linha['nome_aluno'] ?></td>
						<td style="padding-top:1.3%"><?php echo $linha['matricula'] ?></td>
						<td style="padding-top:1.3%"><?php echo $linha['nome_curso'] ?></td>
						<td style="padding-top:1.3%">
							<a href="?Pagina=gerenciarEstagio&id_gerenciar=<?php echo $linha['id_estagio'] ?>"><img src="../view/img/gerenciar.png" style="width:20px;height:20px"></a>
						</td>
					</tr>
				<?php }?>
			</tbody>
			<?php
		}else{
			?>
			<div class="alert alert-warning" role="alert">
				<span>Ainda não há estágios</span>
			</div>
			<?php
		}
		?>
	</table>

</body>
</html>
