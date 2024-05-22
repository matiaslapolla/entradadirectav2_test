<?php
echo "<div style='width:100%;text-align:center;margin-top:5%'>";
echo "<div style='margin:auto;width:380px;background:#fff;border:1px solid;border-color:#c0c0c0;
      height:270px;text-align:center;border-radius:4px;background:#fafafa'>";
echo "<div style='margin-top:20px;'><b>Inicia sessi&oacute;n</b></div>";
echo "<form action='index.php' method='post'>";
echo "<input type='text' placeholder='usuario' name='usuario' value='$usuario' style='font-size:15px;padding:10px;width:280px;margin-top:20px;
      border-radius:3px;border:1px solid;border-color:#c0c0c0;'>";
echo "<input type='password' placeholder='contraseña' name ='clave' value='$clave' style='font-size:15px;padding:10px;width:280px;
      margin-top:30px;border-radius:3px;border:1px solid;border-color:#c0c0c0;'>";
echo "<button type='submit' style='margin:auto;padding:10px;width:140px;margin-top:30px;background:#dedff0;border:1px solid;
      border-color:#c0c0c0;text-align:center;border-radius:4px;font-size:15px;cursor:pointer;'>Ingresar</button>";
echo "</form>";
echo "</div>";
echo "</div>";
?>
