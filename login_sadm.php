<?php
session_start();

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1;mode=block');
		
foreach( $_GET as $variable => $valor ){
$_GET[$variable] = filter_var($_GET[$variable], FILTER_SANITIZE_STRING);
}
// Modificamos las variables de formularios
foreach( $_POST as $variable => $valor ){
$_POST[$variable] = filter_var($_POST[$variable], FILTER_SANITIZE_STRING);
}


include "conexion.php";
//-----------------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------------
if(trim($_POST["usuario"])!= "" &&  $_POST["password"]!= ""){

	

	$password=$_POST["password"];
	
	if(isset($_POST['sidc']) &&  $_POST['sidc']!="") {
		$_SESSION["get_idcentro"]=$_POST['sidc'];

	}

	$usuario = htmlentities($_POST["usuario"], ENT_QUOTES);
	
	
	$result="SELECT * FROM Sis_Usuarios WHERE Usuario=? AND Tipo=?";
	$stmt = $conn->prepare($result);

	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $result . ' Error: ' . $conn->error, E_USER_ERROR);
	}

		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$set_tipo=1;
	$stmt->bind_param('si',$usuario,$set_tipo);
	$stmt->execute();
	$rs=$stmt->get_result();

	if($row = $rs->fetch_assoc()){
	;
		//echo $row["Password"]."<br>";
		//echo $row["Usuario"]."<br>";
		if(password_verify($password, $row["Password"])) {
				
			$_SESSION["Usuario"] = $row['Usuario'];
			$_SESSION["Id_Usuario"] = $row['Id'];
			$_SESSION["Tipo"] = $row['Tipo'];
			$_SESSION["login_idpersona"] = $row['Id_Persona'];
			$rs->free();
			$stmt->close();

			//-----------------------------------------------------------------------------------------------------------------------------------------------
			// Chequeo que no Halla Ninguna Caja Abierta Y si la Hay Debe Coincidir la ubicacion fisica del  centro de la caja con el logueo del Usuario
			//( Si la caja abierta del usuario X pertenece al Sayago debe estar logueandose del Sayago)

				echo '<SCRIPT LANGUAGE="javascript">
			location.href = "principal.php";
			</SCRIPT>';
 //if($rowea = $rs_ea->fetch_assoc()){

	//-----------------------------------------------------------------------------------------------------------------------------------------------------
	//Elimina el siguiente comentario si quieres que re-dirigir automáticamente a index.php
			
		}else{
			echo 'Datos incorrectos';
			echo '<p><a href="mainlog/index.php">Volver</a></p>';
		}
	}else{
		$rs->free();
		echo 'Datos incorrectos';
		echo '<p><a href="mainlog/index.php">Volver</a></p>';
	}
		
}else{
	//echo 'Debe especificar un usuario y password';
echo '<p><a href="mainlog/index.php">Volver</a></p>';
}

?>