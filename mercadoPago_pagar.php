<?php
require __DIR__  . '/vendor/autoload.php'; 
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

// MercadoPago\SDK::setAccessToken("TEST-6016666923341836-042218-aefeb2362e01336e62902dcdb49138db-216147253");



if ($_SERVER["REQUEST_METHOD"] == "POST") {

$IDEvento = $_POST['IDEvento'];
$dni = $_POST['dni'];
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

function authenticate()
{
    // Getting the access token from .env file (create your own function)
    // $mpAccessToken = getVariableFromEnv('mercado_pago_access_token');
    // Set the token the SDK's config
    MercadoPagoConfig::setAccessToken("TEST-6016666923341836-042218-aefeb2362e01336e62902dcdb49138db-216147253");
    // (Optional) Set the runtime enviroment to LOCAL if you want to test on localhost
    // Default value is set to SERVER
    // MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
}

// Function that will return a request object to be sent to Mercado Pago API
function createPreferenceRequest($items, $payer)
{

		//url https://9772-190-19-173-44.ngrok-free
    $backUrls = array(
				"success" => "https://3510-190-19-173-44.ngrok-free.app/mercadoPago_pagar_success.php",
				"failure" => "https://3510-190-19-173-44.ngrok-free.app/mercadoPago_pagar_failure.php",
				"pending" => "https://3510-190-19-173-44.ngrok-free.app/mercadoPago_pagar_pending.php	"
		);

    $request = [
        "items" => $items,
        // "payer" => $payer,
        // "payment_methods" => $paymentMethods,
        "back_urls" => $backUrls,
        // "statement_descriptor" => "NAME_DISPLAYED_IN_USER_BILLING",
        "external_reference" => [
						"IDEvento" => $IDEvento,
				],
        // "expires" => false,
				// el auto return es solo cuando el pago se aprueba
        "auto_return" => 'approved',
    ];

    return $request;
}

function createPaymentPreference()
{
	//guide 
	
		// https://www.youtube.com/watch?v=-VD-l5BQsuE&t=1112s
		// https://www.youtube.com/watch?v=QqiDandkcBY&t=2191s
    // Fill the data about the product(s) being pruchased

		global $IDEvento, $obra, $sector, $cantidad, $precio;
    $product1 = array(
				"id" => $IDEvento,
				"title" => "Entrada (s) para la obra: " . $obra,
				"description" => "Sector: " . $sector,
				"currency_id" => "ARS",
				"quantity" => (int) $cantidad,
				"unit_price" => (float) $precio
    );

		error_log("entro aca mercadoPago.php 89" . PHP_EOL);
		error_log(json_encode($product1));

    // Mount the array of products that will integrate the purchase amount
    $items = array($product1);

    $payer = array(
        "name" => "John",
        "surname" => "Doe",
        "email" => "matias.lapolla.1@gmail.com"
    );

    // Create the request object to be sent to the API when the preference is created
    $request = createPreferenceRequest($items, $payer);

    // Instantiate a new Preference Client
    $client = new PreferenceClient();

    try {
        // Send the request that will create the new preference for user's checkout flow
        $preference = $client->create($request);

        // Useful props you could use from this object is 'init_point' (URL to Checkout Pro) or the 'id'
        return $preference;
    } catch (MPApiException $error) {
        // Here you might return whatever your app needs.
        // We are returning null here as an example.
				error_log("entro aca mercadoPago.php 116" . PHP_EOL);
				error_log($error->getMessage());
				error_log("entro aca mercadoPago.php 118" . PHP_EOL);
				error_log($error->getTraceAsString());
				// string error
				error_log(json_encode($error));

        return null;
    }
}

// Authenticate the SDK
authenticate();

error_log("entro aca mercadoPago.php 130" . PHP_EOL);
// Create the payment preference
$preference = createPaymentPreference();

if ($preference) {
	error_log("entro aca mercadoPago.php 135" . PHP_EOL);
		// Here you can do whatever you want with the preference object
		// For example, you can redirect the user to the checkout page
		// header('Location: ' . $preference->init_point);

		error_log($preference->init_point);
		header('Location: ' . $preference->init_point);
} else {
		// Handle the error
		echo "There was an error creating the preference";
}



}

?>
