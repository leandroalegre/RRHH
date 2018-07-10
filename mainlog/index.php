<!DOCTYPE html>
<html lang="EN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Panel Administrativo </title>

<link href="../css/estilos.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body>

<?php

      $sidc=35;
     // echo $sidc;
       $setFormulario='<form method="POST" action="../login_sadm.php"> 
  <div align="center">
    <table width="300" border="0" cellpadding="7">
      <tr>
        <td><span class="style8">Usuario:</span></td>
        <td><input type="text" name="usuario" size="20" maxlength="20" class="campoform"/></td>
      </tr>
      <tr>
        <td><span class="style3">Password:</span></td>
        <td><input type="password" name="password" size="20" maxlength="20" class="campoform"/></td>
      </tr>
      <tr>
        <td></td>
        <td align="right"><input type="hidden" name="sidc" value="'.$sidc.'" /></td>
        <td align="right"><input type="submit" class="botonform" value="Ingresar" /></td>
      </tr>
    </table>
<br/>
  </div>
</form>';
?>

<div style="height:16px;"></div>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td height="88" valign="top"><img src="../images/logo.jpg" width="136" height="67" /></td>
</tr>
<tr>
  <td bgcolor="#717171" height="35"><div align="right" class="encabezado">Acceso al Panel de Control xxxx- Sistema de Legajos</div></td>
</tr>
<tr>
  <td bgcolor="#FFFFFF" >
  
  
  <br/><br/>
  <?php echo $setFormulario ?>
  <br/>
  </td>
</tr>
</table>
<div style="height:3px;"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle" bgcolor="#717171" height="30" valign="bottom"><span class="pie">Municipalidad de Villa Carlos Paz - Sistema de Legajos</span></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#f3661f" height="5"></td>
  </tr>
</table>
</body>
</html>