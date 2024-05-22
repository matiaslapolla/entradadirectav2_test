<?php
if(isset($_SESSION['usuario']))
  $rol=1;
else
  $rol=0;

$sQuery="SELECT IDEvento, Sector, PrecioOnline, PrecioPOS, IDSector FROM vewSectoresEvento";
$res = $conexion->query($sQuery);
$anterior='';
while($r = $res->fetch_object()){
  if($r->IDEvento != $anterior){
   $arraySectores[$r->IDEvento][]=array('IDSector' => $r->IDSector,'Sector' => $r->Sector, 'PrecioOnline' => $r->PrecioOnline, 'PrecioPOS' => $r->PrecioPOS);
  }else{
    array_push($arraySectores[$r->IDEvento],array("IDSector" => $r->IDSector, "Sector" => $r->Sector, "PrecioOnline" => $r->PrecioOnline, "PrecioPOS" => $r->PrecioPOS));
  }
   $anterior=$r->IDEvento;
 }

/*echo "<pre>";
var_dump($arraySectores);
echo "</pre>";
echo "<br>-----------------------------<br>";
echo "<pre>";
$arrayTmp=$arraySectores['22'];
var_dump($arrayTmp);
echo "</pre>";

for($i=0; $i < count($arrayTmp); $i++ ) {

   echo $arrayTmp[$i]['Sector']." ".$arrayTmp[$i]['PrecioOnline']."<br>";

}*/

if(isset($_SESSION['rol']))
  $IDUsuario=$_SESSION['IDUsuario'];
else
  $IDUsuario="";

//echo "<span id='tmp'>result</span>";


//$sQuery="SELECT * FROM vewEventos GROUP BY IDEvento";
$sQuery="SELECT * FROM vewEventos";
$res = $conexion->query($sQuery);
while($r = $res->fetch_object()){
   $arraySector=$arraySectores[$r->IDEvento];
   echo fichaFunciones($r,$rol,$arraySector,$IDUsuario);
 }



?>
