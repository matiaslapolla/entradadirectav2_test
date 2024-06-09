<?php
// Get parameters from the URL
$id_pago = $_GET['payment_id'];
$estado = $_GET['status'];
$referencia = $_GET['external_reference'];
$id_orden_pago = $_GET['merchant_order_id'];

echo "Payment successful";


// Process the data (e.g., update order status in your database)
if ($estado == 'approved') {
    echo "Payment successful!";
} else {
    echo "Payment status: " . $collection_status;
}

?>

<!DOCTYPE html>
<html>
<head>
		<title>Payment Status</title>
</head>
<body>
		<h1>Payment Status</h1>
		<p>Payment ID: <?php echo $id_pago; ?></p>
		<p>Payment Status: <?php echo $estado; ?></p>
		<p>External Reference: <?php echo $referencia; ?></p>
		<p>Merchant Order ID: <?php echo $id_orden_pago; ?></p>
</body>
</html>

