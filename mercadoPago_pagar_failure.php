<?php
// https://5828-190-19-173-44.ngrok-free.app/mercadoPago_pagar_failure.php?

// collection_id=1318582892&
// collection_status=rejected&
// payment_id=1318582892&
// status=rejected&
// external_reference={
/* 	%22IDEvento%22:%2261%22,
		%22total%22:%2220%22,
		%22IDSector%22:%223%22,
		%22dni%22:%2211111111%22,
		%22usuario%22:%227%22,
		%22obra%22:%22Patrulla%20canina%22,
		%22fecha%22:%222024-06-17%22,
		%22hora%22:%2217:00:00%22,
		%22teatro%22:%22TOLEDO%22,
		%22sala%22:%22SALA%201%22,
		%22precio%22:%2220.00%22
		}&
*/
// payment_type=credit_card
// &merchant_order_id=19778027609
// &preference_id=216147253-978b0eaf-8451-408b-8667-93dbf4f913a1
// &site_id=MLA
// &processing_mode=aggregator
// &merchant_account_id=null

$id_pago = $_GET['collection_id'];
$estado = $_GET['collection_status'];
$referencia = $_GET['external_reference'];
$id_orden_pago = $_GET['payment_id'];
$external_reference = json_decode($referencia);
$id_evento = $external_reference->IDEvento;
$id_sector = $external_reference->IDSector;
$total_venta = $external_reference->total;

?>

<!DOCTYPE html>
<html>
<head>
		<title>Datos del Pago</title>
</head>
<!DOCTYPE html>
<html>
<head>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f0f0f0;
		}
		.container {
			width: 80%;
			margin: 0 auto;
			margin-top: 50px;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
			border-radius: 8px;
		}
		h1 {
			color: #333;
		}
		p {
			color: #666;
		}
		button {
			padding: 10px 20px;
			background-color: #333;
			color: #fff;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Pago rechazado</h1>
		<p>Id del pago: <?php echo $id_pago; ?></p>
		<p>Estado del pago: <?php echo $estado; ?></p>
		<p>Id del evento : <?php echo $id_evento; ?></p>
		<p>Id del sector : <?php echo $id_sector; ?></p>
		<p>Total de la venta : <?php echo $total_venta; ?></p>
		<button onclick="window.location.href = 'https://5828-190-19-173-44.ngrok-free.app/';">Volver al inicio</button>
	</div>
</body>
</html>
</html>