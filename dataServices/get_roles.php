<?php
// get_data.php

// Conexión a la base de datos (reemplaza con tus propios datos)
// $servername = "localhost";
// $username = "jhernandezgauna";
// $password = "01+qqn+01unicen";
// $dbname = "necoticketdb";

$servername = "localhost";
$username = "root";
$password = "toor1234";
$dbname = "test_necoticket";

//$connString = 'mysql:host='.$servername.';dbname='.$dbname



$conn = new mysqli($servername, $username, $password, $dbname);
//$conn = new PDO($connString, $username, $password); // el campo vaciío es para la password. 

// Consulta para obtener los datos (reemplaza con tu consulta real)
$sql = "SELECT IDRol, Nombre, Descripcion FROM Roles";
$result = $conn->query($sql);

// Crear un array con los datos
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Devolver los datos en formato JSON
echo json_encode($data);

// Cerrar la conexión
$conn->close();
?>
