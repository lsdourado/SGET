<?php
@session_start();

if(!isset($_SESSION['id_login']) || $_SESSION['tipo_login']=="supervisor"){
		header('Location: ../../../index.php');
}

include_once('../../../connection/ConnectionFactory.php');

$id_estagio = @$_GET['id_estagio'];

$consulta = "SELECT *,instituicao.id AS id_instituicao, endereco.id as id_endereco, endereco.cidade AS
            cidade_endereco, endereco.rua AS rua_endereco, endereco.bairro AS bairro_endereco, endereco.numero
            AS numero_endereco, endereco.estado AS estado_endereco, endereco.cep AS cep_endereco FROM instituicao
            INNER JOIN endereco WHERE instituicao.id_endereco = endereco.id";


$result = $mysqli->query($consulta) or die($mysqli->error);
$instituicao = mysqli_fetch_assoc($result);

$consulta = "SELECT *,aluno.email as email_aluno, aluno.telefone as telefone_aluno, aluno.id_endereco as id_endereco_aluno, aluno.data_nascimento as data_aluno, aluno.rg as rg_aluno, aluno.cpf as cpf_aluno, curso.nome as nome_curso, supervisor.nome as nome_supervisor, empresa.email as email_empresa, empresa.telefone as telefone_empresa, aluno.nome as nome_aluno FROM
            estagio INNER JOIN aluno INNER JOIN professor INNER JOIN empresa INNER JOIN endereco INNER JOIN curso INNER JOIN supervisor
            WHERE estagio.id_aluno = aluno.id and estagio.id_professor = professor.id and estagio.id_empresa = empresa.id
            and empresa.id_endereco = endereco.id AND estagio.id_supervisor = supervisor.id AND aluno.id_curso = curso.id AND estagio.id = '$id_estagio'";

$result = $mysqli->query($consulta) or die($mysqli->error);
$estagio = mysqli_fetch_assoc($result);

if($estagio['por_deficiencia']){
  $deficiencia = "Sim";
}else{
  $deficiencia = "Não";
}

if($estagio['obrigatorio']){
  $obrigatorio = "Sim";
}else{
  $obrigatorio = "Não";
}

if($estagio['tipo']=="Graduação"){
  $tipo = "Semestre";
}else{
  $tipo = "Ano";
}

$id_endereco_aluno = $estagio['id_endereco_aluno'];

$consulta_endereco = "SELECT * FROM endereco where id = $id_endereco_aluno";


$result = $mysqli->query($consulta_endereco) or die($mysqli->error);
$endereco_aluno = mysqli_fetch_assoc($result);


use \Dompdf\Dompdf;

require_once '../../../dompdf/autoload.inc.php';

$TERMO_COMPROMISSO = new DOMPDF();

