<?php

include('function.php');
$IDEvento=$_POST['IDEvento'];
$dni=$_POST['dni'];
$cantidad=$_POST['cantidad'];
$sector=$_POST['sector'];
$usuario=$_POST['usuario'];

$tickets="";

// Aquí el ciclo por cada ticket de la cantidad de tickets que se desea comprar
	// for($i=0; $i < $cantidad; $i++) {
	//	usleep(300);  <- No sé bien para qué era
		$sQuery="SELECT Vendidas, PrecioPOS FROM vewSectoresEvento WHERE IDEvento = '$IDEvento' AND IDSector = '$sector'";
		$res = $conexion->query($sQuery);
		if($r = $res->fetch_object()){
  			$butaca=$r->Vendidas+1; // <-- Vendidas más 1 es el número de butaca 
  			$precio=$r->PrecioPOS;
		}
		else {
			$butaca=-1;
		}

		//echo "butaca: ".$butaca."<br>";



		//$sQuery="SET @bEstado = false;";
		//$sQuery.="SET @sMensaje = '--------------------------------------------------------------------------------';";
		//$sQuery.="SET @iButaca = 0;";

		//$stmt = $conexion->prepare($sQuery);

		$sQuery="CALL spVenderButaca ($IDEvento, $sector, $butaca, $precio, '$dni', $usuario, $cantidad, @bEstado, @sMensaje, @iButaca);";

		// Preparar la consulta
		$stmt = $conexion->prepare($sQuery);

		// Ejecutar la consulta
		$stmt->execute();

		// Obtener el valor del parámetro de salida
		$result = $conexion->query('SELECT @bEstado, @sMensaje, @iButaca;');
		$row = $result->fetch_assoc();
		$estado = $row['@bEstado'];
		$mensaje = $row['@sMensaje'];
		$IDbutaca = $row['@iButaca'];

  		if($estado != 1){
    		$butaca=$butaca-1;
  		}else{
  			$tickets.=$cantidad."-";
  			$tickets.=$IDbutaca."-";
  			$butaca=$butaca+$cantidad-1;
  			//$tickets=$cantidad; <- esto lo había puesto yo
  		}

	//} // for ()

// LOG
/*$ruta_archivo="log/entradas.log";
$fp = fopen($ruta_archivo, "a+");
fwrite($fp,date("Y-m-d H:i:s")." ");
fwrite($fp,$sQuery." ");
fwrite($fp,"mensaje: ".$mensaje." ");
fwrite($fp,"butaca: ".$butaca." ");
fwrite($fp,"mensaje: ".$tickets."\n"); */



	echo $mensaje.";".$butaca.";".$tickets;


?>
