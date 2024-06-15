function valorar() {
	var xmlhttp = false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest != "undefined") {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function detectarScroll() {
	var scroll = document.documentElement.scrollTop;
	var logo = document.getElementById("logo");
	if (scroll > 100) {
		logo.style.width = "140px";
	} else {
		logo.style.width = "300px";
	}
}
window.addEventListener("scroll", detectarScroll);

function abrirVender(IDEvento) {
	document.getElementById("botonVender" + IDEvento).style.display = "none";
	document.getElementById("imagen" + IDEvento).style.display = "none";
	document.getElementById("ficha" + IDEvento).style.display = "block";
}

function generarEntrada(IDEvento, dni, sector, cantidad, usuario, ruta) {
	capaTickets = document.getElementById("tickets" + IDEvento);
	capaSubFicha = document.getElementById("subficha" + IDEvento);
	capa = document.getElementById("botonGenerarEntrada" + IDEvento);
	capaMensaje = document.getElementById("mensaje" + IDEvento);
	capaVendidas = document.getElementById("vendidas" + IDEvento);
	if (
		capa.innerHTML == "Generar entrada" ||
		capa.innerHTML == "Generar entradas"
	) {
		capa.innerHTML =
			"<img src='" +
			ruta +
			"/images/ajax.gif' style='width:24px;vertical-align:middle;'>";
		var ajax = valorar();
		ajax.open("POST", ruta + "/agregarEntrada.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send(
			"IDEvento=" +
				IDEvento +
				"&dni=" +
				dni +
				"&sector=" +
				sector +
				"&cantidad=" +
				cantidad +
				"&usuario=" +
				usuario
		);
		ajax.onreadystatechange = function () {
			if (ajax.readyState == 4) {
				var retorno = ajax.responseText;
				var arrayRetorno = retorno.split(";");
				capaMensaje.innerHTML = arrayRetorno[0];
				capaMensaje.style.marginTop = "210px";
				capa.innerHTML = "Generar Ticket";
				capaVendidas.innerHTML = arrayRetorno[1];
				capaSubFicha.style.display = "none";
				capaTickets.value = arrayRetorno[2];
			}
		};
	}
	if (capa.innerHTML == "Generar Ticket") {
		let ticketData = {
			IDEvento: IDEvento,
			dni: dni,
			sector: sector,
			cantidad: cantidad,
			usuario: usuario,
		};
		var tickets = capaTickets.value;
		window.open(
			ruta +
				"/generarTicket.php?IDEvento=" +
				IDEvento +
				"&sector=" +
				sector +
				"&tickets=" +
				tickets
		);
		handleMercadoPago(ticketData);
	}
}

function handleMercadoPago(ticketData) {
	window.location.href = `
		mercadoPago.php?
		IDEvento=${ticketData.IDEvento}&
		dni=${ticketData.dni}&
		sector=${ticketData.sector}&
		cantidad=${ticketData.cantidad}&
		usuario=${ticketData.usuario}`;
}

async function createOrder(ticketData) {
	mercadopago.configure({
		access_token:
			"APP_USR-6016666923341836-042218-96e4f012cd853467bf9ea7aa21e2c9f2-216147253",
		// access_token: process.env.MERCADOPAGO_ACCESS_TOKEN, // token del vendedor
		// client_id: process.env.MERCADOPAGO_CLIENT_ID,
		// client_id: "969284846932526",
		// client_secret: process.env.MERCADOPAGO_CLIENT_SECRET,
		// client_secret: "b3E6d2JORAsRFQrT8jkJ4PexslfXpvr4",
	});

	const result = await mercadopago.preferences.create({
		items: [
			{
				title: "La chanchi hermosa",
				unit_price: 10,
				currency_id: "ARS",
				quantity: 1,
			},
		],
		back_urls: {
			success: `${HOST}/success`,
			failure: `${HOST}/failure`,
			pending: `${HOST}/pending`,
		},
		notification_url: "https://5828-190-19-173-44.ngrok-free.app/webhook",
	});

	console.log(result);
	res.send(result.body);
	// res.send(result.body);
	//res.send('Exito!');
}

async function receiveWebhook(req, res) {
	const payment = req.query;

	try {
		//if (payment.type == "payment") {
		//const data = mercadopago.payment.findById(payment["data.id"]);
		console.log("---- Datos que recibe Webhook ----");
		console.log(payment);
		console.log("---- FIN datos recibidos de Webhook ----");

		if (payment.type == "payment") {
			const data = await mercadopago.payment.findById(payment["data.id"]);
			console.log("DATA DE PAGO WEBHOOK => ", data);
		}

		// STORE in database
		//}
		// Esta la mando para probar
		//return res.sendStatus(204).json({ data })
		//console.log(data);
		// Esta de abajo es la del video
		return res.sendStatus(204);
	} catch (error) {
		console.log(error);
		return res.sendStatus(500).json({ error: error.message });
	}
}

//  export const successDrive = (req, res) => {
// 	const payment = req.query;
// 	try {
// 		console.log("---- Datos que recibe successDrive ----");
// 		console.log(payment);
// 		console.log("---- FIN datos recibidos de successDrive ----");

// 		// STORE in database
// 		return res.sendStatus(204);
// 	} catch (error) {
// 		console.log(error);
// 		return res.sendStatus(500).json({ error: error.message });
// 	}

function actualizarTotal(IDEvento, cantidad, sector, ruta) {
	capa = document.getElementById("total" + IDEvento);
	if (
		document.getElementById("botonGenerarEntrada" + IDEvento).innerHTML ==
			"Generar entrada" ||
		document.getElementById("botonGenerarEntrada" + IDEvento).innerHTML ==
			"Generar entradas"
	) {
		if (cantidad > 1)
			document.getElementById("botonGenerarEntrada" + IDEvento).innerHTML =
				"Generar entradas";
		else
			document.getElementById("botonGenerarEntrada" + IDEvento).innerHTML =
				"Generar entrada";
	}
	var ajax = valorar();
	ajax.open("POST", ruta + "/actualizarTotal.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(
		"IDEvento=" + IDEvento + "&cantidad=" + cantidad + "&sector=" + sector
	);
	ajax.onreadystatechange = function () {
		if (ajax.readyState == 4) {
			capa.innerHTML = ajax.responseText;
		}
	};
}

function generarEntradaOld(IDEvento, dni, sector, cantidad, usuario, ruta) {
	/*capaTMP=document.getElementById("tmp");*/
	capaSubFicha = document.getElementById("subficha" + IDEvento);
	capa = document.getElementById("botonGenerarEntrada" + IDEvento);
	capaMensaje = document.getElementById("mensaje" + IDEvento);
	capaVendidas = document.getElementById("vendidas" + IDEvento);
	if (
		capa.innerHTML == "Generar entrada" ||
		capa.innerHTML == "Generar entradas"
	) {
		capa.innerHTML =
			"<img src='" +
			ruta +
			"/images/ajax.gif' style='width:24px;vertical-align:middle;'>";
		var ajax = valorar();
		ajax.open("POST", ruta + "/agregarEntrada.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send(
			"IDEvento=" +
				IDEvento +
				"&dni=" +
				dni +
				"&sector=" +
				sector +
				"&cantidad=" +
				cantidad +
				"&usuario=" +
				usuario
		);
		ajax.onreadystatechange = function () {
			if (ajax.readyState == 4) {
				var retorno = ajax.responseText;
				var arrayRetorno = retorno.split(";");
				capaMensaje.innerHTML = arrayRetorno[0];
				capaMensaje.style.marginTop = "210px";
				capa.innerHTML = "Aceptar";
				capaVendidas.innerHTML = arrayRetorno[1];
				capaSubFicha.style.display = "none";
			}
		};
	} else {
		location = ruta;
		location.reload();
	}
}
