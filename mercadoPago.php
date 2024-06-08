<?php

use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Payment\Payment;

require_once('function.php');

$IDEvento = $_GET['IDEvento'];
$dni = $_GET['dni'];
$sector = $_GET['sector'];
$cantidad = $_GET['cantidad'];
$usuario = $_GET['usuario'];

$sQuery="SELECT Fecha, Hora, Obra, Teatro 
         FROM vewEventos 
         WHERE IDEvento = '$IDEvento'";
$res = $conexion->query($sQuery);

# url model http://localhost:8003/mercadoPago.php?IDEvento=61&dni=12345654&sector=3&cantidad=1&usuario=7

$ticketData = [];

while($r = $res->fetch_object()){
	$ticketData['obra'] = $r->Obra;
	$ticketData['fecha'] = $r->Fecha;
	$ticketData['hora'] = $r->Hora;
	$ticketData['teatro'] = $r->Teatro;
}

$sQuery="SELECT PrecioPOS, Sector, Sala 
         FROM vewSectoresEvento
         WHERE IDEvento = '$IDEvento' 
         AND IDSector = '$sector'";
$_res = $conexion->query($sQuery);

$posData = [];

while($r = $_res->fetch_object()){
	$posData['precio'] = $r->PrecioPOS;
	$posData['sector'] = $r->Sector;
	$posData['sala'] = $r->Sala;
}

error_log("entro aca mercadoPago.php 43" . PHP_EOL);

// function processPayment() {
// 	 try {

		
//         $client = new PaymentClient();

// 				$payment = new Payment();

// 				$itemPaid = [
// 					'id' => $IDEvento,
// 					'title' => $ticketData['obra'],
// 					'quantity' => $cantidad,
// 					'unit_price' => $posData['precio'] * $cantidad,
// 					'currency_id' => 'ARS'
// 				];

// 				$payment->items = [$itemPaid];

//         validate_payment_result($payment);

//         $response_fields = array(
//             'id' => $payment->id,
//             'status' => $payment->status,
//             'detail' => $payment->status_detail
//         );

//         $response_body = json_encode($response_fields);
//         $response->getBody()->write($response_body);
				
//         return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
//     } catch (Exception $exception) {
//         $response_fields = array('error_message' => $exception->getMessage());

//         $response_body = json_encode($response_fields);
//         $response->getBody()->write($response_body);

//         return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
//     }
// }

?>

<div style='margin-top:160px;'></div>
<div style='width:100%;text-align:center;'>
	<div style='padding:5px;margin:auto;max-width:1223px;'>
	<h1
		style='
			text-align:center;
			font-size:30px;
			font-weight:400;
			margin-bottom:20px;
			font-family:sans-serif;
			padding:0;
			'
	>Resumen de compra</h1>
	<div style="display:flex; justify-content:center">
		<div style='
				text-align:center;
				width:35%;
				margin:0;
				padding:0;
				background-color:#f9f9f9;
				border:1px solid #ddd;
				border-radius:5px;
			'>
			<div style='
					text-align:left;
					padding:10px;
					border-bottom:1px solid #ddd;
				'>
				<img src='images/planetaEntradaT.png' style='margin:auto;width:130px;opacity:0.5;'>
				<div style='font-size:20px;font-weight:400; font-family:sans-serif;'>Obra: <?php echo $ticketData['obra']; ?></div>
				<div style='font-size:20px;font-weight:400; font-family:sans-serif'>Fecha: <?php echo $ticketData['fecha']; ?></div>
				<div style='font-size:20px;font-weight:400; font-family:sans-serif'>Hora: <?php echo $ticketData['hora']; ?></div>
				<div style='font-size:20px;font-weight:400; font-family:sans-serif'>Teatro: <?php echo $ticketData['teatro']; ?></div>
				<div style='font-size:20px;font-weight:400; font-family:sans-serif'>Sector: <?php echo $posData['sector']; ?></div>
				<div style='font-size:20px;font-weight:400; font-family:sans-serif'>Sala: <?php echo $posData['sala']; ?></div>
				<div style='font-size:20px;font-weight:400; font-family:sans-serif'>Precio unitario: <?php echo $posData['precio']; ?></div>
				<div style='font-size:20px;font-weight:400; font-family:sans-serif'>Cantidad: <?php echo $cantidad; ?></div>
				<div style='font-size:20px;font-weight:400; font-family:sans-serif'>Total: <?php echo $posData['precio'] * $cantidad; ?></div>
			</div>
			<div style='text-align:center;'>
				<form action="mercadoPago_pagar.php" method="POST">
					<input type="hidden" name="IDEvento" value="<?php echo $IDEvento; ?>">
					<input type="hidden" name="dni" value="<?php echo $dni; ?>">
					<input type="hidden" name="sector" value="<?php echo $sector; ?>">
					<input type="hidden" name="cantidad" value="<?php echo $cantidad; ?>">
					<input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
					<input type="hidden" name="obra" value="<?php echo $ticketData['obra']; ?>">
					<input type="hidden" name="fecha" value="<?php echo $ticketData['fecha']; ?>">
					<input type="hidden" name="hora" value="<?php echo $ticketData['hora']; ?>">
					<input type="hidden" name="teatro" value="<?php echo $ticketData['teatro']; ?>">
					<input type="hidden" name="sector" value="<?php echo $posData['sector']; ?>">
					<input type="hidden" name="sala" value="<?php echo $posData['sala']; ?>">
					<input type="hidden" name="precio" value="<?php echo $posData['precio']; ?>">
					<input type="hidden" name="cantidad" value="<?php echo $cantidad; ?>">
					<input type="hidden" name="total" value="<?php echo $posData['precio'] * $cantidad; ?>">
					<button style="margin-top: 16px" type="submit">Pagar</button>
				</form>
			</div>
</div>

</div>
</div>



