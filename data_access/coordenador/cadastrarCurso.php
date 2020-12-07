<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $nome_curso = filter_input(INPUT_POST, 'nome_curso', FILTER_SANITIZE_STRING);
    $tipo_curso = filter_input(INPUT_POST, 'tipo_curso', FILTER_SANITIZE_STRING);

    $consulta = "select * from curso where nome like '$nome_curso' and tipo like '$tipo_curso'";

    $result = $mysqli->query($consulta) or die($mysqli->error);

    if($result->num_rows == 0){
      $consulta = "insert into curso (nome,tipo) values ('$nome_curso','$tipo_curso')";
      $result = $mysqli->query($consulta) or die($mysqli->error);

      if(mysqli_insert_id($mysqli)){
          $_SESSION['sucesso_cadastro']="Cadastro efetuado com sucesso.";
      }else{
          $_SESSION['erro_cadastro']="Não foi possível efetuar o cadastro.";
      }
    }else{
      $_SESSION['erro_cadastro']="O curso já existe.";
    }

    header('Location: ../../view/menu.php?Pagina=cadastrarCurso');
?>
