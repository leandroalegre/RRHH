<?php
session_start();
include "encabezado.php";
if (isset($_SESSION['Id_Usuario'])) {
	
?>
	
	<script type="text/javascript">
	
	function valida(){
	   var mensaje_anular=document.getElementById("mensaje_anular");
	   mensaje_anular.innerHTML="";

	  permitidos=/^([0-9])*$/;
	  permitidosmail=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	  
	  if(document.form.criterio.value=='') {
		 document.form.criterio.focus();
		 mensaje_anular.innerHTML="Debe ingresar un Criterio de Busqueda (Nombre, Apellido o DNI).";
		return false;
	  } else {
		document.form.submit();
		return true;
	  }
	}
	</script>
	<tr>
      <td bgcolor="#717171" height="35"><div align="right" class="encabezado">BUSQUEDA DE LEGAJO</div></td>
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
		echo "<div align='center' class='subtitulo'><br>Listado de Personas bajo el criterio de búsqueda: ".$criterio."</div><br>";
		 
		include "conexion.php";
		
		//$result = 'SELECT * FROM Sis_Personas WHERE  (Nombre Like ? OR Apellido Like ? OR Mail=? OR DNI=? ) AND (Set_Historial=?) ORDER BY Nombre';
		$result = 'SELECT * FROM id_legpersonas WHERE   (Nombre Like ? OR Apellido like ? OR Mail like ? OR TelefonoFijo Like ? OR Cel1 Like ? OR Cel2 Like ? OR DNI like ?) AND (Set_Historial=?) ORDER BY Nombre';

			$stmt = $conn->prepare($result);

			if($stmt === false) {
				trigger_error('Wrong SQL: ' . $result . ' Error: ' . $conn->error, E_USER_ERROR);
			}

			$criterio_final="%".$criterio."%";
			$set_historial=1;

			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
			$stmt->bind_param('sssssssi',$criterio_final,$criterio_final,$criterio_final,$criterio_final,$criterio_final ,$criterio_final, $criterio_final, $set_historial);
			//$stmt->bind_param('sssii',$criterio_final, $criterio_final, $criterio, $criterio, $set_historial);
			$stmt->execute();

			$rs=$stmt->get_result();


		if($row=$rs->fetch_assoc()){
			?>
			<table align="center" width="80%" cellpadding="0" cellspacing="0" class="tablalistado_principal">
			<tr>
			<td align="center" class="tablalistado_encabezado" >Apellido</td>
			<td align="center" class="tablalistado_encabezado" >Nombre</td>
			<td align="center" class="tablalistado_encabezado" >Nacimiento</td>
			<td align="center" class="tablalistado_encabezado" >Edad</td>
			<td align="center" class="tablalistado_encabezado" >DNI</td>
			<td align="center" class="tablalistado_encabezado" >&nbsp;</td>
			</tr>
			<?php

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
				
				if($row["DNI"]==0){
					$set_dni="Sin DNI";
				} else{
					$set_dni=$row["DNI"];
				}

				echo '<tr class="'.$trstyle.'">';
				echo'<td align="center" class="tablalistado_td"><font size="-1">'.$row["Apellido"].'</font></td>
				<td align="center" class="tablalistado_td" ><font size="-1">'.$row["Nombre"].'</font></td>';
				$fecnac=$row['Fecha_Nac'];
				$dd=explode('-',$fecnac);
				$fecnac=$dd[2]."/".$dd[1]."/".$dd[0];
				echo'<td align="center" class="tablalistado_td" ><font size="-1">'.$fecnac.'</font></td>';
				$fecnac=$row['Fecha_Nac'];
				include "calculaedad.php";
				$edad=$anos. " años y ".$meses." meses";
				echo'<td align="center" class="tablalistado_td"><font size="-1">'.$edad.'</font></td>';
				echo'<td align="center" class="tablalistado_td"><font size="-1">'.$set_dni.'</font></td>
				<td align="center"class="tablalistado_td"  ><font size="-1"><a href="modificarpaciente.php?id='.$row["Id"].'"><img src="images/edit.png" border="0" title="Modificar"/></a></font></td>
				</tr>';
			
			} while ($row = $rs->fetch_assoc());
			echo "</table><br/><br/><br/>";
		} else { 
			echo "<div align='center' class='mensajesistema'><br>¡No se han encontrado personas con el criterio de búsqueda ingresado!</div><br/>"; 
		} 
	
	
	}
	?>	
		<br>
        <div id='mensaje_anular' align='center' class='mensajesistema'></div><br><br>

	 <br><form name="form" action="buscarcaja.php" method="POST" onSubmit="return valida();">
		<table align="center" width="200" border="0">
			<tr>
				<td nowrap>Criterio de Búsqueda:</td>
				<td><input type="text" name="criterio" value="" size="55" class="campoform" /></td>
			</tr>
		 	<tr>
				<td></td>
			<td align="right"><font size="-2">* Puede buscar por Nombre, Apellido, Legajo o DNI.</font>&nbsp;&nbsp;
			<input type="submit" class="botonform" value="Buscar"/></td>
		 </tr>
		</table><br/><br/>
		<input type="hidden" name="accion" value="buscar" />
	</form>
	
	<br><div><a class="boton" href="nuevolegajo.php">Nuevo Legajo</a></div><br><br><br>
<?php
	include "pie.php";
}else{
	
	
	echo '<SCRIPT LANGUAGE="javascript">
			location.href = "index.php";
			</SCRIPT>';
}


?>

