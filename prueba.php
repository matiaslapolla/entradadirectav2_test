<?php

  function conexion(){
    $servidor = "localhost";
  	$usuario = "mglopez";
  	$clave = "MarLop+2048";
  	$base = "necoticketdb";
  	$conexion = new mysqli($servidor,$usuario,$clave,$base);
  	mysqli_query($conexion,"SET NAMES 'utf8'");
  	return $conexion;
	}
  $conexion=conexion();

$sQuery="SET @bEstado = false;SET @sMensaje = '--------------------------------------------------------------------------------';SET @iButaca = 0;
SELECT @bEstado as estado, @sMensaje as mensaje, @iButaca as butaca (CALL spVenderButaca (25, 1, 1, 13680.00, '', 1, @bEstado, @sMensaje, @iButaca));";

echo $sQuery;

$res = $conexion->multi_query($sQuery);
while($r = $res->fetch_object()){
  $estado=$r->estado;
  $mensaje=$r->mensaje;
}
echo $estado;
echo $mensaje;
?>

