<?php
session_start();
	include "encabezado.php";
$set_name=null;
$set_mail=null;

if (isset($_SESSION['Id_Usuario'])) {

	//TITULO
	?>
	<tr>
      <td bgcolor="#717171" height="35"><div align="right" class="encabezado">USUARIOS</div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
	<?php
	//-------------------------------------------------------------------------------
	//listado
	echo "<div align='center' class='subtitulo'><br>Listado de Usuarios:</div><br>";
	 
	include "conexion.php";
	$result = 'SELECT * FROM Sis_Usuarios ORDER BY Usuario';
	
	$stmt_usuarios = $conn->prepare($result);

	if($stmt_usuarios === false) {
	trigger_error('Wrong SQL: ' . $result . ' Error: ' . $conn->error, E_USER_ERROR);
	}
	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
	//$stmt_persona->bind_param('i',$dni);
	$stmt_usuarios->execute();

	$rs=$stmt_usuarios->get_result();


	if($row = $rs->fetch_assoc()){
		?>
		<table align="center" width="80%" cellpadding="0" cellspacing="0" class="tablalistado_principal">
		<tr>
		<td align="left" class="tablalistado_encabezado">Tipo User</td>
		<td align="left" class="tablalistado_encabezado">Usuario</td>
		<td align="left" class="tablalistado_encabezado">E-Mail</td>
		<td align="left" class="tablalistado_encabezado">Modificar Usuario</td>
		<td align="left" class="tablalistado_encabezado">Modificar Pasword</td>
		</tr>
		<?php
		$banderabgc=0;
		do {
			//controlo el color de fondo de la tabla
			if ($banderabgc==0){
				$bgctabla="#FFFFFF";
				$banderabgc=1;
			}else{
				$bgctabla="#d1f4fd";
				$banderabgc=0;
			}

			if($row['Tipo']==1){
				$set_tipouser="Adm";
			}else {
				$set_tipouser="Oper";
			}


			?>
			<tr>
			<td align="left" bgcolor="<?php echo $bgctabla ?>"><font size="-1"><?php echo  $set_tipouser ?></font></td>
			<td align="left" bgcolor="<?php echo $bgctabla ?>"><font size="-1"><?php echo  $row["Usuario"] ?></font></td>
			<td align="left" bgcolor="<?php echo $bgctabla ?>"><font size="-1"><?php echo $row["Mail"] ?></font></td>
			<td align="left" bgcolor="<?php echo $bgctabla ?>"><font size="-1"><a href="modificarusuario.php?id=<?php echo $row['Id'] ?>"><img src="images/edit.png" border="0" title="Modificar"/></a></font></td>
			<td align="left" bgcolor="<?php echo $bgctabla ?>"><font size="-1"><a href="modificarpass.php?id=<?php echo $row['Id'] ?>"><img src="images/edit.png" border="0" title="Modificar"/></a></font></td>
			</tr>
		<?php
		} while ($row = $rs->fetch_assoc());
		?>
		</table><br/><br/><br/><br/><br/>
		<?php
	} else { 
		?>
		<div align='center' class='mensajesistema'><br>¡No se han encontrado usuarios!</div>
		<?php
	} 
	
	include "pie.php";
}else{
	echo '<SCRIPT LANGUAGE="javascript">
			location.href = "index.php";
			</SCRIPT>';
}
?>