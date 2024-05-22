<?php
echo "<div style='width:100%;text-align:center;background:#fafafa;position:fixed;z-index:1;top:0px;left:0px;border: 1px solid;border-color: #ececec;>";
echo "<div style='margin:auto;max-width:1223px;'>";
echo "<div style='text-align:left;max-width:1223px;margin:auto;'>";
echo "<a href='".__HOST__."'><img id='logo' src='". __HOST__."/images/logoPlanetaEntrada.png' style='width:300px;padding:15px;aling:left;opacity:0.66;float:left;'></a>";
if(isset($_SESSION['usuario'])){
  echo "<a href='".__HOST__."/?logout=1'><div style='float:right;margin-right:4%;margin-top:14px;font-size:18px;font-weight:400;cursor:pointer;'> [ Salir ] </div></a>";
echo "<div style='float:right;margin-right:4%;margin-top:14px;font-size:18px;font-weight:400;cursor:pointer;'>".ucfirst($_SESSION['usuario'])." </div>";
}else  {
  echo "<a href='".__HOST__."/?sec=login'><div style='float:right;margin-right:4%;margin-top:14px;font-size:18px;font-weight:400;cursor:pointer;'> [ Ingresar ] </div></a>";
}
echo "</div>";
echo "</div>";
echo "</div>";
?>
