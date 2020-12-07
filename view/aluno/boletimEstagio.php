<?php
    @session_start();

    if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
    		header('Location: ../../index.php');
    }

		include_once("../data_access/aluno/buscarBoletim.php");
    $boletim = mysqli_fetch_assoc($_SESSION['result_boletim']);

    $_SESSION['primeira_entrevista']=$boletim['id_entrevista_1'];
    $_SESSION['segunda_entrevista']=$boletim['id_entrevista_2'];

    include_once("../data_access/aluno/buscarAvaliacaoEntrevista.php");

    $avaliacao_1 = mysqli_fetch_assoc($_SESSION['result_avaliacao_1']);
    $avaliacao_2 = mysqli_fetch_assoc($_SESSION['result_avaliacao_2']);

    include_once("../data_access/aluno/buscarAvaliacaoEmpresa.php");
    $avaliacao_empresa = mysqli_fetch_assoc($_SESSION['result_avaliacao']);

?>
<html>
		<header>
				<meta charset="utf-8">
				<title>Coord. Estágio</title>
		</header>

    <body>
        <div id="backgroud">
            <div style="padding-bottom: 1%">
    						<h3><span><strong>Boletim do Estágio</strong></span></h3>
    				</div>

            <hr>

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
                    if($avaliacao_1['nota'] > 0){
                        echo $avaliacao_1['nota'];
                    }elseif($boletim['encerrado']){
                        echo $avaliacao_1['nota'];
                    }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td style="padding-left:5%">Nota da 2ª entrevista</td>
                  <td style="padding-left:5%">
                    <?php
                    if($avaliacao_2['nota'] > 0){
                        echo $avaliacao_2['nota'];
                    }elseif($boletim['encerrado']){
                        echo $avaliacao_2['nota'];
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
                      if($boletim['nota_orientacao'] > 0){
                        echo number_format($boletim['nota_orientacao'],1,",",".");
                      }elseif($boletim['encerrado']){
                          echo number_format($boletim['nota_orientacao'],1,",",".");
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
                    }elseif($boletim['encerrado']){
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
                    }elseif($boletim['encerrado']){
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
                      if($boletim['nota_empresa'] > 0){
                        echo number_format($boletim['nota_empresa'],1,",",".");
                      }elseif($boletim['encerrado']){
                        echo number_format($boletim['nota_empresa'],1,",",".");
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
                      if($boletim['nota_relatorio'] > 0){
                        echo number_format($boletim['nota_relatorio'],1,",",".");
                      }elseif($boletim['encerrado']){
                        echo number_format($boletim['nota_relatorio'],1,",",".");
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
                      if($boletim['nota_final'] > 0){
                        echo number_format($boletim['nota_final'],1,",",".");
                      }elseif($boletim['encerrado']){
                        echo number_format($boletim['nota_final'],1,",",".");
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
                      if($boletim['encerrado']){
                        if($boletim['situacao']=="Aprovado"){
                          ?>
                          <span style="color:green">Aprovado</span>
                          <?php
                        }elseif($boletim['situacao']=="Reprovado"){
                          ?>
                          <span style="color:red">Reprovado</span>
                          <?php
                        }
                      }else{
                        ?>
                        <span>Em andamento</span>
                        <?php
                      }
                    ?>
                  </td>
                </tr>
              </thead>
            </table>

            <div class="form-group">
              <label for="observacao" style="font-weight:bold;">Comentários e observações</label>
              <textarea class="form-control" id="observacao" name="observacao" rows="6" disabled><?php echo $boletim['observacao'] ?></textarea>
            </div>
        </div>
		</body>

</html>
