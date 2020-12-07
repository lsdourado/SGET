<?php
    @session_start();
    include_once("../../connection/ConnectionFactory.php");

    $email = $_POST['emailLembrarSenha'];
    $mail_sent = false;

    //RECUPERAR COORDENADOR
    $consulta = "select * from acesso where login = '$email'";
    $_SESSION['result_login'] = $mysqli->query($consulta) or die($mysqli->error);

    if($_SESSION['result_login']->num_rows > 0){
      $id_login = mysqli_fetch_assoc($_SESSION['result_login'])['id'];
      $novaSenha = substr(md5(time()), 8, 20);
      $nscriptografada = md5(md5($novaSenha));

      if(mail($email,"Recuperação de senha - Coord. Estágio","Sua nova senha é: ".$novaSenha)){
        $consulta = "update acesso set senha='$novaSenha' where id='$id_login'";
        $mysqli->query($consulta) or die($mysqli->error);

        $mail_sent=true;
      }
    }


    if($mail_sent==false){
      //RECUPERAR ALUNO
      $consulta = "select *, acesso.id as id_acesso from acesso inner join aluno where
                  aluno.id_acesso = acesso.id and aluno.email='$email'";
      $_SESSION['result_login'] = $mysqli->query($consulta) or die($mysqli->error);

      if($_SESSION['result_login']->num_rows > 0){
        $id_login = mysqli_fetch_assoc($_SESSION['result_login'])['id_acesso'];
        $novaSenha = substr(md5(time()), 8, 20);
        $nscriptografada = md5(md5($novaSenha));

        if(mail($email,"Recuperação de senha - Coord. Estágio","Sua nova senha é: ".$novaSenha)){
          $consulta = "update acesso set senha='$novaSenha' where id='$id_login'";
          $mysqli->query($consulta) or die($mysqli->error);

          $mail_sent=true;
        }
      }
    }



    if($mail_sent==false){
      //RECUPERAR PROFESSOR
      $consulta = "select *, acesso.id as id_acesso from acesso inner join professor where
                  professor.id_acesso = acesso.id and professor.email='$email'";
      $_SESSION['result_login'] = $mysqli->query($consulta) or die($mysqli->error);

      if($_SESSION['result_login']->num_rows > 0){
        $id_login = mysqli_fetch_assoc($_SESSION['result_login'])['id_acesso'];
        $novaSenha = substr(md5(time()), 8, 20);
        $nscriptografada = md5(md5($novaSenha));

        if(mail($email,"Recuperação de senha - Coord. Estágio","Sua nova senha é: ".$novaSenha)){
          $consulta = "update acesso set senha='$novaSenha' where id='$id_login'";
          $mysqli->query($consulta) or die($mysqli->error);

          $mail_sent=true;
        }
      }
    }



    if($mail_sent==false){
      //RECUPERAR SUPERVISOR
      $consulta = "select * from supervisor where email='$email'";
      $_SESSION['result_login'] = $mysqli->query($consulta) or die($mysqli->error);

      if($_SESSION['result_login']->num_rows > 0){
        $id_supervisor = mysqli_fetch_assoc($_SESSION['result_login'])['id'];
        $novaSenha = substr(md5(time()), 8, 20);
        $nscriptografada = md5(md5($novaSenha));

        if(mail($email,"Recuperação de senha - Coord. Estágio","Sua nova senha é: ".$novaSenha)){
          $consulta = "update supervisor set byPass_token='$novaSenha' where id='$id_supervisor'";
          $mysqli->query($consulta) or die($mysqli->error);

          $mail_sent=true;
        }
      }
    }


    if($mail_sent==true){
      $_SESSION['recuperado']=$mail_sent;
    }else{
      $_SESSION['falha_recuperar']=true;
    }

    header('Location:../../');
?>
