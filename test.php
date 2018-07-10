<?php 
		include "conexion.php";
$sql="INSERT INTO sis_legajo (id, apellido, nombre,legajo,dni,id_caja,estado) VALUES
			(?,?,?,?)";
			//die($sql);
			$stmt_insert = $conn->prepare($sql);
			if($stmt_insert === false) {
					trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
					}
			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
			$nombre="fede";
			$apellido="se la come";

			$idfirst=NULL;
			$stmt_insert->bind_param('iss',$idfirst,$apellido, $nombre);
			/* Execute statement */
				$stmt_insert->execute();
				 ?>