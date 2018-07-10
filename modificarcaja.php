<?php
session_start();
include "encabezado.php";
if (isset($_SESSION['Id_Usuario'])) {
	
	?>
	<script type="text/javascript">

	function valida(){

	  permitidos=/^([0-9])*$/;
	  permitidosmail=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

	  var mensaje_anular=document.getElementById("mensaje_anular");
	   mensaje_anular.innerHTML="";

	  if(document.form.nombre.value=='')  {
		document.form.nombre.focus();
		mensaje_anular.innerHTML='Debe ingresar un Nombre.';
		return false;
	  } 
	}
	</script>
	<script src="js/Ajaxdisciplinas.js"></script>
    <script src="js/Ajaxlocalidad.js"></script>
   	<tr>
      <td bgcolor="#717171" height="35"><div align="right" class="encabezado">MODIFICAR CAJA</div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
	<?php
	$sindni=0;
    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // INSERTAR TIPO DE PERSONAl
	//-------------------------------------------------------------------------------
	//Actualizar DATOS PERSONALES PERSONAL
	if (isset($_POST['accion']) and $_POST['accion']=="actualizarCaja"){

		include "conexion.php";
		$id_modificarcaja =$_POST['id_modificarcaja'];
		$nombrecaja =$_POST['nombrecaja'];
	//echo $id_modificarcaja.$nombrecaja."<br>";
		echo "<div align='center' class='mensajesistema'><br>Yentro a actualizar caja.</div>";
		$result2 = 'SELECT * FROM sis_caja Where nombre=?';
		$stmt_caja = $conn->prepare($result2);
		if($stmt_caja === false) {
				trigger_error('Wrong SQL: ' . $result2 . ' Error: ' . $conn->error, E_USER_ERROR);
			}

			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
			$stmt_caja->bind_param('s',$nombrecaja);
			$stmt_caja->execute();
			$rs3=$stmt_caja->get_result();

			echo "<div align='center' class='mensajesistema'><br>llego al if de update. ". $id_modificarcaja ."</div>";

			if($id_modificarcaja = $rs3->fetch_assoc()){
				echo "<div align='center' class='mensajesistema'><br>Ya existe una caja con el mismo nombre, realize una busqueda para visualizarla.</div>";
			}else{	
				echo "<div align='center' class='mensajesistema'><br>Yentro a update.ii". $_POST['nombrecaja'] ."ii</div>";
				$sql_updatecaja='UPDATE sis_caja SET nombre=?  WHERE id=?';
				$stmt_update = $conn->prepare($sql_updatecaja);
				if($stmt_update === false) {
					trigger_error('Wrong SQL: ' . $sql_updatecaja . ' Error: ' . $conn->error, E_USER_ERROR);
				}
				/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
				$stmt_update->bind_param('si',$nombrecaja, $id_modificarcaja );
				/* Execute statement */
				$stmt_update->execute();
				echo "<div align='center' class='mensajesistema'><br>Los datos fueron Modificados Correctamente.</div><br/>";
			}
	}
	//-------------------------------------------------------------------------------
	//Eliminar cAJA
	//-------------------------------------------------------------------------------
	if (isset($_GET['accion']) and $_GET['accion']=="eliminarCaja"){
		include "conexion.php";
		$set_idtp=$_GET['idtp'];
		$sql='DELETE FROM sis_caja WHERE Id_Disciplina=?';
		//die($sql);
		/* Prepare statement */
		$stmt_deletep = $conn->prepare($sql);
		if($stmt_deletep === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
		$stmt_deletep->bind_param('i',$set_idtp);
		/* Execute statement */
		$stmt_deletep->execute();
		$stmt_deletep->close();
		echo "<div align='center' class='mensajesistema'><br>La caja ha sido eliminada correctamente.</div>";
	}
	//-------------------------------------------------------------------------------
	//main
	//-------------------------------------------------------------------------------
	if(isset($_GET['id']) && $_GET['id']!=""){
		$_SESSION['id_modificar']=$_GET['id'];
	}
	include "conexion.php";
	$result_main = 'SELECT * FROM sis_caja Where id=?';
	$stmt_selectmain = $conn->prepare($result_main);
	if($stmt_selectmain === false) {
		trigger_error('Wrong SQL: ' . $result_main. ' Error: ' . $conn->error, E_USER_ERROR);
	}
	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
	$stmt_selectmain->bind_param('i',$_SESSION['id_modificar']);
	$stmt_selectmain->execute();
	$rs_selectmain=$stmt_selectmain->get_result();
	if($row=$rs_selectmain->fetch_assoc()){
		//echo $row['Id_Localidad'];
		$_SESSION['nombre']=$row['nombre'];
		?>
		<link rel="stylesheet" type="text/css" href="calendario/epoch_styles.css" /> 
		<script type="text/javascript" src="calendario/epoch_classes.js"></script> 
        <script type="text/javascript">
	        var popupcalendar, flatcalendar;
    	    window.onload = function() {
             /*get a handle on the containing elements for the 2 calendars*/
        	var popupElement = document.getElementById("calendario");
            var popupElement2 = document.getElementById("calendario2");
            /*Initialize the calendars*/
            popupcalendar = new Epoch("popupcal","popup",popupElement,false);
            popupcalendar2 = new Epoch("popupcal","popup",popupElement2,false);
            };
        </script>
        <br><form name="form"  id="personaldata" action="modificarcaja.php" method="POST" onSubmit="return valida();">
		<table align="center" width="200" border="0">
			<tr>
				<td nowrap>Nombre:</td>
				<td><input type="text" name="nombrecaja" value="<?php echo $row['nombre'] ?>" size="55" class="campoform" /></td>
		  		<td><input type="hidden" name="id_modificarcaja" value="<?php echo $_SESSION['id_modificar'] ?>"/></td>
		  	<td><input type="hidden" name="accion" value="actualizarCaja"/></td>
		  	</tr>
			</select> </td>
		  	</tr>
	       		<?php
				echo'</select></td>
				  </tr>
				  <tr>
					<td></td>
					<td align="right"><input type="submit" class="botonform" value="Actualizar"/></td>
				  </tr>
				</table>';
			//HTML------------------------------------------------------------		
		?>
		<input type="hidden" name="accion" value="actualizarCaja" />
		</form><br/><br/>
	<?php
	} else { 
		echo "<div align='center' class='mensajesistema'><br>¡No se ha encontrado un Perfil de Tareas!</div>"; 
	} 
	?>
	<br><div ><a class="boton" href="buscarcaja.php">Regresar a Buscar Caja</a></div><br><br><br>

	<?php
}
	echo '<script>DisplayCombos()</script>'; 
	include "pie.php";
?>