<?php
if($_SERVER['DOCUMENT_ROOT'] == "/var/www/html"){
function conexion(){
    $servidor = "localhost";
    $usuario = "mario";
    $clave = "MarLop1024";
  	$base = "necoticket";
  	$conexion = new mysqli($servidor,$usuario,$clave,$base);
  	mysqli_query($conexion,"SET NAMES 'utf8'");
  	return $conexion;
	}
  $conexion=conexion();
  define('__HOST__','http://localhost/planetaentrada');
}elseif ($_SERVER['DOCUMENT_ROOT'] == '/home/u365761547/domains/magicandlogic.net/public_html'){
  function conexion(){
    $servidor = "localhost";
  	$usuario = "u365761547_PT";
  	$clave = "MarLop2049";
  	$base = "u365761547_PT";
  	$conexion = new mysqli($servidor,$usuario,$clave,$base);
  	mysqli_query($conexion,"SET NAMES 'utf8'");
  	return $conexion;
	}
  $conexion=conexion();
  define('__HOST__','https://magicandlogic.net/entradadirecta');
}elseif($_SERVER['DOCUMENT_ROOT'] == '/var/www/vmxdr.cein.com.ar/'){
  function conexion(){
    $servidor = "localhost";
  	$usuario = "mglopez";
  	$clave = "MarLop+2048";
  	$base = "necotickettestdb";
  	$conexion = new mysqli($servidor,$usuario,$clave,$base);
  	mysqli_query($conexion,"SET NAMES 'utf8'");
  	return $conexion;
	}
  $conexion=conexion();

  define('__HOST__','https://vmxdr.cein.com.ar');

}else{

	// echo "if en raiz define conexion()" . PHP_EOL;
	
  // function conexion(){
  //   $servidor = "localhost";
  // 	$usuario = "mglopez";
  // 	$clave = "MarLop+2048";
  // 	$base = "necoticketdb";
  // 	$conexion = new mysqli($servidor,$usuario,$clave,$base);
  // 	mysqli_query($conexion,"SET NAMES 'utf8'");
  // 	return $conexion;
	// }


	function conexion(){
    $servidor = "localhost";
  	$usuario = "root";
  	$clave = "toor1234";
  	$base = "test_necoticket";
  	$conexion = new mysqli($servidor,$usuario,$clave,$base);
  	mysqli_query($conexion,"SET NAMES 'utf8'");
  	return $conexion;
	}

  $conexion=conexion();
	error_log("http host 66 " . $_SERVER['HTTP_HOST'] . PHP_EOL);

	if ($_SERVER['HTTP_HOST'] == 'localhost:8003'){
		define('__HOST__','http://localhost:8003');
	}else{
		define('__HOST__','https://www.entradadirecta.com.ar');
	}

	// if ($_SERVER['HTTP_HOST'] == 'localhost'){
	// }
	// define('__HOST__','http://localhost:8003/');
	

  // define('__HOST__','https://www.entradadirecta.com.ar');


}

// error_log("84 _REQUEST " . $_REQUEST. PHP_EOL);

if (isset($_REQUEST['sec'])) {
	error_log("87 _REQUEST seccion existe " . $_REQUEST['sec'] . PHP_EOL);
 $seccion=$_REQUEST['sec'].".php";
} 

if (!isset($_REQUEST['sec'])) {
	error_log("92 _REQUEST seccion no existe ". PHP_EOL);
 $seccion='inicio.php';
}

if (!file_exists($seccion))$seccion='inicio.php';

function formatFechaHora($fecha_ult){
    $fecha = substr($fecha_ult,8,2)."-".substr($fecha_ult,5,2)."-".substr($fecha_ult,0,4)." ".substr($fecha_ult,11,5);
    return $fecha;
  }


function formatPrecio($precio){
 if(strpos($precio,'.') > 0){
   $precio=substr($precio,0,strpos($precio,'.'));
 }
  $centenas=substr($precio,-3);
  $millares=substr($precio,0,-3);
  if($millares != '')
    $precio=$millares.".".$centenas;
  else
    $precio=$centenas;
  $precio="$ ".$precio.".-";
  return $precio;
}

