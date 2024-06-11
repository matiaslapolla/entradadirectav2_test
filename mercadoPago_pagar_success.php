<?php
// Get parameters from the URL

include('function.php');
$id_pago = $_GET['payment_id'];
$estado = $_GET['status'];
$referencia = $_GET['external_reference'];
$id_orden_pago = $_GET['merchant_order_id'];
$preference_id = $_GET['preference_id'];
$site_id = $_GET['site_id'];
$processing_mode = $_GET['processing_mode'];
$merchant_account_id = $_GET['merchant_account_id'];
$collection_id = $_GET['collection_id'];
$collection_status = $_GET['collection_status'];
$payment_type = $_GET['payment_type'];
$merchant_order_id = $_GET['merchant_order_id'];

// table model
// id SERIAL PRIMARY KEY,
// IDEvento INTEGER REFERENCES Eventos(IDEvento),
// IDSectorEvento INTEGER REFERENCES SectoresEvento(IDSectorEvento),
// FechaVenta DATE,
// CantidadEntradas INTEGER,
// PrecioTotal DECIMAL(10,2)


#url form
# https://1127-190-230-204-110.ngrok-free.app/mercadoPago_pagar_success.php?
#	collection_id=1323840585&
#	collection_status=approved&
#	payment_id=1323840585&
#	status=approved&
#	external_reference=null&
#	payment_type=credit_card&
#	merchant_order_id=19570473368&
#	preference_id=216147253-b91e4a11-8848-4fc2-af94-9d19dd52a9a7&
#	site_id=MLA&
#	processing_mode=aggregator&
#	merchant_account_id=null

// Process the data (e.g., update order status in your database)
if ($estado == 'approved') {
	$query = [];

	

} else {

}

?>

<!DOCTYPE html>
<html>
<head>
		<title>Payment Status</title>
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
	</style>
</head>
<body>
	<div class="container">
		<h1>Payment Status</h1>
		<p>Payment ID: <?php echo $id_pago; ?></p>
		<p>Status: <?php echo $estado; ?></p>
		<p>External Reference: <?php echo $referencia; ?></p>
		<p>Merchant Order ID: <?php echo $id_orden_pago; ?></p>
		<p>Preference ID: <?php echo $preference_id; ?></p>
		<p>Site ID: <?php echo $site_id; ?></p>
		<p>Processing Mode: <?php echo $processing_mode; ?></p>
		<p>Merchant Account ID: <?php echo $merchant_account_id; ?></p>
		<p>Collection ID: <?php echo $collection_id; ?></p>
		<p>Collection Status: <?php echo $collection_status; ?></p>
		<p>Payment Type: <?php echo $payment_type; ?></p>
		<p>Merchant Order ID: <?php echo $merchant_order_id; ?></p>
	</div>
</body>
</html>
</html>

