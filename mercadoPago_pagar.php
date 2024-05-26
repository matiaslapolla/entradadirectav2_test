<?php
require __DIR__  . '/vendor/autoload.php'; 
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

// MercadoPago\SDK::setAccessToken("TEST-6016666923341836-042218-aefeb2362e01336e62902dcdb49138db-216147253");



if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
    $paymentMethods = [
        "excluded_payment_methods" => [],
        "installments" => 1,
        "default_installments" => 1
    ];

		//url https://9772-190-19-173-44.ngrok-free
    $backUrls = array(
				"success" => "http://localhost:8003/mercadoPago_pagar.php",
				"failure" => "http://localhost:8003/mercadoPago_pagar.php",
				"pending" => "http://localhost:8003/mercadoPago_pagar.php"
		);

    $request = [
        "items" => $items,
        "payer" => $payer,
        "payment_methods" => $paymentMethods,
        "back_urls" => $backUrls,
        "statement_descriptor" => "NAME_DISPLAYED_IN_USER_BILLING",
        "external_reference" => "1234567890",
        "expires" => false,
        "auto_return" => 'approved',
    ];

    return $request;
}

function createPaymentPreference()
{
    // Fill the data about the product(s) being pruchased
    $product1 = array(
        "id" => "1234567890",
        "title" => "Product 1 Title",
        "description" => "Product 1 Description",
        "currency_id" => "ARS",
        "quantity" => 11,
        "unit_price" => 10
    );

    $product2 = array(
        "id" => "9012345678",
        "title" => "Product 2 Title",
        "description" => "Product 2 Description",
        "currency_id" => "ARS",
        "quantity" => 1,
        "unit_price" => 10
    );

    // Mount the array of products that will integrate the purchase amount
    $items = array($product1, $product2);


    $payer = array(
        "name" => "John",
        "surname" => "Doe",
        "email" => "test@gmail.com"
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
				echo $error->getMessage();
        return null;
    }
}

// Authenticate the SDK
authenticate();

// Create the payment preference
$preference = createPaymentPreference();

if ($preference) {
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
