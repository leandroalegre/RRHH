$(document).ready(function() {
// Bind to the submit event of our form

			// Para El Label Tipo Documento
			var buttonNewPaciente = document.getElementById('nuevoPaciente');
			var buttonNuevoPersonal = document.getElementById('nuevoPersonal');
			addRevealHandler(buttonNewPaciente,buttonNuevoPersonal);


			function addRevealHandler(buttonNewPaciente,buttonNuevoPersonal) {
				
				buttonNewPaciente.onclick = function() {
							
					set_tipopersonadb=1;
					settipodbpost="setpersonadatabase";
					request=$.ajax({
						
						dataType: "json",
						type: "post",
						url: "setpersona_db.php",
						//data:{"codigoorganismo":codigoorganismo,"accion":accion, "numeroacta":numeroacta},
					    data:{"set_tipopersonadb":set_tipopersonadb, "settipodbpost":settipodbpost},
						success: function(data) {
							if(data.returned_senddb=="ready_paciente"){
								location.href = "personas.php";
							}
							//alert(data.returned_val);
						}
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

					
				buttonNuevoPersonal.onclick = function() {
				console.log('Sos Yanque Hiciste handler Personal');

				set_tipopersonadb=0;
				settipodbpost="setpersonadatabase";

				request=$.ajax({
						
						dataType: "json",
						type: "post",
						url: "setpersona_db.php",
						//data:{"codigoorganismo":codigoorganismo,"accion":accion, "numeroacta":numeroacta},
					    data:{"set_tipopersonadb":set_tipopersonadb, "settipodbpost":settipodbpost},
						success: function(data) {
							if(data.returned_senddb=="ready_personal"){
								location.href = "personas.php";
							}
							//alert(data.returned_val);
						}
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


							}// ButtonBuscarInfraccion Submit
				}//function addRevealHandler(buttonNewInfraccion,buttonBuscarInfraccion)
				

});