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

	  if(document.form.usuario.value=='') {
		document.form.usuario.focus();
		mensaje_anular.innerHTML='Debe ingresar un Usuario.';
		return false;
	  } 

	  if(document.form.password.value=='') {
		document.form.password.focus();
		mensaje_anular.innerHTML='Debe ingresar una Contraseña.';
		return false;
	  } 

	  if(document.form.password2.value=='') {
		document.form.password2.focus();
		mensaje_anular.innerHTML='Debe repetir la Contraseña.';
		return false;
	  } 

	  if(document.form.password.value!=document.form.password2.value) {
		document.form.password.focus();
		mensaje_anular.innerHTML='Las Contaseñas no son iguales';
		return false;
	  } 

	  if(document.form.mail.value=='') {
		document.form.mail.focus();
		mensaje_anular.innerHTML='Debe ingresar un Email.';
		return false;
	  } 

	  if(!document.form.mail.value.match(permitidosmail)) {
		document.form.mail.focus();
		mensaje_anular.innerHTML='Debe ingresar un Email valido';
		return false;
	  } else{
		document.form.submit();
		return true;
	 }
	  
	}
	</script>
	

	<tr>
      <td bgcolor="#717171" height="35"><div align="right" class="encabezado">USUARIOS</div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
	<?php
	
	//-------------------------------------------------------------------------------
	//Nuevo Usuario


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



	if (isset($_POST['accion']) and $_POST['accion']=="guardar"){
		
			$usuario=$_POST['usuario'];
			$_SESSION['password']=$_POST['password'];
			$password2=$_POST['password2'];
			$mail=$_POST['mail'];
			$tipo=$_POST['tipo'];
			$idusuario=$_SESSION["Id_Usuario"];
		


		if($_SESSION['allow_iusuario']!="NotPersonalx22"){

			include "conexion.php";
			// VERIFICA SI YA LA PERSONA YA  TIENE UN USUARIO

			$result_p = 'SELECT * FROM Sis_Usuarios Where Id_Persona=?';

			$stmt_p  = $conn->prepare($result_p);

			if($stmt_p === false) {
				trigger_error('Wrong SQL: ' . $result_p . ' Error: ' . $conn->error, E_USER_ERROR);
			}


			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
			$stmt_p->bind_param('i',$_SESSION['iduser_save']);
			$stmt_p->execute();

			$rs_p=$stmt_p->get_result();


			if($rowp = $rs_p->fetch_assoc()){
	?>
					<div align='center' class='mensajesistema'><br>Ya existe una Persona Registrada con un Usuario.</div>
	<?php
			}else{ 
				AllowCreateUser($usuario,$password2, 
					$mail, $tipo, $idusuario);
			}
			}else{
	?>
			 <div align='center' class='mensajesistema'><br><span style='color: #f3661f'>El Personal No esta Dado de Alta. Haga Click <a href='personal.php'>AQUI</a> para Registrarlo</span></div>
	<?php	
		}

	
	}	// POST

	?>
		<div align='center' class='subtitulo'><br>Nuevo Usuario:</div>
	<?php
		if(isset($_POST['nombre'])) {
			$set_name=$_POST['nombre'];
		}

		if(isset($_POST['mail'])) {
			$set_mail=$_POST['mail'];
		}
	?>
		<div id='mensaje_anular' align='center' class='mensajesistema'></div><br>
		<br><form name="form" action="usuarios.php" method="POST" onSubmit="return valida();">
		<table align="center" width="200" border="0">
		<tr>
			<td nowrap>Nro de Legajo:</td>
			<td><input type="text" id="s_numerolegajo" name="nlegajo" value="" size="55" class="campoform" onblur="Settipo_ajaxlegajo()" /><span id="respuestaexiste_legajo"></span></td>
		</tr>
		<tr>
			<td nowrap>Usuario:</td>
			<td><input type="text" id="s_user" name="usuario" value="" size="55" class="campoform"  onblur="Settipo_ajaxusuario()"  /><span id="respuestaexisteuser"></span></td>
		</tr>
		<tr>
			<td nowrap>Contraseña:</td>
			<td><input type="password" name="password" value="" size="55" class="campoform"/></td>
		</tr>
		<tr>
			<td nowrap>Repetir Contraseña:</td>
			<td><input type="password" name="password2" value="" size="55" class="campoform"/></td>
		</tr>
		<tr>
			<td nowrap>E-mail:</td>
			<td><input type="text" name="mail" value="" size="55" class="campoform"/></td>
		</tr>
		<tr>
			<td nowrap>Tipo de Usuario:</td>
			<td><select id="s_sistemaoperador" name="sisoperator" class="campoform">
				<option value="1">Administrador</option>
				<option value="2" selected="selected">Operador</option>
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