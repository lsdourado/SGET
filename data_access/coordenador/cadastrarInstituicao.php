<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $nome_instituicao = filter_input(INPUT_POST, 'nome_instituicao', FILTER_SANITIZE_STRING);
    $cnpj_instituicao = filter_input(INPUT_POST, 'cnpj_instituicao', FILTER_SANITIZE_STRING);
    $telefone_instituicao = filter_input(INPUT_POST, 'telefone_instituicao', FILTER_SANITIZE_STRING);
    $diretor_instituicao = filter_input(INPUT_POST, 'diretor_instituicao', FILTER_SANITIZE_STRING);
    $portaria_instituicao = filter_input(INPUT_POST, 'portaria_instituicao', FILTER_SANITIZE_STRING);
    $cidade_endereco = filter_input(INPUT_POST, 'cidade_endereco', FILTER_SANITIZE_STRING);
    $rua_endereco = filter_input(INPUT_POST, 'rua_endereco', FILTER_SANITIZE_STRING);
    $bairro_endereco = filter_input(INPUT_POST, 'bairro_endereco', FILTER_SANITIZE_STRING);
    $numero_endereco = filter_input(INPUT_POST, 'numero_endereco', FILTER_SANITIZE_STRING);
    $estado_endereco = filter_input(INPUT_POST, 'estado_endereco', FILTER_SANITIZE_STRING);
    $cep_endereco = filter_input(INPUT_POST, 'cep_endereco', FILTER_SANITIZE_STRING);

    $consulta = "insert into endereco (cidade,rua,bairro,numero,estado,cep) values ('$cidade_endereco','$rua_endereco','$bairro_endereco','$numero_endereco','$estado_endereco','$cep_endereco')";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    $consulta = "insert into instituicao (nome,cnpj,telefone,diretor,portaria, id_endereco) values ('$nome_instituicao','$cnpj_instituicao','$telefone_instituicao','$diretor_instituicao','$portaria_instituicao', (select LAST_INSERT_ID()))";
    $result = $mysqli->query($consulta) or die($mysqli->error);

    if(mysqli_insert_id($mysqli)){
        $_SESSION['sucesso_cadastro']="Cadastro efetuado com sucesso.";
    }else{
        $_SESSION['erro_cadastro']="Não foi possível efetuar o cadastro.";
    }

    header('Location: ../../view/menu.php?Pagina=instituicao');
?>
