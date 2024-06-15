<?php

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

$id_evento = json_decode($referencia)->IDEvento;
$usuario = json_decode($referencia)->usuario;
$total_venta = json_decode($referencia)->total;
$sector = json_decode($referencia)->IDSector;
$dni = json_decode($referencia)->dni;

$butacaQuery = "SELECT IDButaca FROM Butacas WHERE IDEvento = $id_evento AND IDSector = $sector AND ESTADO = 1 AND NroDocumento = $dni;";
$butacaResult = $conexion->query($butacaQuery);

$IDButacas = [];

foreach ($butacaResult as $butaca) {
	$IDButacas[] = $butaca['IDButaca'];
}

try {
    $IDButacas = json_encode($IDButacas);

    $ventaQuery = "INSERT INTO Ventas (IDButaca, IDPago, IDVendedor, TotalVenta) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($ventaQuery);

    if ($stmt === false) {
        throw new Exception('Failed to prepare statement: ' . $conexion->error);
    }

    if (!$stmt->bind_param('ssss', $IDButacas, $id_pago, $usuario, $total_venta)) {
        throw new Exception('Failed to bind parameters: ' . $stmt->error);
    }

    if (!$stmt->execute()) {
        throw new Exception('Failed to execute statement: ' . $stmt->error);
    }

    $IDVenta = $conexion->insert_id;

		foreach ($butacaResult as $butaca) {
			$butacaQuery = "UPDATE Butacas SET IDVenta = $IDVenta WHERE IDButaca = " . $butaca['IDButaca'] . ";";
			$conexion->query($butacaQuery);
		}

		$stmt->close();
		$conexion->close();
		error_log('Venta registrada con éxito');

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    error_log('Error in mercadoPago_pagar_success.php: ' . $e->getMessage());
}

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
		<h1>Resumen del pago</h1>
		<p>Id del pago: <?php echo $id_pago; ?></p>
		<p>Estado del pago: <?php echo $estado; ?></p>
		<!-- <p>External Reference: <?php echo $referencia; ?></p> -->
		<!-- <p>Merchant Order ID: <?php echo $id_orden_pago; ?></p> -->
		<!-- <p>Preference ID: <?php echo $preference_id; ?></p> -->
		<!-- <p>Site ID: <?php echo $site_id; ?></p> -->
		<!-- <p>Processing Mode: <?php echo $processing_mode; ?></p> -->
		<!-- <p>Merchant Account ID: <?php echo $merchant_account_id; ?></p> -->
		<!-- <p>Collection ID: <?php echo $collection_id; ?></p> -->
		<!-- <p>Collection Status: <?php echo $collection_status; ?></p> -->
		<!-- <p>Payment Type: <?php echo $payment_type; ?></p> -->
		<!-- <p>Merchant Order ID: <?php echo $merchant_order_id; ?></p> -->
		<p>Id del evento : <?php echo $id_evento; ?></p>
		<p>Butacas actualizadas : <?php echo json_encode($IDButacas); ?></p>
		<p>Id de la venta : <?php echo $IDVenta; ?></p>
	</div>
</body>
</html>
</html>

