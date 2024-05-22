<?php

include('../config/config.php');

$sql = "Select DATE(b.fhcrearow) As Fecha, vse.ObraTeatral, vse.Sector, Concat(vse.Fecha, ' ',vse.Hora) As FechaHora, Count(IDButaca) As Cantidad, 8000.00 As TotalSector
From vewSectoresEvento vse
Join Butacas b On vse.IDEvento = b.IDEvento And vse.IDSector = b.IDSector
GROUP BY vse.IDEvento, vse.IDSector, DATE(b.fhcrearow)
ORDER BY DATE(b.fhcrearow), ObraTeatral;";

$result = $conexion->query($sql);

// Crear un array con los datos
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Devolver los datos en formato JSON
echo json_encode($data);


?>
