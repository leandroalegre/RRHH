<?php
session_start();
include "encabezado.php";
if (isset($_SESSION['Id_Usuario'])) {
	
	?>
	
	<script  type="text/javascript">
	function valida(){
	  permitidos=/[^0-9.]/;
	  permitidosmail=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	  
	  if(document.form.nombre.value=='') {
		document.form.nombre.focus();
		alert('Debe ingresar un Nombre.');
		return false;
	  } else{
		document.form.submit();
		return true;
	  }
	}
	</script>


	<tr>
      <td bgcolor="#717171" height="35"><div align="right" class="encabezado">DISCIPLINA</div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
	<?php
	//-------------------------------------------------------------------------------
	//Actualizar
	if (isset($_POST['accion']) and $_POST['accion']=="ActualizarDisciplina"){

	$iddisciplina=$_POST['iddisciplina'];
	$desc_disciplina=$_POST['disciplina'];
	

	include "conexion.php";

	$sql_updade="UPDATE Sis_Disciplinas SET Tipo_Disciplina=? WHERE Id=?";

	$stmt_updade = $conn->prepare($sql_updade);

	if($stmt_updade === false) {
	trigger_error('Wrong SQL: ' . $sql_updade . ' Error: ' . $conn->error, E_USER_ERROR);
	}
	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	
	$stmt_updade->bind_param('si',$desc_disciplina, $iddisciplina);

	/* Execute statement */
	$stmt_updade->execute();
	echo "<div align='center' class='mensajesistema'><br>Los datos fueron Modificados Correctamente.</div>";
	}
	
		//Eliminar 
		if (isset($_GET['id']) and $_GET['id']!=""){
			$iddisciplina=$_GET['id'];
		}
	

		include "conexion.php";
		$result = 'SELECT * FROM Sis_Disciplinas WHERE Id=?';

		$stmt_getdisciplina = $conn->prepare($result);

		if($stmt_getdisciplina === false) {
			trigger_error('Wrong SQL: ' . $result . ' Error: ' . $conn->error, E_USER_ERROR);
		}
			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
		$stmt_getdisciplina->bind_param('i',$iddisciplina);
		$stmt_getdisciplina->execute();
		$rs=$stmt_getdisciplina->get_result();
			
		if($row_disciplina = $rs->fetch_assoc()){
	?>

	
	<div align='center' class='subtitulo'><br>Modificar Disciplina:</div>
		<br><form name="form" action="modificardisciplinas.php" method="POST" onSubmit="return valida();">
		<table align="center" width="200" border="0">
			  <tr>
				<td nowrap>Nombre:</td>
				<td><input type="text" name="disciplina" value=" <?php echo $row_disciplina['Tipo_Disciplina'] ?>" size="55" class="campoform"/></td>
			  </tr>
			 
			  <tr>
				<td></td>
				<td align="right"><input type="submit" class="botonform" value="Guardar"/></td>
			  </tr>
			</table>
		<input type="hidden" name="accion" value="ActualizarDisciplina"/>
		<input type="hidden" name="iddisciplina" value="<?php echo $row_disciplina['Id'] ?>"/>
		</form><br/><br/><br/><br/>
		<div ><a class="boton" href="disciplinas.php">Nueva Disciplinas</a></div><br>
		<?php
	} else { 
		?>
		<div align='center' class='mensajesistema'><br>¡No se han encontrado Disciplinas!</div><br><br>
		<?php
	} 	
	include "pie.php";
}else{
	echo '<SCRIPT LANGUAGE="javascript">
			location.href = "index.php";
			</SCRIPT>';
}

?>