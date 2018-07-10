<?php
session_start();
include "encabezado.php";
if (isset($_SESSION['Id_Usuario'])) {
	
	?>
	<script type="text/javascript">

	function changesex(stat) {
		if(stat=="Femenino"){
			document.getElementById("embarazadax").style.display="table-row";
			document.getElementById("puerperiox").style.display="table-row";
		}else{
			document.getElementById("embarazadax").style.display="none";
			document.getElementById("puerperiox").style.display="none";
		}
	}
	
  function valida(){

	  permitidos=/^([0-9])*$/;
	  permitidosmail=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

	  var mensaje_anular=document.getElementById("mensaje_anular");
	   mensaje_anular.innerHTML="";

	  
     if(document.form.dni.value=='') {
			document.form.dni.focus();
			mensaje_anular.innerHTML='Debe ingresar un DNI.';
			return false;
	  }
	   
	  if(!document.form.dni.value.match(permitidos)) {
		document.form.dni.focus();
		mensaje_anular.innerHTML='El DNI debe contener solo números.';
		return false;
	  }
  
	  

	if(document.form.allowlegajo.value==0) {
		document.form.allowlegajo.focus();
		 mensaje_anular.innerHTML='Ya Existe Una Persona Dada de Alta con ese Numero de Legajo.';
		return false;
	  } 


	  if(document.form.apellido.value=='') {
		document.form.apellido.focus();
		 mensaje_anular.innerHTML='Debe ingresar un Apellido.';
		return false;
	  } 

	  if(document.form.nombre.value=='')  {
		document.form.nombre.focus();
		mensaje_anular.innerHTML='Debe ingresar un Nombre.';
		return false;
	  } 

	 if(document.form.sexo.value=='Femenino') {
		if(document.form.embarazada.value=="1" && document.form.puerperio.value=="1"){
			mensaje_anular.innerHTML='Una persona de sexo femenino no puede estar embarazada y estar en período puerperio al mismo tiempo.';
			return false;
		}
	  } 

	 var value_calendar=document.getElementById("calendario").value;
		if (document.form.calendario.value==''){
			mensaje_anular.innerHTML='Debe ingresar una Fecha de Nacimiento.';
			return false;
		}

	  
	  if(document.form.dni.value!="" && document.form.sindni.checked){
	  		mensaje_anular.innerHTML='Si existe un número de DNI debe desceleccionar la opción sin DNI.';
		  return false;
	  }else{
		document.form.submit();
		return true;
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
	function UpdatePersona ($conn, $apellido, $nombre, $legajo , $dni , $caja ,$estado) {

		// FALTA CHEQUAR EL NUMERO DE LEGAJO.-
		  
				$sql_updatepersona='UPDATE id_legpersona SET Apellido=?, Nombre=?, Legajo=?, DNI=? , Caja=?, estado=?  WHERE Id=?';
				$stmt_update = $conn->prepare($sql_updatepersona);
				if($stmt_update === false) {
				trigger_error('Wrong SQL: ' . $sql_updatepersona . ' Error: ' . $conn->error, E_USER_ERROR);
				}
				/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
				$stmt_update->bind_param('ssiisii',$apellido, $nombre, $legajo, $dni , $caja ,$estado, $_SESSION['id_modificar']);
				/* Execute statement */
				$stmt_update->execute();
				echo "<div align='center' class='mensajesistema'><br>Los datos fueron Modificados Correctamente.</div><br/>";
				}

     //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
     //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
     //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

     // INSERTAR TIPO DE PERSONAl


	//-------------------------------------------------------------------------------
	//Actualizar DATOS PERSONALES PERSONAL
	if (isset($_POST['accion']) and $_POST['accion']=="actualizar"){

		$apellido=$_POST['apellido'];		
		$nombre=$_POST['nombre'];
		$legajo=$_POST['legajo'];
		$dni=$_POST['DNI'];
		$caja=$_POST['caja'];
		$estado=$_POST['estado'];
		include "conexion.php";
		//echo $sindni."<br>";
		if($sindni==0){
			$result2 = 'SELECT * FROM id_legpersona Where DNI=? AND Id!=?';
			$stmt_persona = $conn->prepare($result2);
			if($stmt_persona === false) {
				trigger_error('Wrong SQL: ' . $result2 . ' Error: ' . $conn->error, E_USER_ERROR);
			}
			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
			$stmt_persona->bind_param('ii',$dni,$_SESSION['id_modificar']);
			$stmt_persona->execute();
			$rs=$stmt_persona->get_result();
		if($row2 = $rs->fetch_assoc()){
				echo "<div align='center' class='mensajesistema'><br>Ya existe una persona con el mismo DNI, realize una busqueda para visualizarla.</div>";
			}else{	
			UpdatePersona($conn, $apellido, $nombre, $legajo , $dni , $caja ,$estado);
		}
		}else{
			UpdatePersona($conn, $apellido, $nombre, $legajo , $dni , $caja ,$estado);
	  }// if if($sindni==0){
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//Actualizar Agregar TIPO PERSONAL DISCIPLINA - MEDICO
	
	//------------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------
	//Eliminar Personal
	if (isset($_GET['accion']) and $_GET['accion']=="eliminarPersonal"){
		include "conexion.php";
		
		$set_idtp=$_GET['idtp'];

		$sql='DELETE FROM Id_Personaldisciplinas WHERE Id_Disciplina=?';
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

		echo "<div align='center' class='mensajesistema'><br>El tipo de Personal ha sido eliminado correctamente.</div>";

	}
	
	//-------------------------------------------------------------------------------
	//main

	if(isset($_GET['id']) && $_GET['id']!=""){
		$_SESSION['id_modificar']=$_GET['id'];
	}
	include "conexion.php";
	$result_main = 'SELECT * FROM id_legpersona Where Id=?';
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
		$_SESSION['Legajo']=$row['Legajo'];
		$_SESSION['Apellido']=$row['Apellido'];
		$_SESSION['Nombre']=$row['Nombre'];
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
          	<br><form name="form"  id="personaldata" action="modificarpersona.php" method="POST" onSubmit="return valida();">
				 <table align="center" width="200" border="0">
		   			<tr>
						<td nowrap>Caja:</td>
						<td><input type="text" name="caja" value="<?php echo $row['Caja'] ?>" size="55" class="campoform"/></td>
			  		</tr>
				     <tr>
						<td nowrap>DNI:</td>
						<td><input type="text" name="DNI" value="<?php echo $row['DNI'] ?>" size="55" maxlength="8" class="campoform"/></td>
				  	</tr>
				  	<tr>
					<tr>
						<td nowrap>Numero de Legajo:</td>
						<td><input type="text"  name="legajo" value="<?php echo $row['Legajo'] ?>" size="55" maxlength="20" class="campoform" /></td>
					</tr>
				 	<tr>
						<td nowrap>Apellido:</td>
						<td><input type="text" name="apellido" value="<?php echo $row['Apellido'] ?>" size="55" class="campoform" /></td>
					</tr>
						<tr>
						<td nowrap>Nombre:</td>
						<td><input type="text" name="nombre" value="<?php echo $row['Nombre'] ?>" size="55" class="campoform" /></td>
				  	</tr>

					<td nowrap>Estado:</td>
						<td><select name="estado" class="campoform">';
						<?php 
						//echo'<option value="0" selected="selected">'.$row['estado'].'</option>';
						if($row['estado']==0){
							echo'<option value="0" selected="selected">INACTIVA</option>';
						}else{
							echo'<option value="0">INACTIVA</option>';
						}
						if($row['estado']==1){
							echo'<option value="1" selected="selected">ACTIVA</option>';
						}else{
							echo'<option value="1">ACTIVA</option>';
						}
			 			?>
					</select></td>
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
		<input type="hidden" name="accion" value="actualizar" />
		</form><br/><br/>
	<?php
	} else { 
		echo "<div align='center' class='mensajesistema'><br>¡No se ha encontrado un Perfil de Tareas!</div>"; 
	} 
	?>
	<br><div ><a class="boton" href="buscarpersonas.php">Regresar a Buscar Caja</a></div><br><br><br>
	<?php
}
	echo '<script>DisplayCombos()</script>'; 
	include "pie.php";
?>