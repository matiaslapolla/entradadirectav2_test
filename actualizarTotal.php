<?php
include('function.php');

$IDEvento=$_POST['IDEvento'];
$cantidad=$_POST['cantidad'];
$sector=$_POST['sector'];

$sQuery="SELECT PrecioPOS FROM vewSectoresEvento WHERE IDEvento = '$IDEvento' AND IDSector = '$sector'";
$res = $conexion->query($sQuery);
while($r = $res->fetch_object()){
  $precio=$r->PrecioPOS;
}
$precio=$precio*$cantidad;


$precio=formatPrecio($precio);

echo $precio;

?>
