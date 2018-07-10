<?php
	session_start();
	include "encabezado.php";
	$set_name=null;
	$set_mail=null;
	//-----------------------------------------
	if (isset($_SESSION['Id_Usuario'])) {
?>
		<script  type="text/javascript">
		function valida(){
	  		permitidos=/[^0-9.]/;
	  		permitidosmail=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
  			var mensaje_anular=document.getElementById("mensaje_anular");
			mensaje_anular.innerHTML="";
		if(document.form.apellido.value=='') {
			document.form.apellido.focus();
			mensaje_anular.innerHTML='Debe ingresar un Apellido.';
			return false;
	  	} 
		if(document.form.nombre.value=='') {
			document.form.nombre.focus();
			mensaje_anular.innerHTML='Debe ingresar una Nombre.';
			return false;
	  	} 
		if(document.form.caja.value=='') {
			document.form.caja.focus();
			mensaje_anular.innerHTML='Debe ingresar un denominador de caja.';
			return false;
	  	}	 
		if(document.form.legajo.value!=document.form.legajo.value) {
			document.form.legajo.focus();
			mensaje_anular.innerHTML='Debe ingresar un legajo';
			return false;
	  	} 
		if(document.form.dni.value=='') {
			document.form.dni.focus();
			mensaje_anular.innerHTML='Debe ingresar un DNI.';
			return false;
	  	} 
	  	} else{
			document.form.submit();
			return true;
	 	}
	  	}
		</script>
	<tr>
    	<td bgcolor="#717171" height="35"><div align="right" class="encabezado">LEGAJOSCAJAS</div></td>
    </tr>
    <tr>
    	<td align="center" bgcolor="#FFFFFF">
	<?php
// function
//-------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------
	//Nueva Caja
	if (isset($_POST['accion']) and $_POST['accion']=="guardar"){
		include "conexion.php";
		$result2 = 'SELECT * FROM sis_caja Where nombre=?';
		$stmt_caja = $conn->prepare($result2);
		if($stmt_caja === false) {
			trigger_error('Wrong SQL: ' . $result2 . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
		$stmt_caja->bind_param('s',$caja);
		$stmt_caja->execute();
		$rs=$stmt_caja->get_result();
		if($row2 = $rs->fetch_assoc()){
			
			echo "<div align='center' class='mensajesistema'><br>Ya existe un legajo en una caja, seleccione uno diferente.</div>";
		}else{	
			$nombre=$_POST["nombre"];
			//
			$sql="INSERT INTO sis_caja (id, nombre) VALUES
			(?,?)";
			//die($sql);
			$stmt_insert = $conn->prepare($sql);
			if($stmt_insert === false) {
					trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
					}
			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
			//$nombre="fede2";
			//$apellido="se la come2";

			$idfirst=NULL;
			$stmt_insert->bind_param('is',$idfirst,$nombre);
			/* Execute statement */
				$stmt_insert->execute();
				$_SESSION['allow_iusuario']="";
				$_SESSION['iduser_save']="";
				echo "<div align='center' class='mensajesistema'><br>La caja se registro correctamente.</div>";
			}// if($row2 = $rs->fetch_assoc()){ 
	}
	?>
	<div align='center' class='subtitulo'><br>Nueva Caja:</div>
	<?php
		if(isset($_POST['nombre'])) {
			$set_name=$_POST['nombre'];
		}
	?>
	<div id='mensaje_anular' align='center' class='mensajesistema'></div><br>
	<br><form name="form" action="caja.php" method="POST" onSubmit="return valida();">
	<table align="center" width="200" border="0">
		<tr>
			<td nowrap>Nombre:</td>
			<td><input type="text" id="s_nombre" name="nombre" value="" size="55" class="campoform"/></td>
		</tr>

		<tr>
			<td></td>
			<td align="right"><input type="submit" class="botonform" value="Guardar"/></td>
		</tr>
	</table>
	<input type="hidden" name="accion" value="guardar" />
	<input type="hidden" id="tipo_oper" name="tipo" value="" />
	</form><br/><br/>
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
	<script src="js/ajaxexistelegajouser.js"></script>
	<script src="js/ajaxexisteusuario.js"></script>
<?php
	include "pie.php";
	}else{
		echo '<SCRIPT LANGUAGE="javascript">
		location.href = "index.php";
		</SCRIPT>';
	}
?>