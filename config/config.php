<?php

  	function conexion() {
    	$servidor = "localhost";
  		$usuario = "mglopez";
  		$clave = "MarLop+2048";
  		$base = "necoticketdb";
  		$conexion = new mysqli($servidor,$usuario,$clave,$base);
  		mysqli_query($conexion,"SET NAMES 'utf8'");
  		return $conexion;
	} // function conexion()
	
  $conexion=conexion();

  define('__HOST__','https://www.entradadirecta.com.ar');

?>