function fichaFunciones($r,$rol,$arraySector,$IDUsuario){

	error_log("fichaFunciones 120 ");
	error_log("fichaFunciones r->IDEvento " . $r->IDEvento);
	error_log("fichaFunciones r->Obra " . $r->Obra);
	error_log("fichaFunciones rol " .  $rol);

  if($rol == 1){
    $alto=550;
  }else{
    $alto=460;
  }

  $html="<div class='divFicha' id='divFicha$r->IDEvento' style='height:".$alto."px;border: 1px solid #d0d0d0;
          border-radius:4px;padding:0px;margin-top:30px;'>";
  $html.="<div style='font-size:22px;font-weight:400;background:#fafafa;padding:10px;'>".$r->Obra."</div>";
  $html.="<div id='imagen$r->IDEvento' style='position:relative;margin-top:10px;border: 1px solid #f5f5f5;width:100%;height:260px;'>";
  if($r->Imagen == NULL){
    $html.="<img src='".__HOST__."/images/sinimagen.png' style='opacity:0.2;max-width:320px;max-height:260px;position: absolute;
             top: 50%;left: 50%; transform: translate(-50%, -50%);'>";
   }else{
     $html.="<img src=\"data:image/jpeg;base64,".base64_encode($r->Imagen)."\" style='max-width:320px;max-height:260px;
             position:absolute;top: 50%;left: 50%; transform: translate(-50%, -50%);'>";
  }
  $html.="</div>";
  $html.="<div style='font-size:18px;font-weight:400;margin-top:12px;'>".$r->Dia." ".substr($r->Hora,0,5)."</div>";
  $html.="<div style='font-size:18px;font-weight:300;margin-top:9px;color:#333;'>Teatro ".$r->Teatro."</div>";

  $html.="<div style='height:70px;display:table;width:100%;'>";
  $html.="<div style='display:table-cell;vertical-align:middle;'>";

  for($i=0; $i < count($arraySector); $i++ ) {
  $html.="<div style='float:left;margin-left:60px;font-size:15px;font-weight:300;margin-top:4px;color:#444;'>.".$arraySector[$i]['Sector']."</div>";
  $html.="<div style='float:right;margin-right:60px;font-size:15px;font-weight:400;margin-top:4px;color:#222;'>";
  if($rol == 1)
    $html.=formatPrecio($arraySector[$i]['PrecioPOS']);
  else
    $html.=formatPrecio($arraySector[$i]['PrecioOnline']);
  $html.="</div>";
  if($i == 0)
    $precioInicial=formatPrecio($arraySector[$i]['PrecioPOS']);
  }
  $html.="</div>";
  $html.="</div>";
  if($rol == 1){
  $html.="<div style='font-size:15px;color:#000;font-weight:300;margin-top:5px;'>
         <span style='color:#666'>Capacidad: </span>".$r->Capacidad." -
         <span style='color:#666;'>Vendidas: </span><span id='vendidas$r->IDEvento'>".$r->Vendidas."</span>&nbsp;</div>";
  $html.="<div style='margin-top:26px;'></div>";
  $html.="<span id='ficha$r->IDEvento' style='display:none;'>";
  $html.="<span id='subficha$r->IDEvento'>";
  $html.="<div style='margin-top:10px;'></div>";
  if(count($arraySector) > 0){
       $html.="<div style='color:#666;margin-top:10px;font-size:15px;'>Sector</div>";
       $html.="<select onchange=\"actualizarTotal('".$r->IDEvento."',selectCantidad$r->IDEvento.value,selectSector$r->IDEvento.value,'".__HOST__."')\" id='selectSector$r->IDEvento' style='border: 1px solid #d0d0d0;border-radius:3px;font-size:15px;
               margin:auto;background:#fafafa;padding:7px;color:#555;outline:none'>";

       for($i=0; $i < count($arraySector); $i++ ) {
          $html.="<option value='".$arraySector[$i]['IDSector']."'>".$arraySector[$i]['Sector']."</option>" ;
       }
      $html.="</select><br>";
     }
  $html.="<div style='color:#666;margin-top:10px;font-size:15px;'>Cantidad</div>";
  $html.="<select onchange=\"actualizarTotal('".$r->IDEvento."',selectCantidad$r->IDEvento.value,selectSector$r->IDEvento.value,'".__HOST__."')\" id='selectCantidad$r->IDEvento' style='border: 1px solid #d0d0d0;border-radius:3px;font-size:15px;
               margin:auto;background:#fafafa;padding:7px;color:#555;outline:none'>";
      $maxTotalVender=$r->Capacidad-$r->Vendidas+1;
      if ($maxTotalVender > 10)$maxTotalVender=11;
       for($i=1; $i < $maxTotalVender ; $i++ ) {
          $html.="<option value='".$i."'>".$i."</option>" ;
       }
     $html.="</select><br>";
     $html.="<input type='text' placeholder='DNI' id='dni$r->IDEvento' style='font-size:17px;padding:6px;width:180px;
             margin-top:12px;border-radius:3px;border:1px solid;border-color:#c0c0c0;'>";

  $html.="<div style='margin-top:20px;'></div>";

  $html.="</span>";
  $html.="<div style='float:left;margin-left:60px;font-size:15px;font-weight:300;margin-top:4px;color:#444;'>TOTAL:</div>";
  $html.="<div style='float:right;margin-right:60px;font-size:15px;font-weight:400;margin-top:4px;color:#222;'>";
  $html.="<span id='total$r->IDEvento'>$precioInicial</span>";
  $html.="</div>";
  $html.="<div style='margin-top:2px;'>&nbsp;</div>";
  $html.="<div id='mensaje$r->IDEvento' style='margin-top:30px;font-weight:400;color:#444;'>";
  $html.="&nbsp;";
  $html.="</div>";

  $html.="<div style='margin-top:12px;'></div>";
  $html.="<div id='botonGenerarEntrada$r->IDEvento'
 onclick=\"generarEntrada('".$r->IDEvento."',dni$r->IDEvento.value, selectSector$r->IDEvento.value,selectCantidad$r->IDEvento.value,'".$IDUsuario."','".__HOST__."')\"
style='font-size:18px;font-weight:300;margin:auto;background:#eee;padding:4px;width:160px;border-radius:4px;cursor:pointer;'>";
if($r->Capacidad == $r->Vendidas)
  $html.="Aceptar";
else
  $html.="Generar entrada";

$html.="</div>";
$html.="</span>";
$html.="<input type='hidden' id='tickets$r->IDEvento'>";
$html.="<div style='margin-top:20px;'></div>";
if($r->Capacidad == $r->Vendidas){
 $html.="<div><b>Entradas agotadas</b></div>";
}else {
  $html.="<div id='botonVender$r->IDEvento' onclick=\"abrirVender('".$r->IDEvento."')\" style='font-size:18px;font-weight:300;margin:auto;background:#eee;padding:4px 0px 4px 0px;width:150px;border-radius:4px;cursor:pointer;'>Vender</div>";
}
}
  $html.="</div>";
  return $html;
}



