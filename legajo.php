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
    	<td bgcolor="#717171" height="35"><div align="right" class="encabezado">LEGAJOS</div></td>
    </tr>
    <tr>
    	<td align="center" bgcolor="#FFFFFF">
	<?php
// function
//-------------------------------------------------------------------------------
	function AllowCreateUser($usuario, 	$password2, 
		$mail, $tipo, $idusuario){
		// VERIFICA SI YA EXISTE EL USUARIO
		include "conexion.php";
		$result2 = 'SELECT * FROM Sis_Usuarios Where Usuario=?';
		$stmt_usuarios = $conn->prepare($result2);
		if($stmt_usuarios === false) {
			trigger_error('Wrong SQL: ' . $result2 . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
		$stmt_usuarios->bind_param('s',$usuario);
		$stmt_usuarios->execute();
		$rs=$stmt_usuarios->get_result();
		if($row2 = $rs->fetch_assoc()){
			echo "<div align='center' class='mensajesistema'><br>Ya existe un usuario con ese Nombre, seleccione uno diferente.</div>";
		}else{	
			if($_SESSION['password']==$password2){
				$options = [
				'cost' => 10,
				'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
				];
				$_SESSION['password']=password_hash($_SESSION['password'], PASSWORD_BCRYPT, $options);
				$sql="INSERT INTO Sis_Usuarios (Id, Usuario, Password, Mail, Tipo, Id_Usu, Id_Persona) VALUES
				(?, ?, ?, ?, ?, ?, ?)";
				//die($sql);
				$stmt_insert = $conn->prepare($sql);
					if($stmt_insert === false) {
						trigger_error('Wrong SQL: ' . $sql_insert . ' Error: ' . $conn->error, E_USER_ERROR);
					}
					/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
					$idfirst=NULL;
					$stmt_insert->bind_param('isssiii',$idfirst, $usuario, $_SESSION['password'], $mail, $tipo, $idusuario,$_SESSION['iduser_save']);
					/* Execute statement */
					$stmt_insert->execute();
					$_SESSION['allow_iusuario']="";
					$_SESSION['iduser_save']="";
					echo "<div align='center' class='mensajesistema'><br>El Usuario Fue Creado Correctamente.</div>";
			}
		}// if($row2 = $rs->fetch_assoc()){ 
	}// function
	//-------------------------------------------------------------------------------
	//Nuevo Legajo
	if (isset($_POST['accion']) and $_POST['accion']=="guardar"){
		echo "lalalala";
		include "conexion.php";
		$result2 = 'SELECT * FROM sis_legajo Where Legajo=?';
		$stmt_legajos = $conn->prepare($result2);
		if($stmt_legajos === false) {
			trigger_error('Wrong SQL: ' . $result2 . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
		$stmt_legajos->bind_param('s',$legajo);
		$stmt_legajos->execute();
		$rs=$stmt_legajos->get_result();
		if($row2 = $rs->fetch_assoc()){
			
			echo "<div align='center' class='mensajesistema'><br>Ya existe un legajo en una caja, seleccione uno diferente.</div>";
		}else{	
			echo "lolololo";
			$nombre=$_POST["nombre"];
			$apellido=$_POST["apellido"];
			//

			$sql="INSERT INTO sis_legajo (id, apellido, nombre) VALUES
			(?,?, ?)";
			//die($sql);
			$stmt_insert = $conn->prepare($sql);
			if($stmt_insert === false) {
					trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
					}
			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
			//$nombre="fede2";
			//$apellido="se la come2";

			$idfirst=NULL;
			$stmt_insert->bind_param('iss',$idfirst,$apellido, $nombre);
			/* Execute statement */
				$stmt_insert->execute();
				$_SESSION['allow_iusuario']="";
				$_SESSION['iduser_save']="";
				echo "<div align='center' class='mensajesistema'><br>El Legajo se creo correctamente.</div>";
			}// if($row2 = $rs->fetch_assoc()){ 
	}
	?>
	<div align='center' class='subtitulo'><br>Nuevo Legajo:</div>
	<?php
		if(isset($_POST['nombre'])) {
			$set_name=$_POST['nombre'];
		}
		if(isset($_POST['mail'])) {
			$set_mail=$_POST['mail'];
		}
	?>
	<div id='mensaje_anular' align='center' class='mensajesistema'></div><br>
	<br><form name="form" action="legajo.php" method="POST" onSubmit="return valida();">
	<table align="center" width="200" border="0">
		<tr>
			<td nowrap>Caja:</td>
			<td><input type="text" id="s_caja" name="caja" value="" size="55" class="campoform" onblur="Settipo_ajaxlegajo()" /><span id="respuestaexiste_legajo"></span></td>
		</tr>
		<tr>
			<td nowrap>DNI:</td>
			<td><input type="text" id="s_dni" name="dni" value="" size="55" class="campoform"  onblur="Settipo_ajaxusuario()"  /><span id="respuestaexisteuser"></span></td>
		</tr>
		<tr>
			<td nowrap>Numero de Legajo:</td>
			<td><input type="text" id="s_legajo" name="legajo" value="" size="55" class="campoform"/></td>
		</tr>
		<tr>
			<td nowrap>Apellido:</td>
			<td><input type="text" id="s_apellido" name="apellido" value="" size="55" class="campoform"/></td>
		</tr>
		<tr>
			<td nowrap>Nombre:</td>
			<td><input type="text" id="s_nombre" name="nombre" value="" size="55" class="campoform"/></td>
		</tr>
		<tr>
			<td nowrap>Estado:</td>
			<td><select id="s_estado" name="estado" class="campoform">
			<option value="0">INACTIVA</option>
			<option value="1" selected="selected">ACTIVA</option>
		    </select></td>
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