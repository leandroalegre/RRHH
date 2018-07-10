<!DOCTYPE html>
<html lang="EN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Panel Administrativo</title>

<link href="css/estilos.css" media="screen" rel="stylesheet" type="text/css" />

<!--MENU-->
<link href="css/menu_dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/menu_default.advanced.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
	var map;
	var markersArray = [];



	function initMap(){
		<?php

		if(!isset($_SESSION['idMASc'])){
			$_SESSION['idMASc']="";
		}

	if(isset($_GET['id']) && $_GET['id']!=""){
		$_SESSION['idMASc']=$_GET['id'];
		//$id=$_SESSION['idMASc'];
	}
		//echo $id;
		if($_SESSION['idMASc']!=''){
			include "conexion.php";
			$resultx = "SELECT * FROM Sis_Centros WHERE Id=?";
			$stmt = $conn->prepare($resultx);
			if($stmt === false) {
				trigger_error('Wrong SQL: ' . $resultx . ' Error: ' . $conn->error, E_USER_ERROR);
			}

			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
			$stmt->bind_param('i',$_SESSION['idMASc']);
			$stmt->execute();
			$rs=$stmt->get_result();
			
			if($rowx = $rs->fetch_assoc()){
				
				
					?> var latlng = new google.maps.LatLng(-31.41549757784405,-64.50273871421814); <?php
				
			}else{
				?> var latlng = new google.maps.LatLng(-31.37474411197793, -64.55652236938477); <?php
			}
		}else{
			?> var latlng = new google.maps.LatLng(-31.37474411197793, -64.55652236938477); <?php
		}
		?>
		
		var myOptions = {
			zoom: 12,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		var marker;
		
		// add a click event handler to the map object
	  google.maps.event.addListener(map, "click", function(event){
			// place a marker
			if (marker) { marker.setMap(null); }

			marker = new google.maps.Marker({ position: event.latLng, map: map });
			
			//alert(event.latLng);
			// display the lat/lng in your form's lat/lng fields
			document.getElementById("latitud").value = event.latLng.lat();
			document.getElementById("longitud").value = event.latLng.lng();
			
			
			
		});
		
		<?php
		//$id=$_GET['id'];
		if($_SESSION['idMASc']!=''){
			include "conexion.php";
			$resultx = "SELECT * FROM Sis_Centros WHERE Id=?";
			$stmt = $conn->prepare($resultx);
			if($stmt === false) {
				trigger_error('Wrong SQL: ' . $resultx . ' Error: ' . $conn->error, E_USER_ERROR);
			}

			/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */			
			$stmt->bind_param('i',$_SESSION['idMASc']);
			$stmt->execute();
			$rs=$stmt->get_result();
			if($row = $rs->fetch_assoc()){
				$latitud=$row['Latitud'];
				$longitud=$row['Longitud'];
				if($latitud!='' and $longitud!=''){
					//$latlong='('.$latitud.', '.$longitud.')';
					echo'var point = new google.maps.LatLng('.$latitud.','.$longitud.');';
					echo'marker = new google.maps.Marker({ position: point, map: map });';
				}
			}
		}
		?>
	}
	
	
</script>

</head>

<body>

<div style="height:16px;"></div>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td  valign="top" height="50"><div style="position: absolute;"><img src="images/logo.jpg" width="136" height="67" /></div></td>
</tr>
<tr>
  <td height="38" valign="top" style="padding-left:165px;">
  <?PHP include'menu.php'; ?>
  </td>
</tr>
   