function login($usuario,$clave){
  $conexion=conexion();
  $salida="0";
  $sQuery="SELECT * FROM `Usuarios`";
	$res = $conexion->query($sQuery);
	
	error_log("click en login " . PHP_EOL);
	error_log("236 usuario clave" . $usuario . $clave . PHP_EOL);
	
  while($r = $res->fetch_object()){
		error_log("239 r idcard, r clave" . $r->IDCard . $r->Clave . PHP_EOL);
       if($r->IDCard == $usuario && $r->Clave == md5($clave)){
         $salida=$r->IDUsuario;
       }
     }

	error_log("salida en " . $salida . PHP_EOL);
  return $salida;
}

function formatFechaHoraDetalle($fecha){

	error_log("formatFechaHoraDetalle 251 " . $fecha . PHP_EOL);

$ary_dia=array("","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
$ary_mes=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $diaSemana=date("N", strtotime($fecha));
  $mes=date("n", strtotime($fecha));
  $dia=date("j", strtotime($fecha));
  $anio=date("Y", strtotime($fecha));
  $hora=substr($fecha,11,5);
  $fechaVer=$ary_dia[$diaSemana].", ".$dia." de ".$ary_mes[$mes]. " de ".$anio." ".$hora." hs";
  return $fechaVer;
}

function formatNumTicket($num){

	error_log("263 formatNumTicket num " . $num . PHP_EOL);

  $len=strlen($num);
  $hasta=7-$len;
  for ($j=0; $j < $hasta; $j++){
    $num="0".$num;
  }
  $numTicket="T".$num;
  return $numTicket;
}

/* onclick=\"generarEntrada('".$r->IDEvento."',selectCantidad$r->IDEvento.value, selectSector$r->IDEvento.value.'".$IDUsuario."','".__HOST__."')\" */ 
?>
