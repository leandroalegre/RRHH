<?php
session_start();
if (isset($_SESSION['Id_Usuario'])) {
	include "encabezado.php";
?>

<script type="text/javascript">

  function valida(){

	  permitidos=/^([0-9])*$/;
	  permitidosmail=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

	  var mensaje_anular=document.getElementById("mensaje_anular");
	   mensaje_anular.innerHTML="";
	
		var check_legajo=document.getElementById("s_numerolegajo").value;
	

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

	  if(!document.form.s_numerolegajo.value.match(permitidos)) {
		document.form.s_numerolegajo.focus();
		mensaje_anular.innerHTML='El Legajo Solo debe Contener Solo Números.';
		var capa_legajo=document.getElementById("respuestaexiste_legajo");
		capa_legajo.innerHTML="";
		return false;
	  }
  
 	if(document.form.s_numerolegajo.value==""){
 		document.form.s_numerolegajo.focus();
		var capa_legajo=document.getElementById("respuestaexiste_legajo");
		capa_legajo.innerHTML="";
		mensaje_anular.innerHTML="Debe Ingresar Un Numero de Legajo";
		return false
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
	
	<tr>
      <td bgcolor="#717171" height="35"><div align="right" class="encabezado">NUEVO LEGAJO</div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
	<?php

	function InsertLegajo ($conn, $apellido, $nombre, $Legajo, $dni, $caja) {

		$sql_insertlegajo='INSERT INTO id_legpersona (Id, Nombre, Apellido, Legajo,dni,caja) VALUES
		(?, ? ,? , ?, ?, ?)';

		$stmt_insert = $conn->prepare($sql_insertlegajo);
		if($stmt_insert === false) {
		trigger_error('Wrong SQL: ' . $sql_insertlegajo . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
		$idfirst=NULL;
		$stmt_insert->bind_param('issiis',$idfirst, $nombre, $apellido, $Legajo, $dni, $caja);

		/* Execute statement */
		$stmt_insert->execute();

		echo "<div align='center' class='mensajesistema'><br>Los datos fueron agregados correctamente.</div><br/>";
     }
     //-------------------------------------------------------------------------------------------------------------------------------------------------------
	 // PARA HACER UPDATE PERSONA  SI NO ESTA REGISTRADA EN LA BASE DE DATOS CON EL DNI
	function UpdateLegajo ($conn, $apellido, $nombre, $legajo , $dni , $caja ,$estado) {

		// FALTA CHEQUAR EL NUMERO DE LEGAJO.-
		  		$estado="INACTIVO"
				$sql_updatepersona='UPDATE id_legpersona SET Apellido=?, Nombre=?, Legajo=?, DNI=? , Caja=?, Estado=?  WHERE Id=?';
				$stmt_update = $conn->prepare($sql_updatepersona);
				if($stmt_update === false) {
				trigger_error('Wrong SQL: ' . $sql_updatepersona . ' Error: ' . $conn->error, E_USER_ERROR);
				}
				/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
				$stmt_update->bind_param('ssiissi',$apellido, $nombre, $legajo, $dni , $caja ,$estado, $_SESSION['id_modificar']);
				/* Execute statement */
				$stmt_update->execute();
				echo "<div align='center' class='mensajesistema'><br>Los datos fueron Modificados Correctamente.</div><br/>";
				}
	//-------------------------------------------------------------------------------
	//Actualizar
	if (isset($_POST['accion']) and $_POST['accion']=="guardar"){

		$apellido=$_POST['apellido'];		
		$nombre=$_POST['nombre'];
		$legajo=$_POST['legajo'];
		$dni=$_POST['dni'];
		$caja=$_POST['caja'];
		$estado="INACTIVO";
		$result2 = 'INSERT INTO id_legpersona (Nombre, Apellido, Legajo, DNI, Caja, Estado) VALUES
		(?, ? ,? , ?, ?, ?)';
		echo $result2;
		echo $apellido;
		$stmt_persona = $conn->prepare($result2);
		echo $stmt_persona;
		if($stmt_persona === false) {
			trigger_error('Wrong SQL: ' . $result2 . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
		$stmt_persona->bind_param('ssiis',$apellido, $nombre, $legajo , $dni , $caja ,$estado);
		$stmt_persona->execute();
		$rs=$stmt_persona->get_result();
		echo "<div align='center' class='mensajesistema'><br>Datos Modificados.</div>";

		}// POST
	
//-------------------------------------------------------------------------------------------------------------------------------------------
	?>
     <br><br>
		<div id='mensaje_anular' align='center' class='mensajesistema'></div><br><br>
	 <div align='center' class='subtitulo'><br>Alta de Legajos:</div>
		<br><form name="form" action="personas.php" method="POST" onSubmit="return valida();">
		<table align="center" width="200" border="0">
		 <tr>
			  <tr>
				<td nowrap>Caja:</td>
				<td><input type="text" id="s_caja" name="caja" value="" size="55" class="campoform"/></td>
			  </tr>
			  <tr>
				<td nowrap>DNI:</td>
				<td><input type="text" id="s_dni" name="dni" value="" size="55" class="campoform"/></td>
			  </tr>
			  <tr>
				<td nowrap>Legajo:</td>
				<td><input type="text" id="s_legajo" name="legajo" value="" size="55" class="campoform"/></td>
			  </tr>
			  <tr>
				<td nowrap>Apellido:</td>
				<td><input type="text" id="s_apellido" name="apellido" value="" size="55" class="campoform"/></td>
			  </tr>
			  <tr>
				<td nowrap>Nombre:</td>
				<td><input type="text"   id="s_nombre" name="nombre" value="" size="55" class="campoform"/></td>
			  </tr>
			<tr>
				<td></td>
				<td align="right"><input type="submit" class="botonform" value="Guardar"/></td>
			</tr>
			</table>

		<input type="hidden" name="accion" value="guardar" />
		
		</form>
		</br></br>
	 <div ><a class="boton" href="buscarpersonas.php">Buscar Legajos</a></div><br><br><br>
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
		<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
		<script src="js/Ajaxlocalidad.js"></script>
		<script src="js/ajaxexistsdnipersonas.js"></script>
		<script src="js/ajaxexistelegajopersonas.js"></script>
	<?php
	include "pie.php";
}else{
	
	
	echo '<SCRIPT LANGUAGE="javascript">
			location.href = "index.php";
			</SCRIPT>';
}
?>