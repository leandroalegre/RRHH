function existeDni(){
	var check_dni=document.getElementById("numerodocumento").value;
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById("respuestaexiste");
	capa.innerHTML
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	
	request=$.ajax({
						
						dataType: "json",
						type: "post",
						url: "ajax/ajaxexistedni.php",
						//data:{"codigoorganismo":codigoorganismo,"accion":accion, "numeroacta":numeroacta},
					    data:{"check_dni":check_dni},
						success: function(data) {
							if(data.returned_usuario=="existe"){
								capa.innerHTML=data.returned_val1;
								document.getElementById("nombreapellido").value=data.returned_nombre;
								document.getElementById("tipodocumento").selectedIndex=data.returned_tipodocumento;
								document.getElementById("sexo").selectedIndex=data.returned_sexo;
							} else {
								console.log("No existe");
								capa.innerHTML=data.returned_val1;
								document.getElementById("nombreapellido").value=data.returned_nombre;
								document.getElementById("tipodocumento").selectedIndex=data.returned_tipodocumento;
								document.getElementById("sexo").selectedIndex=data.returned_sexo;

							}
						}//success: function(data)
						
						});
			
						
					    // Callback handler that will be called on success
					    request.done(function (response, textStatus, jqXHR){
					        // Log a message to the console
					        console.log("Hooray, it worked!");
					    });

					    // Callback handler that will be called on failure
					    request.fail(function (jqXHR, textStatus, errorThrown){
					        // Log the error to the console
					        console.error(
					            "The following error occurred: "+
					            textStatus, errorThrown
					        );
					    });	

						}