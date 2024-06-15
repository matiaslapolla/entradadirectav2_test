<?php
require __DIR__  . '/vendor/autoload.php'; 
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$IDEvento = $_POST['IDEvento'];
	$sector = $_POST['sector'];
	$cantidad = $_POST['cantidad'];
	$usuario = $_POST['usuario'];
	$obra = $_POST['obra'];
	$fecha = $_POST['fecha'];
	$hora = $_POST['hora'];
	$teatro = $_POST['teatro'];
	$sala = $_POST['sala'];
	$precio = $_POST['precio'];
	$total = $_POST['total'];
	$dni = $_POST['dni'];

function authenticate()
{
		// Utiliza el access token de prueba para autenticar el SDK y poder hacer la request
    MercadoPagoConfig::setAccessToken("TEST-6016666923341836-042218-aefeb2362e01336e62902dcdb49138db-216147253");
		// Tus tokens deberian estar aca https://www.mercadopago.com.ar/settings/account/credentials
}

function createPreferenceRequest($items, $payer)
{
		global $IDEvento, $dni, $sector, $cantidad, $usuario, $obra, $fecha, $hora, $teatro, $sala, $precio, $total;

/*
		"success" => "https://<TU URL>/mercadoPago_pagar_success.php",
		"failure" => "https://<TU URL>/mercadoPago_pagar_failure.php",
		"pending" => "https://<TU URL>/mercadoPago_pagar_pending.php	"
*/

    $backUrls = array(
				"success" => "https://5828-190-19-173-44.ngrok-free.app/mercadoPago_pagar_success.php",
				"failure" => "https://5828-190-19-173-44.ngrok-free.app/mercadoPago_pagar_failure.php",
				"pending" => "https://5828-190-19-173-44.ngrok-free.app/mercadoPago_pagar_pending.php	"
		);

    $request = [
        "items" => $items,
        "back_urls" => $backUrls,
        "external_reference" => [
					"IDEvento" => $IDEvento,
					"total" => $total,
					"IDSector" => $sector,
					"dni" => $dni,
					"usuario" => $usuario,
					"obra" => $obra,
					"fecha" => $fecha,
					"hora" => $hora,
					"teatro" => $teatro,
					"sala" => $sala,
					"precio" => $precio
					
				],
				// el auto return es solo cuando el pago se aprueba
        "auto_return" => 'approved',
    ];

    return $request;
}

function createPaymentPreference()
{

		global $IDEvento, $obra, $sector, $cantidad, $precio;
    $product1 = array(
				"id" => $IDEvento,
				"title" => "Entrada (s) para la obra: " . $obra,
				"description" => " Sector: " . $sector . " Cantidad: " . $cantidad . " Precio: " . $precio,
				"currency_id" => "ARS",
				"quantity" => (int) $cantidad,
				"unit_price" => (float) $precio
    );

    $items = array($product1);

    $payer = [];

    $request = createPreferenceRequest($items, $payer);

    $client = new PreferenceClient();

    try {

			$preference = $client->create($request);

        return $preference;
    } catch (MPApiException $error) {
				error_log($error->getMessage());
				error_log($error->getTraceAsString());
				error_log(json_encode($error));
        return null;
    }
}

authenticate();

$preference = createPaymentPreference();

try {
	header('Location: ' . $preference->init_point);
} catch (\Throwable $th) {
	echo "There was an error creating the preference";
	echo $th;
}

 


}

?>
