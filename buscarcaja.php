<?php
session_start();
include "encabezado.php";
//-----------------------------------------
//Javascript
echo '<SCRIPT type="text/javascript">
	function valida(){
	  permitidos=/^([0-9])*$/;
	  permitidosmail=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	  
	  if(document.form.criterio.value==\'\') {
		document.form.criterio.focus();
		alert(\'Debe ingresar un Criterio de Busqueda Nombre completo o parte.\');
		return false;
	  } else {
		document.form.submit();
		return true;
	  }
	}
	</SCRIPT>';
if (isset($_SESSION['Id_Usuario'])) {
	//TITULO
	?>
	<tr>
      <td bgcolor="#717171" height="35"><div align="right" class="encabezado">BUSCAR CAJAS</div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
	<?php
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//main
	if (isset($_POST['accion']) and $_POST['accion']=="buscar"){
		$criterio=$_POST['criterio'];
		$banderabgc=0;	
		//echo "holaaaaaaaaaaaaa".$anos;
		function bisiesto($anio_actual){
			$bisiesto=false;
			//probamos si el mes de febrero del año actual tiene 29 días
			  if (checkdate(2,29,$anio_actual)){
				$bisiesto=true;
			}
			return $bisiesto;
		} 
		//-------------------------------------------------------------------------------
		//listado
		echo "<div align='center' class='subtitulo'><br>Listado de Cajas bajo el criterio de búsqueda: ".$criterio."</div><br>";
		include "conexion.php";
		//$result = mysql_query("SELECT * FROM Sis_Personas WHERE Nombre Like '%$criterio%' OR Apellido Like '%$criterio%' OR DNI='$criterio' ORDER BY Nombre");
		$result = 'SELECT * FROM sis_caja WHERE nombre Like ? ORDER BY nombre';
		$stmt = $conn->prepare($result);
		if($stmt === false) {
				trigger_error('Wrong SQL: ' . $result . ' Error: ' . $conn->error, E_USER_ERROR);
			}
			$criterio_final="%".$criterio."%";
			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
			$stmt->bind_param('s', $criterio_final);
			$stmt->execute();
			$rs=$stmt->get_result();
		if($row=$rs->fetch_assoc()){
			echo'<table align="center" width="80%" cellpadding="0" cellspacing="0" border="0" class="tablalistado_principal"><tr><td align="center"  class="tablalistado_encabezado" > Caja </td></tr>';
				$trstyle=Null;
				$banderatr=Null;
			do {
				//controlo el color de fondo de la tabla
				if ($banderatr==0){
					$trstyle="tablalistado_tr2";
					$banderatr=1;
				}else{
					$trstyle="tablalistado_tr1";
					$banderatr=0;
				}
				echo '<tr class="'.$trstyle.'">';
					echo'<td align="center" class="tablalistado_td" ><font size="-1">'.$row["nombre"],$row["id"].'</font></td>';
					echo'<td align="center"class="tablalistado_td"  ><font size="-1"><a href="modificarcaja.php?id='.$row["id"].'"><img src="images/edit.png" border="0" title="Modificar"/><input type="hidden" name="nombrecaja" value="nombre" /></a></font></td>
				</tr>';
			} while ($row = $rs->fetch_assoc());
			echo "</table><br/><br/><br/>";
		}else { 
			echo "<div align='center' class='mensajesistema'><br>¡No se han encontrado cajas con el criterio de búsqueda ingresado!</div><br/>"; 
		} 
	}
	echo'<br><form name="form" action="buscarcaja.php" method="POST" onSubmit="return valida();">';
	echo '<table align="center" width="200" border="0">
		  <tr>
			<td nowrap>Criterio de Búsqueda:</td>
			<td><input type="text" name="criterio" value="" size="55" class="campoform" /></td>
		  </tr>
		  <tr>
			<td></td>
			<td align="right"><font size="-2">* Puede buscar por Nombre o parte del mismo.</font>&nbsp;&nbsp;
			<input type="submit" class="botonform" value="Buscar"/></td>
		  </tr>
	      </table><br/><br/>';
		  echo'<input type="hidden" name="accion" value="buscar" />
	</form>';
	echo '<br><div><a class="boton" href="caja.php">Nueva Caja</a></div><br>';
	include "pie.php";
}else{
	echo '<SCRIPT LANGUAGE="javascript">
			location.href = "index.php";
			</SCRIPT>';
}
?>