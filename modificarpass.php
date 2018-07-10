<?php
session_start();
	include "encabezado.php";
if (isset($_SESSION['Usuario'])) {

	?>

	<script type="text/javascript">
	function valida() {
	  permitidos=/[^0-9.]/;
	  permitidosmail=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	  
	  if(document.form.usuario.value=='') {
		document.form.usuario.focus();
		alert('Debe ingresar un Usuario.');
		return false;
	  } 
	  if(document.form.password.value=='') {
		document.form.password.focus();
		alert('Debe ingresar una Contraseña.');
		return false;
	  } 
	  if(document.form.password2.value=='') {
		document.form.password2.focus();
		alert('Debe repetir la Contraseña.');
		return false;
	  } 
	  if(document.form.password.value!=document.form.password2.value) {
		document.form.password.focus();
		alert('Las Contaseñas no son iguales.');
		return false;
	  } else {
		document.form.submit();
		return true;
	  }
	}
	
	</script>



	<tr>
      <td bgcolor="#717171" height="35"><div align="right" class="encabezado">MODIFICAR PASSWORD</div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
	<?php
	
	//-------------------------------------------------------------------------------
	//Actualizar
	if (isset($_POST['accion']) and $_POST['accion']=="actualizar"){
		
		$idusuario=$_POST['idusuario'];
		$usuario=$_POST['usuario'];
		$_SESSION['password']=$_POST['password'];
		$_SESSION['password2']=$_POST['password2'];
		//$idusuario=$_SESSION["Id_Usuario"];
		
		if($_SESSION['password']===$_SESSION['password2']){
		$options = [
			'cost' => 10,
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
			];
			
		$_SESSION['password']=password_hash($_SESSION['password'], PASSWORD_BCRYPT, $options);
		
		include "conexion.php";
		$sql='UPDATE Sis_Usuarios SET Password=? WHERE Id=? And Usuario=?';
		//die($sql);
		
		$stmt_update = $conn->prepare($sql);
		if($stmt_update === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
		$stmt_update->bind_param('sis',$_SESSION['password'],$idusuario,$usuario);

		/* Execute statement */
		$stmt_update->execute();
		echo "<div align='center' class='mensajesistema'><br>Los datos fueron actualizados correctamente.</div>";

		}
	}
	
	//-------------------------------------------------------------------------------
	//main
	if(isset($_GET['id']) && $_GET['id']!= ""){
		$id=$_GET['id'];
	}
	
	
	include "conexion.php";
	$result = 'SELECT * FROM Sis_Usuarios Where Id=?';
	
		$stmt = $conn->prepare($result);
			if($stmt === false) {
				trigger_error('Wrong SQL: ' . $result . ' Error: ' . $conn->error, E_USER_ERROR);
			}
			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
			$stmt->bind_param('i',$id);
			$stmt->execute();

			$rs=$stmt->get_result();

		if($row= $rs->fetch_assoc()){
		?>
			<br><form name="form" action="modificarpass.php?id=<?php echo $id ?>" method="POST" onSubmit="return valida();">
			<table align="center" width="200" border="0">
				  
				  <tr>
					<td nowrap>Usuario:</td>
					<td><?php echo  $row['Usuario'] ?></td>
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
					<td></td>
					<td align="right"><input type="submit" class="botonform" value="Actualizar"/></td>
				  </tr>
				</table>
			
			
			<input type="hidden" name="accion" value="actualizar" />
			<input type="hidden" name="idusuario" value="<?php echo $id ?>" />
			<input type="hidden" name="usuario" value="<?php echo $row['Usuario'] ?>" />
			</form><br/><br/>
		<?php	
	}else{
		?>
		<div align='center' class='mensajesistema'><br>¡No se han encontrado los datos del Usuario!</div>
		<?php
	}
	?>
	<br><div ><a class="boton" href="modificarusuario.php?id=<?php echo $id ?>">Regresar a Modificar Usuario</a></div><br><br>
	<?php
	include "pie.php";

}else{
	
	echo '<SCRIPT LANGUAGE="javascript">
			location.href = "index.php";
			</SCRIPT>';
}
?>