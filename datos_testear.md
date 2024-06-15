Datos para testear la aplicacion:

--- TARJETAS ---

Num Tarjeta: 5031 7557 3453 0604
Codigo seguridad: 123
Fecha expiracion: 11 / 25

Nombre titular - pago aprobado: APRO
Nombre titular - pago rechazado: OTHE
Nombre titular - pago pendiente: CONT

MAS INFO TARJETAS: https://www.mercadopago.com.ar/developers/es/docs/your-integrations/test/cards

--- PREFERENCIA = ITEM PAGO PARA MPAGO ---

Modelo completo json:

{
"items": [
{
"id": "item-ID-1234",
"title": "Mi producto",
"currency_id": "ARS",
"picture_url": "https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",
"description": "Descripción del Item",
"category_id": "art",
"quantity": 1,
"unit_price": 75.76
}
],
"payer": {
"name": "Juan",
"surname": "Lopez",
"email": "user@email.com",
"phone": {
"area_code": "11",
"number": "4444-4444"
},
"identification": {
"type": "DNI",
"number": "12345678"
},
"address": {
"street_name": "Street",
"street_number": 123,
"zip_code": "5700"
}
},
"back_urls": {
"success": "https://www.success.com",
"failure": "https://www.failure.com",
"pending": "https://www.pending.com"
},
"auto_return": "approved",
"payment_methods": {
"excluded_payment_methods": [
{
"id": "master"
}
],
"excluded_payment_types": [
{
"id": "ticket"
}
],
"installments": 12
},
"notification_url": "https://www.your-site.com/ipn",
"statement_descriptor": "MINEGOCIO",
"external_reference": "Reference_1234",
"expires": true,
"expiration_date_from": "2016-02-01T12:00:00.000-04:00",
"expiration_date_to": "2016-02-28T12:00:00.000-04:00"
}

Items: item venta, que se va a pagar -> se carga datos del producto a vender con lo que hacemos al generar la entrada

Payer: datos del comprador -> reemplazar por usuario comprador? Lo probe sin utilizar estos datos y no genera inconvenientes

Backurls: urls a las que se redirige al usuario luego de pagar -> reemplazar por urls de la app

Auto_return: cuando el pago es aprobado ahi se redirige a la backurl, si el pago es pendiente o rechazado no se redirige. En estos ultimos casos mercadopago te permite reintentar pagar.

Payment_methods: metodos de pago habilitados. Para tener mas info hacer un GET con tu token como Bearer Token a https://api.mercadopago.com/v1/payment_methods.

Installments: cantidad de cuotas habilitadas para el pago.

Notification_url: url a la que mercadopago envia informacion sobre el pago. // No estoy seguro si es necesario

External_reference: referencia externa que se puede utilizar para identificar el pago. Este campo nos permite enviar datos adicionales que se guardan en la base de datos de mercadopago y ademas los podes usar en el backurl cuando se hizo el pago.

Expires: si el pago expira o no.
Expiration_date_from: fecha desde la cual el pago es valido.
Expiration_date_to: fecha hasta la cual el pago es valido.

Estos ultimos no los utilice y no generaron inconvenientes.

Mas info pagos: https://www.mercadopago.com.ar/developers/es/reference

--- TOKENS ---

Info sobre tokens: https://www.mercadopago.com.ar/developers/es/reference/oauth/_oauth_token/post

--- CREDENCIALES ---

https://www.mercadopago.com.ar/settings/account/credentials

--- VIDEOS GUIA UTILES ---

https://www.youtube.com/watch?v=-VD-l5BQsuE&t=1112s
https://www.youtube.com/watch?v=QqiDandkcBY&t=2191s

--- IMPLEMENTACION EN EL PROYECTO TICKETERA ---

Flow de MercadoPago:

    Al presionar "Agregar Entrada" se ejecuta el metodo generarEntrada() y dentro de este se llama a handleMercadopago().

    En handleMercadopago() se redirige a mercadoPago.php, donde el submit del formulario te envia a mercadoPago_pagar.php con los datos de este.

    En mercadoPago_pagar.php debes poner tus credenciales en el metodo authenticate(), luego cambiar el host de la back_url

    /*
    	"success" => "https://<TU URL>/mercadoPago_pagar_success.php",
    	"failure" => "https://<TU URL>/mercadoPago_pagar_failure.php",
    	"pending" => "https://<TU URL>/mercadoPago_pagar_pending.php	"
    */

    En mercadoPago_pagar_success.php, mercadoPago_pagar_failure.php y mercadoPago_pagar_pending.php se redirige a la pagina de inicio de la app y se muestran mensajes de exito, fracaso o pendiente.

    	Cuando el pago fallo en la pagina de MercadoPago tenemos un boton que indica "Volver a <Nombre de tu aplicaicon de mercadopago>" que te redirige a la pagina de la app correspondiente justamente a que el pago fallo.

--- EXTRA UTIL ---

Repositorio SDK MercadoPago:

https://github.com/mercadopago/sdk-php