$TERMO_COMPROMISSO->load_html('
<html>
  <head>
		<title>'.$estagio['nome_aluno'].'</title>
    <style>
      @page { margin-top: 5%; }
      header { position: fixed; top:0px;}
    </style>
  </head>

	<div id="body">
    <header>
    <div id="cabecalho" style="padding:1%">
      <div id="logo_ifba" style="float:left">
        <img src="../../../view/img/ifba2.png">
      </div>
      <div id="logo_proex" style="float:right">
        <img src="../../../view/img/proex.png">
      </div>
    </div>
    </header>
    <div id="titulo" style="background-color:darkgray; clear:both; padding:5px; border:solid 0.5px;">
      <strong><center>TERMO DE COMPROMISSO DE ESTÁGIO</center></strong>
    </div>

    <div id="instituicao" style="clear:both; padding:5px; border:solid 0.5px;">
      <strong><center>INSTITUIÇÃO DE ENSINO</center></strong>
    </div>
    <div id="info_instituicao" style="clear:both; border:solid 0.5px; padding:1%; font-size:small;">
      <b>Instituição: '.$instituicao['nome'].'<br>
      Endereço: '.$instituicao['rua'].', '.$instituicao['numero'].', '.$instituicao['bairro'].', CEP: '.$instituicao['cep'].', '.$instituicao['cidade'].', '.$instituicao['estado'].'<br>
      Telefone: '.$instituicao['telefone'].'<br>
      CNPJ: '.$instituicao['cnpj'].'<br>
      Representada por seu Diretor Geral '.$instituicao['diretor'].'<br></b>
    </div>

    <div id="instituicao" style="background-color:gainsboro; clear:both; padding:5px; border:solid 0.5px;">
      <strong><center>UNIDADE CONCEDENTE</center></strong>
    </div>

    <div id="info_concedente" style="font-size:small; clear:both; border:solid 0.5px; padding: 1%;">
      <b>Razão Social:</b> '.$estagio['razao_social'].'<br>
      <b>CNPJ (empresa):</b> '.$estagio['cnpj'].'<br>
      <b>CPF (autônomo):</b><br>
      <b>Endereço:</b> '.$estagio['rua'].', '.$estagio['numero'].', '.$estagio['bairro'].', CEP: '.$estagio['cep'].', '.$estagio['cidade'].', '.$estagio['estado'].'<br>
      <b>Telefone:</b> '.$estagio['telefone_empresa'].'<br>
      <b>E-mail:</b> '.$estagio['email_empresa'].'<br>
    </div>
    <div style="background-color:gainsboro; font-size:small; clear:both; border:solid 0.5px; padding: 1%;">
      <b>Representante Legal:</b> '.$estagio['representante_legal'].'<br>
      <b>Supervisor de Estágio:</b> '.$estagio['nome_supervisor'].'<br>
      <b>Registro Profissional:</b> '.$estagio['num_reg_prof'].'<br>
      <b>Orgão Emissor:</b> '.$estagio['orgao_emissor'].'<br>
      <b>Cargo:</b> '.$estagio['cargo'].'<br>
      <b>Formação Acadêmica:</b> '.$estagio['formacao'].'<br>
    </div>

    <div id="estagiario" style=" clear:both; padding:5px; border:solid 0.5px;">
      <strong><center>ESTAGIÁRIO</center></strong>
    </div>
    <div style="background-color:gainsboro; font-size:small; clear:both; border:solid 0.5px; padding: 1%;">
      <b>Nome:</b> '.$estagio['nome_aluno'].'<br>
    </div>
    <div style="font-size:small; clear:both; border:solid 0.5px; padding: 1%;">
      <b>Curso:</b> '.$estagio['nome_curso'].'<br>
      <b>Período:</b> '.$estagio['periodo'].'º '.$tipo.'<br>
      <b>RG:</b> '.$estagio['rg_aluno'].'<br>
      <b>CPF:</b> '.$estagio['cpf_aluno'].'<br>
      <b>Data de Nascimento:</b> '.$estagio['data_aluno'].'<br>
    </div>
    <div style="background-color:gainsboro; font-size:small; clear:both; border:solid 0.5px; padding: 1%;">
      <b>Endereço:</b> '.$endereco_aluno['rua'].', '.$endereco_aluno['numero'].', '.$endereco_aluno['bairro'].', CEP: '.$endereco_aluno['cep'].', '.$endereco_aluno['cidade'].', '.$endereco_aluno['estado'].'<br>
      <b>Telefone:</b> '.$estagio['telefone_aluno'].'<br>
    </div>
    <div style="font-size:small; clear:both; border:solid 0.5px; padding: 1%;">
      <b>E-mail:</b> '.$estagio['email_aluno'].'<br>
      <b>Portador de Deficiência: </b>'.$deficiencia.'<br>
      <b>Estágio Obrigatório: </b>'.$obrigatorio.'<br>
    </div>

    <div id="texto" style="padding:1%;">
      <p align="justify">As partes supracitadas resolvem celebrar o presente Termo de Compromisso de Estágio, para realização de Estágio Curricular, em conformidade com a Lei nº 11.788, de 25 de setembro de 2008 e das cláusulas e condições a seguir estipuladas.</p>

      <p align="justify"><strong>CLÁUSULA PRIMEIRA – DO OBJETO</strong></p>

      <p align="justify"><b>1.1</b>	Constitui objeto do presente Termo a concessão de estágio curricular, entendendo-se como tal, o ato educativo escolar supervisionado, desenvolvido no ambiente de trabalho, que visa preparar para a empregabilidade, para a vida cidadã e para o trabalho, por meio do exercício de atividades correlatas à sua pretendida formação profissional, em complementação ao conhecimento teórico adquirido na Instituição de Ensino.</p>

      <p align="justify"><strong>CLÁUSULA SEGUNDA – DA VIGÊNCIA</strong></p>

      <p align="justify"><b>2.1</b> O vínculo de estágio, objeto do presente Termo de Compromisso terá início em '.$estagio['data_inicio'].' e término em '.$estagio['data_fim'].', desde que mantido o vínculo do ESTAGIÁRIO com a Instituição de Ensino, nos termos da Lei 11.788/2008.</p>
      <p align="justify"><b>2.2</b> O presente Termo de Compromisso poderá ser prorrogado, mediante a celebração de Termo Aditivo, observado o limite máximo de 02 (dois) anos.</p>
      <p align="justify"><b>2.3</b> A vigência poderá ser maior que 02 (dois) anos apenas no caso de Estagiário Portador de Deficiência.</p>

      <p align="justify"><strong>CLÁUSULA TERCEIRA – DO HORÁRIO DA JORNADA DO ESTÁGIO</strong></p>

      <p align="justify"><b>3.1</b> O horário de estágio será das '.$estagio['horario_inicio'].' às '.$estagio['horario_fim'].', totalizando '.$estagio['carga_semanal'].' horas semanais.</p>
      <p align="justify"><b>3.2</b> As atividades de estágio não poderão ser superiores a 06 (seis) horas diárias e a 30 (trinta) horas semanais.</p>

      <p align="justify"><strong>CLÁUSULA QUARTA – DO DESENVOLVIMENTO DO ESTÁGIO</strong></p>

      <p align="justify"><b>4.1</b> Durante a realização do estágio, o ESTAGIÁRIO estará coberto pela apólice de seguro nº '.$estagio['apolice_seguro'].', da Seguradora '.$estagio['nome_seguradora'].' no valor de '.$estagio['valor_seguro'].'.</p>
      <p align="justify"><b>4.2</b> O estágio será desenvolvido com base no Plano de Atividades de Estágio elaborado conjuntamente entre o ESTAGIÁRIO, a INSTITUIÇÃO DE ENSINO e a UNIDADE CONCEDENTE, em anexo.</p>
      <p align="justify"><b>4.3</b> As atividades principais poderão ser ampliadas, reduzidas, alteradas ou substituídas somente com prévia e expressa anuência do ESTAGIÁRIO e do <b>IFBA</b>, devendo ser realizadas sempre dentro do contexto básico da profissão, do Projeto Pedagógico do Curso e com a concordância do Professor Orientador.</p>
      <p align="justify"><b>4.4</b> O horário de estágio será combinado de acordo com as conveniências mútuas, respeitadas as horas de aulas, de provas e de outros trabalhos didáticos. As atividades de estágio não poderão ser superiores a 06 (seis) horas diárias e a 30 (trinta) horas semanais.</p>
      <p align="justify"><b>4.5</b> Nos períodos de avaliações, a carga horária do estágio poderá ser reduzida à metade, para garantir o bom desempenho do estudante, desde que o <b>IFBA</b> comunique a CONCEDENTE as datas de realização de tais avaliações.</p>
      <p align="justify"><b>4.6</b> O ESTAGIÁRIO não terá vínculo empregatício de qualquer natureza com a CONCEDENTE, conforme os termos do artigo 3º da Lei 11.788/2008, inclusive para fins de Legislação do Fundo de Garantia por Tempo de Serviço e Seguridade Social.</p>
      <p align="justify"><b>4.7</b> O prazo máximo de realização de estágio é de 02 (dois) anos, exceto para os casos de estagiário portador de deficiência.</p>

      <p align="justify"><strong>CLÁUSULA QUINTA – DAS OBRIGAÇÕES DAS PARTES</strong></p>

      <p align="justify"><b>5.1</b> Compete à <b>INSTITUIÇÃO DE ENSINO</b> – Instituto Federal de Educação, Ciência e Tecnologia da Bahia/
      IFBA:</p>
      <p align="justify"><b>5.1.1</b> Avaliar as instalações da CONCEDENTE de Estágio e sua adequação à formação cultural e profissional do ESTAGIÁRIO.</p>
      <p align="justify"><b>5.1.2</b> Indicar Professor Orientador, da área a ser desenvolvida no estágio, como responsável pelo acompanhamento e avaliação das atividades do ESTAGIÁRIO.</p>
      <p align="justify"><b>5.1.3</b> Exigir do ESTAGIÁRIO a apresentação periódica, mensal, de Relatório das Atividades.</p>
      <p align="justify"><b>5.1.4</b> Receber, arquivar os Relatórios das Atividades.</p>
      <p align="justify"><b>5.1.5</b> Zelar pelo cumprimento do Termo de Compromisso de Estágio, reorientando o ESTAGIÁRIO para outro local em caso de descumprimento de suas normas;</p>
      <p align="justify"><b>5.1.6</b> Comunicar à CONCEDENTE de Estágio, as datas de realização das avaliações escolares ou acadêmicas.</p>
      <p align="justify"><b>5.2</b> Compete à <b>UNIDADE CONCEDENTE DE ESTÁGIO:</b></p>
      <p align="justify"><b>5.2.1</b> Ofertar instalações que tenham condições de proporcionar aos ESTAGIÁRIOS as atividades de aprendizagem relacionadas ao seu curso de formação.</p>
      <p align="justify"><b>5.2.2</b> Designar um profissional com formação ou experiência profissional na área de conhecimento desenvolvida no curso do ESTAGIÁRIO, orientar e supervisionar as atividades do ESTAGIÁRIO.</p>
      <p align="justify"><b>5.2.3</b> Por ocasião do desligamento do ESTAGIÁRIO, entregar termo de realização do estágio com indicação resumida das atividades desenvolvidas, dos períodos e da avaliação de desempenho.</p>
      <p align="justify"><b>5.2.4</b> Manter documentos que comprovem a relação de estágio à disposição da fiscalização.</p>
      <p align="justify"><b>5.2.5</b> Zelar pela aprendizagem do ESTAGIÁRIO, em conformidade com o currículo de seu curso de formação.</p>
      <p align="justify"><b>5.2.6</b> Fornecer à Instituição de Ensino todas as informações necessárias à avaliação e ao acompanhamento do estágio quando solicitada.</p>
      <p align="justify"><b>5.2.7</b> Efetuar pagamento de bolsa-auxílio no valor de '.$estagio['bolsa_auxilio'].' diretamente ao ESTAGIÁRIO, quando prevista.</p>
      <p align="justify"><b>5.2.8</b> Efetuar a contratação de seguro contra acidentes pessoais em favor do ESTAGIÁRIO, durante o período do estágio, sem qualquer ônus para este ou para o <b>IFBA</b>.</p>
      <p align="justify"><b>5.2.9</b> Efetuar pagamento de auxílio transporte no valor de '.$estagio['auxilio_transporte'].' diretamente ao ESTAGIÁRIO, quando previsto.</p>
      <p align="justify"><b>5.2.10</b> Subsidiar o <b>IFBA</b> com informações que propiciem aprimoramento do sistema acadêmico e do próprio estágio.</p>
      <p align="justify"><b>5.2.11</b> Reduzir a carga horária do estágio em, no mínimo, a metade daquela estabelecida na <b><i>cláusula 3.1</i></b>, nos períodos de avaliações previamente informados pelo <b>IFBA</b>, quando solicitado pelo Estagiário.</p>
      <p align="justify"><b>5.2.12</b> Conceder ao ESTAGIÁRIO recesso de 30(trinta) dias, preferencialmente, no período de férias escolares, sempre que o estágio tenha duração igual ou superior a 1 (um) ano, devendo ser remunerado conforme o valor atualizado da bolsa.</p>
      <p align="justify"><b>5.2.13</b> Avaliar e validar o Relatório de Atividades mensal desenvolvido no âmbito da CONCEDENTE.</p>
      <p align="justify"><b>5.3 COMPETE AO ESTAGIÁRIO:</b></p>
      <p align="justify"><b>5.3.1</b> Cumprir com zelo e responsabilidade as tarefas que lhe forem submetidas.</p>
      <p align="justify"><b>5.3.2</b> Cumprir integralmente as horas previstas para o seu estágio, conforme especificado em cláusula própria.</p>
      <p align="justify"><b>5.3.3</b> Apresentar mensalmente Relatório de Atividades de Estágio, devidamente conferido pelo Supervisor de Estágio indicado pela CONCEDENTE, e, após visto, providenciar a entrega do Relatório de Atividades de Estágio ao Professor Orientador do <b>IFBA</b>.</p>
      <p align="justify"><b>5.3.4</b> Manter atualizados os seus dados cadastrais.</p>
      <p align="justify"><b>5.3.5</b> Informar, por escrito, qualquer fato que interrompa, suspenda ou cancele sua matrícula no <b>IFBA</b>, bem como fornecer à CONCEDENTE atestado de matrícula semestralmente.</p>
      <p align="justify"><b>5.3.6</b> Informar ao Professor Orientador do IFBA, descumprimento do estabelecido no Plano de Atividades de Estágio ou qualquer outra cláusula do presente Termo de Compromisso de Estágio pela CONCEDENTE.</p>
      <p align="justify"><b>5.3.7</b> Acatar as normas internas da CONCEDENTE, bem como orientações e recomendações efetuadas por seu Supervisor.</p>
      <p align="justify"><b>5.3.8</b> Assinar, ao término do estágio, o Termo de Desligamento do Estágio, a ser fornecido pela CONCEDENTE de Estágio.</p>

      <p align="justify"><strong>CLÁUSULA SEXTA – DA RESCISÃO</strong></p>

      <p align="justify"><b>6.1</b> O presente Termo de Compromisso de Estágio extinguir-se-á automaticamente:</p>
      <p align="justify">A. Pela conclusão, trancamento, desligamento e abandono do curso;</p>
      <p align="justify">B. Não cumprimento dos termos de compromisso;</p>
      <p align="justify">C. Pedido de qualquer uma das partes, a qualquer tempo;</p>
      <p align="justify">D. Automaticamente, ao término do estágio;</p>
      <p align="justify">E. Quando atingido o período máximo permitido pela Lei nº 11.788/08 para realização de estágio.</p>

      <p align="justify"><strong>CLÁUSULA SÉTIMA – DO FORO</strong></p>

      <p align="justify"><b>7.1</b> Fica eleito o Foro da Comarca de Irecê com renúncia de qualquer outro por mais privilegiado que seja, para dirimir quaisquer dúvidas que se originarem deste Termo de Compromisso e que não possam ser solucionadas amigavelmente.</p>
      <p align="justify"><b>7.2</b> E por estarem de acordo com os termos do presente instrumento, as partes o assinam em 03 (três) vias, na presença de duas testemunhas, para todos os fins e efeitos de direito.</p>

      <br>
      <br>
      <br>
      <br>

      <div id="data_assinatura" style=" clear:both; float:right">
          <strong>Irecê-BA, ______ de ___________________de ___________.</strong>
      </div>

      <div id="concedente_assinatura" style=" clear:both; float:left; padding-top: 10%; text-align: center">
          <strong>____________________________<br>
          Unidade Concedente<br></strong>
          (Assinatura e carimbo)
      </div>

      <div id="estagiario_assinatura" style=" clear:both; float:right; padding-top: 10%; text-align: center">
          <strong>____________________________<br>
          Estagiário (a)<br></strong>
      </div>

      <div id="coordenacao_assinatura" style=" clear:both; padding-top: 10%; text-align: center">
          <strong>______________________________________________________________<br>
          Coordenação de Estágios<br></strong>
          (Assinatura e carimbo)
      </div>

      <div id="instituto_assinatura" style=" clear:both; padding-top: 10%; text-align: center">
          <strong>______________________________________________________________<br>
          Instituto Federal de Educação, Ciência e Tecnologia da Bahia<br></strong>
          (Assinatura e carimbo)
      </div>

      <div id="testemunha_assinatura1" style=" clear:both; float:left; padding-top: 10%;">
          <strong>____________________________<br>
          Testemunha<br></strong>
          Nome:<br>
          RG:<br>
          CPF:
      </div>

      <div id="testemunha_assinatura2" style=" clear:both; float:right; padding-top: 10%; padding-right: 20%;">
          <strong>____________________________<br>
          Testemunha<br></strong>
          Nome:<br>
          RG:<br>
          CPF:
      </div>
    </div>

  </div>
</html>
');


$TERMO_COMPROMISSO->render();

$TERMO_COMPROMISSO->stream(
		'Termo - '.$estagio['nome_aluno'].' ('.$estagio['matricula'].').pdf',
		array(
				"Attachment" => false
		)
);
?>
