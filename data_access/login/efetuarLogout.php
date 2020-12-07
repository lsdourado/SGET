<?php
    @session_start();

    if($_SESSION['tipo_login'] == "supervisor"){
      session_destroy();
      unset($_SESSION);

      header('Location: ../../index.php');
    }else{
      session_destroy();
      unset($_SESSION);

      header('Location: ../index.php');
    }

    exit;
?>
