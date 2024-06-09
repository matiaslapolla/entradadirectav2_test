<?php
// Get parameters from the URL
$id_pago = $_GET['payment_id'];
$estado = $_GET['status'];
$referencia = $_GET['external_reference'];
$id_orden_pago = $_GET['merchant_order_id'];

echo "Payment pending!";

// Process the data (e.g., update order status in your database)
if ($estado == 'approved') {
    echo "Payment successful!";
} else {
    echo "Payment status: " . $collection_status;
}
?>
