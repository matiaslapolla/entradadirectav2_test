<?php

require_once('function.php');


$IDEvento=$_GET['IDEvento'];
$IDsector=$_GET['sector'];
$tickets=$_GET['tickets'];

$sQuery="SELECT Fecha, Hora, Obra, Teatro 
         FROM vewEventos 
         WHERE IDEvento = '$IDEvento'";
$res = $conexion->query($sQuery);
while($r = $res->fetch_object()){
  $obra=$r->Obra;
  $fecha=$r->Fecha;
  $hora=$r->Hora;
  $teatro=$r->Teatro;
}

$sQuery="SELECT PrecioPOS, Sector, Sala 
         FROM vewSectoresEvento
         WHERE IDEvento = '$IDEvento' 
         AND IDSector = '$IDsector'";
$res = $conexion->query($sQuery);
while($r = $res->fetch_object()){
  $precio=$r->PrecioPOS;
  $sector=$r->Sector;
  $sala=$r->Sala;
}

$arrayTickets=explode('-',$tickets);
$cantidad=count($arrayTickets)-1;

$fechaTicket=formatFechaHoraDetalle($fecha." ".$hora);
$precio=$precio*$cantidad;
$precio=formatPrecio($precio);

require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;


$numTicket=formatNumTicket($arrayTickets[$cantidad-1]);


require_once('phpqrcode/qrlib.php');

$filename='tmp/codigoqr.png';

$tamanio='5';
$level='M';
$padding=1;
$contenido=$obra." - ".$fechaTicket." - ".$numTicket;

error_log(json_encode([
	'filename' => $filename,
	'contenido' => $contenido,
	'level' => $level,
	'tamanio' => $tamanio,
	'padding' => $padding
]));

// TODO: comentar/descomentar esto, genera el QR preguntar si esto es necesario, crashea la app en macOs
QRcode::png($contenido,$filename,$level,$tamanio,$padding);



// TODO: preguntar si esto es necesario, practicamente lo mismo que el de abajo
// $html="<div style='text-align:center;width:30%;margin:0;padding:0;'>";
// $html.="<div><img src='".__HOST__."/images/planetaEntradaT.png' style='margin:auto;width:130px;opacity:0.5;'></div>";
// $html.="<div style='font-size:30px;margin-top:5px;font-family:Arial;'><b>".$obra."</b></div>";
// $html.="<div style='font-size:20px;margin-top:10px;color:#555;font-family:Arial;'>Teatro ".$teatro."</div>";
// $html.="<div style='font-size:13px;margin-top:5px;color:#555;font-family:Arial;'>Sala ".$sala." - Sector  ".$sector."</div>";
// $html.="<div style='font-size:19px;margin-top:8px;font-family:Arial;'>".$fechaTicket."</div>";
// $html.="<div style='font-size:17px;margin-top:12px;font-family:Arial;'>Cantidad: ".$cantidad."</div>";
// $html.="<div style='font-size:14px;margin-top:8px;color:#555;font-family:Arial;'>Cod. ".$numTicket."</div>";
// $html.="<div style='font-size:16px;margin-top:8px;font-family:Arial;'>Total valor: ".$precio."</div>";
// $html.="<div style='margin-top:1px;'>&nbsp;</div>";
// $html.="<div><img src='".__HOST__."/tmp/codigoqr.png' style='margin:auto;'></div>";
// $html.="</div>";


	$contenido_pdf='
	<div style="text-align:center;width:30%;margin:0;padding:0;">
		<div><img src="images/planetaEntradaT.png" style="margin:auto;width:130px;opacity:0.5;"></div>
		<div style="font-size:30px;margin-top:5px;font-family:Arial;"><b><?php echo $obra; ?></b></div>
		<div style="font-size:20px;margin-top:10px;color:#555;font-family:Arial;">Teatro <?php echo $teatro; ?></div>
		<div style="font-size:13px;margin-top:5px;color:#555;font-family:Arial;">Sala <?php echo $sala; ?> - Sector  <?php echo $sector; ?></div>
		<div style="font-size:19px;margin-top:8px;font-family:Arial;"><?php echo $fechaTicket; ?></div>
		<div style="font-size:17px;margin-top:12px;font-family:Arial;">Cantidad: <?php echo $cantidad; ?></div>
		<div style="font-size:14px;margin-top:8px;color:#555;font-family:Arial;">Cod. <?php echo $numTicket; ?></div>
		<div style="font-size:16px;margin-top:8px;font-family:Arial;">Total valor: <?php echo $precio; ?></div>
		<div style="margin-top:1px;">&nbsp;</div>
		<div><img src="tmp/codigoqr.png" style="margin:auto;"></div>
	</div>
';

	$dompdf = new Dompdf();

	$options=$dompdf->getOptions();
	$options->set(array('isRemoteEnabled' => true));
	$dompdf->setOptions($options); 

	$dompdf->loadHtml($contenido_pdf);

	$dompdf->render();
	$dompdf->setPaper("leter");
	$dompdf->setPaper("A7","landscape");
	$dompdf->stream($numTicket.".pdf",array("Attachment" => true ));

	


// LOG
/*$ruta_archivo="log/entradas.log";
$fp = fopen($ruta_archivo, "a+");
fwrite($fp,date("Y-m-d H:i:s")." ");
fwrite($fp,$obra." ".$teatro." ".$sector." ".$fechaTicket." ".$cantidad." ".$numTicket." ".$precio."\n");
 */



// TODO: Aca se el PDF preguntar si esto es necesario o avanzar con el boton imprimir
// $dompdf = new Dompdf();

// $options=$dompdf->getOptions();
// $options->set(array('isRemoteEnabled' => true));
// $dompdf->setOptions($options); 

// $dompdf->loadHtml($html);

// $dompdf->render();
// $dompdf->setPaper("leter");
// $dompdf->setPaper("A7","landscape");
// $dompdf->stream($numTicket.".pdf",array("Attachment" => true ));


?>

<!DOCTYPE html>
<html>
<head>
	<title>Generar Ticket</title>
</head>
<body>
	<div style="text-align:center;width:30%;margin:0;padding:0;">
		<div><img src="images/planetaEntradaT.png" style="margin:auto;width:130px;opacity:0.5;"></div>
		<div style="font-size:30px;margin-top:5px;font-family:Arial;"><b><?php echo $obra; ?></b></div>
		<div style="font-size:20px;margin-top:10px;color:#555;font-family:Arial;">Teatro <?php echo $teatro; ?></div>
		<div style="font-size:13px;margin-top:5px;color:#555;font-family:Arial;">Sala <?php echo $sala; ?> - Sector  <?php echo $sector; ?></div>
		<div style="font-size:19px;margin-top:8px;font-family:Arial;"><?php echo $fechaTicket; ?></div>
		<div style="font-size:17px;margin-top:12px;font-family:Arial;">Cantidad: <?php echo $cantidad; ?></div>
		<div style="font-size:14px;margin-top:8px;color:#555;font-family:Arial;">Cod. <?php echo $numTicket; ?></div>
		<div style="font-size:16px;margin-top:8px;font-family:Arial;">Total valor: <?php echo $precio; ?></div>
		<div style="margin-top:1px;">&nbsp;</div>
		<div><img src="tmp/codigoqr.png" style="margin:auto;"></div>
	</div>
