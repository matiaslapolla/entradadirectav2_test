<?php @session_start();
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
error_log("entro aca index.php 4" . PHP_EOL);
include('function.php');
?>
<!DOCTYPE html>
 <html lang="es-ES">
 <head>
 <meta charset="UTF-8" />
 <title>Entrada Directa</title>
 <meta name="description" content="">
 <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet" type="text/css">
 <link rel="shortcut icon" href="<?php echo __HOST__; ?>/images/favicon.png">
 <link rel="stylesheet" type="text/css" href="<?php echo __HOST__; ?>/main.css?v=9"/>
<script type="text/javascript" src="main.js?v=3"></script>
<meta name="viewport" content="width=device-width,initial-scale=1">
 </head>
<body style="backgroundColor:#fafafa">
<?php

$usuario="";
$clave="";
$login="";
if(isset($_POST['usuario'])){
  $usuario=trim($_POST['usuario']);
  $clave=trim($_POST['clave']);
  $login=login($usuario,$clave);
  if($login > 0){
    $_SESSION['rol']=1;
    $_SESSION['usuario']=$usuario;
    $_SESSION['IDUsuario']=$login;
  }
  if($login == 0)
    $seccion='login.php';
}
?>
<?php
if(isset($_GET['logout']))
  session_unset();
?>
<?php
include('menu.php');
?>
<div style='margin-top:160px;'></div>
<div style='width:100%;text-align:center;'>
<div style='padding:5px;margin:auto;max-width:1223px;'>
<?php
include($seccion);
?>
<div style='clear:both;'></div>
</div>
</div>
</body>
