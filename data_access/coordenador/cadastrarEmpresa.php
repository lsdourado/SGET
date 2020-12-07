<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $razao_social = filter_input(INPUT_POST, 'razao_social', FILTER_SANITIZE_STRING);
    $nome_fantasia = filter_input(INPUT_POST, 'nome_fantasia', FILTER_SANITIZE_STRING);
    $tipo_empregador = filter_input(INPUT_POST, 'tipo_empregador', FILTER_SANITIZE_STRING);
    $cnpj_empresa = filter_input(INPUT_POST, 'cnpj_empresa', FILTER_SANITIZE_STRING);
    $representante_legal = filter_input(INPUT_POST, 'representante_legal', FILTER_SANITIZE_STRING);
    $telefone_empresa = filter_input(INPUT_POST, 'telefone_empresa', FILTER_SANITIZE_STRING);
    $email_empresa = filter_input(INPUT_POST, 'email_empresa', FILTER_SANITIZE_STRING);
    $cidade_empresa = filter_input(INPUT_POST, 'cidade_empresa', FILTER_SANITIZE_STRING);
    $rua_empresa = filter_input(INPUT_POST, 'rua_empresa', FILTER_SANITIZE_STRING);
    $bairro_empresa = filter_input(INPUT_POST, 'bairro_empresa', FILTER_SANITIZE_STRING);
    $numero_endereco_empresa = filter_input(INPUT_POST, 'numero_endereco_empresa', FILTER_SANITIZE_STRING);
    $estado_empresa = filter_input(INPUT_POST, 'estado_empresa', FILTER_SANITIZE_STRING);
    $cep_empresa = filter_input(INPUT_POST, 'cep_empresa', FILTER_SANITIZE_STRING);

    $consulta = "select * from empresa where cnpj like '$cnpj_empresa'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    if($result->num_rows == 0){
      $consulta = "INSERT INTO endereco (cidade,rua,bairro,numero,estado,cep) VALUES ('$cidade_empresa','$rua_empresa','$bairro_empresa','$numero_endereco_empresa','$estado_empresa','$cep_empresa')";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      $consulta = "INSERT INTO empresa (razao_social,nome_fantasia,tipo_empregador,cnpj,representante_legal,telefone,email,id_endereco) VALUES ('$razao_social','$nome_fantasia','$tipo_empregador','$cnpj_empresa','$representante_legal','$telefone_empresa','$email_empresa',(SELECT LAST_INSERT_ID()))";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      if(mysqli_insert_id($mysqli)){
          $_SESSION['sucesso_cadastro']="Cadastro efetuado com sucesso.";
      }else{
          $_SESSION['erro_cadastro']="Não foi possível efetuar o cadastro.";
      }
    }else{
      $_SESSION['erro_cadastro']="A empresa já existe.";
    }

    header('Location: ../../view/menu.php?Pagina=cadastrarEmpresa');
?>
