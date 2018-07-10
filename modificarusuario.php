<?php
session_start();
include "encabezado.php";
//-----------------------------------------
//Java
echo '<SCRIPT  type="text/javascript">
	function valida(){
	  permitidos=/[^0-9.]/;
	  permitidosmail=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	  
	  if(document.form.nombre.value==\'\') {
		document.form.nombre.focus();
		alert(\'Debe ingresar un Nombre.\');
		return false;
	  } 
	  if(document.form.mail.value==\'\') {
		document.form.mail.focus();
		alert(\'Debe ingresar un Email.\');
		return false;
	  } 
	  if(!document.form.mail.value.match(permitidosmail))  {
		document.form.mail.focus();
		alert(\'Debe ingresar un Email valido.\');
		return false;
	  }
	  if(document.form.tipo.value==\'1\' && document.form.centro.value!=\'0\')  {
		document.form.centro.focus();
		alert(\'Un Usuario administrador no debe pertenecer a ningun centro de vacunación.\');
		return false;
	  } 
	  if(document.form.tipo.value==\'2\' && document.form.centro.value==\'0\')  {
		document.form.centro.focus();
		alert(\'Un Usuario normal debe pertenecer a un centro de vacunación.\');
		return false;
	  } 
	  if(document.form.tipo.value==\'3\' && document.form.centro.value!=\'0\')  {
		document.form.centro.focus();
		alert(\'Un Usuario simple no debe pertenecer a ningun centro de vacunación.\');
		return false;
	  }   else  {
		document.form.submit();
		return true;
	  }
	}
	
	</SCRIPT>';

if (isset($_SESSION['Id_Usuario'])) {
	
	//TITULO
	?>
	<tr>
      <td bgcolor="#717171" height="35"><div align="right" class="encabezado">MODIFICAR USUARIO</div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">	
	<?php
	
	//-------------------------------------------------------------------------------
	//Actualizar
	if (isset($_POST['accion']) and $_POST['accion']=="actualizar"){
		
		$idusuario=$_POST['idusuario'];
	
		$usuario=$_POST['usuario'];
		$mail=$_POST['mail'];
		$tipo=$_POST['tipo'];
		
		//$idusuario=$_SESSION["Id_Usuario"];
		
		include "conexion.php";
		$result2 = 'SELECT * FROM Sis_Usuarios Where Usuario=? AND Id!=?';
		
		$stmt = $conn->prepare($result2);
			if($stmt === false) {
				trigger_error('Wrong SQL: ' . $result2 . ' Error: ' . $conn->error, E_USER_ERROR);
			}
			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
			$stmt->bind_param('si',$usuario,$idusuario);
			$stmt->execute();

			$rs=$stmt->get_result();

		if($row2= $rs->fetch_assoc()){

			echo "<div align='center' class='mensajesistema'><br>Ya existe un usuario con el mismo nombre de usuario, seleccione uno diferente.</div>";
		}else{	
		
		include "conexion.php";
		$sql='UPDATE Sis_Usuarios SET  Usuario=?, Mail=?, Tipo=? WHERE Id=?';
		//die($sql);

		$stmt_updateuser = $conn->prepare($sql);
		if($stmt_updateuser === false) {
			trigger_error('Wrong SQL: ' . $sq . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
		
		$stmt_updateuser->bind_param('ssii', $usuario, $mail, $tipo, $idusuario);

		/* Execute statement */
		$stmt_updateuser->execute();

		echo "<div align='center' class='mensajesistema'><br>Los datos fueron actualizados correctamente.</div>";
	}
	}
	
	
	
	//-------------------------------------------------------------------------------
	//main
	$id=$_GET['id'];
	
	include "conexion.php";
	$result = 'SELECT * FROM Sis_Usuarios Where Id=?';


		$stmt_usuarios = $conn->prepare($result);

		if($stmt_usuarios === false) {
		trigger_error('Wrong SQL: ' . $result . ' Error: ' . $conn->error, E_USER_ERROR);
		}

		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
		$stmt_usuarios->bind_param('i',$id);
		$stmt_usuarios->execute();

		$rs=$stmt_usuarios->get_result();

		if($row = $rs->fetch_assoc()){

			echo'<br><form name="form" action="modificarusuario.php?id='.$id.'" method="POST" onSubmit="return valida();">';
			echo '<table align="center" width="200" border="0">
				   <tr>
					<td nowrap>Usuario:</td>
					<td><input type="text" id="s_user" name="usuario" value="'.$row['Usuario'].'" size="55" class="campoform" onblur="Settipo_ajaxusuario()" /><span id="respuestaexisteuser"></span></td>
				  </tr>
				  <tr>
					<td nowrap>E-mail:</td>
					<td><input type="text" name="mail" value="'.$row['Mail'].'" size="55" class="campoform"/></td>
				  </tr>
				  <tr>
					<td nowrap>Tipo de Usuario:</td>
					<td><select name="tipo" class="campoform">';
						if($row['Tipo']==1){
							echo'<option value="1" selected="selected">Administrador</option>';
						}else{
							echo'<option value="1">Administrador</option>';
						}
						if($row['Tipo']==2){
							echo'<option value="2" selected="selected">Normal</option>';
						}else{
							echo'<option value="2">Operador</option>';
						}
					echo'</select></td>
				  </tr>
				  <tr>
					<td></td>
					<td align="right"><input type="submit" class="botonform" value="Actualizar"/></td>
				  </tr>
				</table>';
			
			
			echo'<input type="hidden" name="accion" value="actualizar" />
			<input type="hidden" name="idusuario" value="'.$id.'" />
			</form><br/><br/>';
			
			echo '<br><div><a  class="boton" href="modificarpass.php?id='.$id.'">Cambiar Contraseña</a></div><br><br/>';
			
	}else{
		echo "<div align='center' class='mensajesistema'><br>¡No se han encontrado los datos del Usuario!</div>"; 
	}
	echo '<script src="js/ajaxexisteusuario.js"></script>';
	include "pie.php";
}else{
	echo '<SCRIPT LANGUAGE="javascript">
			location.href = "index.php";
			</SCRIPT>';
}

?>