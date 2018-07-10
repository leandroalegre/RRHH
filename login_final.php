<?php
session_start();
include "conexion.php";
if(trim($_POST["usuario"])!= "" && trim($_POST["password"]) != ""){
	
	$usuario = htmlentities($_POST["usuario"], ENT_QUOTES);
	$password = $_POST["password"];
	
	$result="SELECT * FROM Sis_Usuarios WHERE Usuario=? AND Tipo=1";
	$stmt = $conn->prepare($result);

	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $result . ' Error: ' . $conn->error, E_USER_ERROR);
	}

		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$set_tipo=1;
	$stmt->bind_param('s',$usuario,$set_tipo);
	$stmt->execute();
	$rs=$stmt->get_result();

	if($row = $rs->fetch_assoc()){
		//echo $row["Password"]."<br>";
		//echo $row["Usuario"]."<br>";
		if(password_verify($password, $row["Password"])) {
			$_SESSION["Usuario"] = $row['Usuario'];
			$_SESSION["Id_Usuario"] = $row['Id'];
			$_SESSION["Tipo"] = $row['Tipo'];
			$rs->free();
			$stmt->close();
			//Elimina el siguiente comentario si quieres que re-dirigir automáticamente a index.php
			echo '<SCRIPT LANGUAGE="javascript">
			location.href = "principal.php";
			</SCRIPT>';
		}else{
			echo 'Datos incorrectos';
			echo '<p><a href="index.html">Volver</a></p>';
		}
	}else{
		 
		echo 'Datos incorrectos';
		echo '<p><a href="index.html">Volver</a></p>';
	}
		$rs->free();
}else{
	//echo 'Debe especificar un usuario y password';
echo '<p><a href="index.html">Volver</a></p>';
}

?>