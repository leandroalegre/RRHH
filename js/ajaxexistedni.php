<?php
session_start();
$dni=$_POST['check_dni'];
include "../conexion.php";
if(isset($dni)){
	$result_dni = "SELECT * FROM Personas_Infractor Where NumeroDocumento=? LIMIT 1";
	$stmtx_dni = $conn->prepare($result_dni);

	if($stmtx_dni === false) {
	trigger_error('Wrong SQL: ' . $result_dni . ' Error: ' . $conn->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
	$stmtx_dni->bind_param('i',$dni);
	$stmtx_dni->execute();
	$rsx_dni=$stmtx_dni->get_result();

	if($row_dni = $rsx_dni->fetch_assoc()){
		  $_SESSION['tipodocumento']=$row_dni['TipoDocumento'];
		  $_SESSION['numerodocumento']=$row_dni['NumeroDocumento']; 
		  $_SESSION['sexo']=$row_dni['Sexo'];
		  $_SESSION['xnombreapellido']=$row_dni['NombreYApellido'];
		  $_SESSION['id_persona']=$row_dni['Id'];

		  $_SESSION['allow_newpersona']="not_allow";
	
		$send_mesagge='<span style="color: #f3661f;font-size:12px;">Usuario Registrado con este DNI!'.$_SESSION['allow_newpersona'].'</span>';
		$set_xnombreapellido=$_SESSION['xnombreapellido'];
		$set_tipodocumento=$_SESSION['tipodocumento'];
		$set_tiposexo=$_SESSION['sexo'];

		if($set_tiposexo=="M"){
		$set_indexsexo=0;
		}
		
		if($set_tiposexo=="-F"){
		$set_indexsexo=1;
		}
		
		if($set_tiposexo=="N"){
		$set_indexsexo=2;
		}

		$returned_usuario="existe";
	}else{
		 $_SESSION['allow_newpersona']="yes_allow";
		 
		 $set_indexsexo=0;

		 $set_xnombreapellido="";
		 $set_tipodocumento=0;

		 $returned_usuario="noexiste";
		 $send_mesagge='<span style="color: #f3661f">Atención Nuevo Infractor</span>';
	}

	Senddata_function($returned_usuario, $send_mesagge,$set_xnombreapellido,$set_tipodocumento,$set_indexsexo);
}


	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
			
		
		
	function Senddata_function($returned_usuario,$send_mesagge,$set_xnombreapellido,$set_tipodocumento,$set_indexsexo){
				echo json_encode(array('returned_usuario' =>$returned_usuario, 'returned_val1' => $send_mesagge,'returned_nombre' =>$set_xnombreapellido,'returned_tipodocumento' =>$set_tipodocumento,'returned_sexo' =>$set_indexsexo));
  	}



?>