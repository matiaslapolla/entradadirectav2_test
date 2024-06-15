<?php
// Get parameters from the URL
/* https://5828-190-19-173-44.ngrok-free.app/mercadoPago_pagar_pending.php?

collection_id=1318582918&
collection_status=in_process
&payment_id=1318582918
&status=in_process
&external_reference={
	%22IDEvento%22:%2261%22,
	%22total%22:%2220%22,
	%22IDSector%22:%223%22,
	%22dni%22:%2200000009%22,
	%22usuario%22:%227%22,
	%22obra%22:%22Patrulla%20canina%22,
	%22fecha%22:%222024-06-17%22,
	%22hora%22:%2217:00:00%22,
	%22teatro%22:%22TOLEDO%22,
	%22sala%22:%22SALA%201%22,
	%22precio%22:%2220.00%22
	}
&payment_type=credit_card
&merchant_order_id=19787132040
&preference_id=216147253-768de1f2-7512-424d-9e05-d005bc050070
&site_id=MLA
&processing_mode=aggregator
&merchant_account_id=null
*/

$estado = $_GET['collection_status'];
$referencia = $_GET['external_reference'];
$collection_id = $_GET['collection_id'];
$payment_id = $_GET['payment_id'];
$payment_type = $_GET['payment_type'];
$merchant_order_id = $_GET['merchant_order_id'];
$preference_id = $_GET['preference_id'];
$site_id = $_GET['site_id'];
$processing_mode = $_GET['processing_mode'];
$merchant_account_id = $_GET['merchant_account_id'];

$external_reference = json_decode($referencia);

$id_evento = $external_reference->IDEvento;
$total = $external_reference->total;
$id_sector = $external_reference->IDSector;
$dni = $external_reference->dni;
$obra = $external_reference->obra;
$sala = $external_reference->sala;

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
		button {
			padding: 10px 20px;
			background-color: #333;
			color: #fff;
			border: none;
			border-radius: 4px;
		}
		h1 {
			color: #333;
		}
		p {
			color: #666;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Resumen del pago pendiente</h1>
		<p>Id del pago: <?php echo $collection_id; ?></p>
		<p>Estado del pago: <?php echo $estado; ?></p>
		<p>Id del evento : <?php echo $id_evento; ?></p>
		<p>Total : <?php echo $total; ?></p>
		<p>Id del sector : <?php echo $id_sector; ?></p>
		<p>DNI : <?php echo $dni; ?></p>
		<p>Obra : <?php echo $obra; ?></p>
		<p>Sala : <?php echo $sala; ?></p>
		<button onclick="window.location.href = 'https://5828-190-19-173-44.ngrok-free.app/mercadoPago_pagar.php';">Volver a pagar</button>
	</div>
</body>
</html>
</html>

