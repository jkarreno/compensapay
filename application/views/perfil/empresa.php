<?php
	//TODO: en todos los registros existe la clase invalid de materialize y es la que se tendrria que ocupar para poner el borde rojo se llama validate
	$unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];
	//var_dump($this->session->userdata('datosEmpresa'));
	//if ( empty( $this->session->userdata ( 'datosEmpresa' )[ 'rec_id' ] ) ) {
	//	$botonProv = '<a class="modal-trigger button-gray" href="#modal-proveedor" >
    //                    Crear cuenta bancaria
    //                </a>';
	//} else {
		$botonProv = '';
	//}
	$urlArchivos = base_url ( 'boveda/' . $unique . '/' . $unique . '-' );
?>

<script>
	$(document).ready(function () {
		$("#btn-fase-1").on("click", function () {
			var bandera = false;
			var msg = "";
			var emailField = document.getElementById("emailForm");
			var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
			
			$(".form-1").each(function () {
				if ($(this).val() == "" || $(this).val() == null) {
					bandera = true;
				}
			});
			
			if (bandera) {
				msg = "Debe llenar todos los campos para continuar.";
			}
			
			
			if (validEmail.test(emailField.value)) {
			
			} else {
				msg += "\nEl Email no tiene un formato valido.";
			}
			
			if ($("#phoneForm").val().length != 10) {
				msg += "\nEl teléfono debe ser de 10 carácteres.";
			} else if (isNaN($("#phoneForm").val())) {
				msg += "\nEl teléfono solo debe contener números.";
			}
			
			if (msg == "") {
				hideForms();
				$("#div-fase-2").show();
				$("#btn-fase-2").show();
				$("#back-fase-1").show();
				
			} else {
				alert(msg);
				return false;
				
			}
		});
		
		$("#btn-fase-2").on("click", function () {
			var bandera = false;
			var msg = "";
			var emailField = document.getElementById("emailForm2");
			var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
			
			$(".form-2").each(function () {
				if ($(this).val() == "" || $(this).val() == null) {
					bandera = true;
				}
			});
			
			if (bandera) {
				msg = "Debe llenar todos los campos para continuar.";
			}
			
			var fileInput = document.getElementById("firmaLegal");
			var filePrueba = document.getElementById("firmaLegal").files[0];
			var nameImage = document.getElementById("nameImage");
			
			var filePath = fileInput.value;
			var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
			if (!allowedExtensions.exec(filePath)) {
				fileInput.value = "";
				nameImage.value = "";
				msg += "\nLa imagen de la firma solo acepta los siguientes formatos: 'jpg', 'jpeg' o 'png'.";
			}
			
			
			if (validEmail.test(emailField.value)) {
			
			} else {
				msg += "\nEl Email no tiene un formato valido.";
			}
			
			if ($("#phoneForm2").val().length != 10) {
				msg += "\nEl teléfono debe ser de 10 carácteres.";
			} else if (isNaN($("#phoneForm").val())) {
				msg += "\nEl teléfono solo debe contener números.";
			}
			
			if (msg == "") {
				hideForms();
				$("#div-fase-3").show();
				$("#btn-fase-3").show();
				$("#back-fase-2").show();
				//console.log(filePrueba)
				
			} else {
				alert(msg);
				return false;
				
			}
		});
		
		$("#btn-fase-3").on("click", function () {
			var bandera = false;
			var msg = "";
			var fisica = $("input[name=\"fisica\"]:checked").val();
			var moral = $("input[name=\"moral\"]:checked").val();
			var license = $("input[name=\"license\"]:checked").val();
			var audited = $("input[name=\"audited\"]:checked").val();
			var anticorruption = $("input[name=\"anticorruption\"]:checked").val();
			var dataProtection = $("input[name=\"dataProtection\"]:checked").val();
			
			if ((fisica == "" || fisica == null) || (moral == "" || moral == null) || (license == "" || license == null) || (audited == "" || audited == null) || (anticorruption == "" || anticorruption == null) || (dataProtection == "" || dataProtection == null)) {
				msg += "Faltan respuestas por marcar, seleccione 'Si' o 'No'. ";
			}
			//console.log(license == 1);
			if (license == 1) {
				$(".form-3").each(function () {
					if ($(this).val() == "" || $(this).val() == null) {
						bandera = true;
					}
				});
				
				if (bandera) {
					msg += "\nRespondio 'Si' en Estatus regulatorio, aun faltan preguntas por responder.";
				}
			}
			
			
			if (msg == "") {
				hideForms();
				$("#div-fase-4").show();
				$("#btn-fase-4").show();
				$("#back-fase-3").show();
				
			} else {
				alert(msg);
				return false;
				
			}
		});
		
		$("#btn-fase-4").on("click", function () {
			var bandera = false;
			var msg = "";
			var firmabase64 = "";
			var formato = "";
			var value = "";
			//Este objeto FileReader te permite leer archivos
			var reader = new FileReader();
			var vulnerable = $("input[name=\"vulnerable\"]:checked").val();
			
			if ((vulnerable == "" || vulnerable == null)) {
				msg += "Faltan respuestas por marcar, seleccione 'Si' o 'No'. ";
			}
			//console.log(license == 1);
			if (vulnerable == 1) {
				$(".form-4").each(function () {
					if ($(this).val() == "" || $(this).val() == null) {
						bandera = true;
					}
				});
				
				if (bandera) {
					msg += "\nRespondio 'Si' en Actividades vulnerables, aun faltan preguntas por responder.";
				}
			}
			
			if (msg == "") {
				hideForms();
				
			} else {
				alert(msg);
				return false;
				
			}
			
			value = document.getElementById("firmaLegal").files[0];
			var base_url = window.location.origin;
			
			//Esta función se ejecuta cuando el reader.readAsDataURL termina
			reader.onload = function (e) {
				firmabase64 = e.target.result.split("base64,")[1];
				formato = e.target.result.split(";")[0];
				if (msg == "") {
					hideForms();
					$.ajax({
						url: base_url + "/Proveedor/registrarProveedor",
						data: {
							bussinesName: $("#bussinesNameForm").val(),
							nationality: $("#nationality").val(),
							folio: $("#folio").val(),
							efirma: $("#efirma").val(),
							phoneForm: $("#phoneForm").val(),
							web: $("#web").val(),
							bank: $("#bankForm1").val(),
							nameComercial: $("#nameComercialForm1").val(),
							dateConst: $("#dateConst").val(),
							
							rfc: $("#rfcForm").val(),
							dom: $("#dom").val(),
							emailForm: $("#emailForm").val(),
							clabe: $("#clabeForm").val(),
							socialobj: $("#socialobj").val(),
							descOperation: $("#descOperation").val(),
							transactMonth: $("#transactMonth").val(),
							amount: $("#amount").val(),
							charge: $("#charge").val(),
							curp: $("#curp").val(),
							
							idNumber: $("#idNumber").val(),
							emailForm2: $("#emailForm2").val(),
							nameForm2: $("#nameForm2").val(),
							rfcForm2: $("#rfcForm2").val(),
							domForm2: $("#domForm2").val(),
							phoneForm2: $("#phoneForm2").val(),
							fisica: $("input[name=\"fisica\"]:checked").val(),
							moral: $("input[name=\"moral\"]:checked").val(),
							license: $("input[name=\"license\"]:checked").val(),
							supervisor: $("#supervisor").val(),
							
							dateAward: $("#dateAward").val(),
							typeLicense: $("#typeLicense").val(),
							audited: $("input[name=\"audited\"]:checked").val(),
							anticorruption: $("input[name=\"anticorruption\"]:checked").val(),
							dataProtection: $("input[name=\"dataProtection\"]:checked").val(),
							vulnerable: $("input[name=\"vulnerable\"]:checked").val(),
							servTrib: $("#servTrib").val(),
							obligations: $("#obligations").val(),
							firma: firmabase64,
							formato: formato
							
						},
						dataType: "json",
						method: "post",
						beforeSend: function () {
						
						},
						success: function (data) {
							//console.log(data);
							//var toastHTML = '<span><strong>¡ticket creado exitosamente!</strong><p>Su numero de folio es: #'+data.folio+'</span>';
							//M.toast({html: toastHTML});
						},
						complete: function () {
							//$('#descripcion').val('');
							//$('#asunto').val('');
							//getTickets();
						},
						error: function () {
							alert("Ha ocurrido un problema");
							//location.reload();
						}
					});
					
				} else {
					alert(msg);
					return false;
					
				}
			};
			
			reader.readAsDataURL(value);
			
		});
		
		$("#back-fase-1").on("click", function () {
			hideForms();
			$("#div-fase-1").show();
			$("#btn-fase-1").show();
		});
		
		$("#back-fase-2").on("click", function () {
			hideForms();
			$("#div-fase-2").show();
			$("#btn-fase-2").show();
			$("#back-fase-1").show();
		});
		
		$("#back-fase-3").on("click", function () {
			hideForms();
			$("#div-fase-3").show();
			$("#btn-fase-3").show();
			$("#back-fase-2").show();
			
		});
		
		$("#cancelForm").on("click", function () {
			hideForms();
			$("#div-fase-1").show();
			$("#btn-fase-1").show();
		});
		
		
	});
	
	function hideForms() {
		$("#div-fase-1").hide();
		$("#div-fase-2").hide();
		$("#div-fase-3").hide();
		$("#div-fase-4").hide();
		$("#back-fase-1").hide();
		$("#back-fase-2").hide();
		$("#back-fase-3").hide();
		$("#btn-fase-1").hide();
		$("#btn-fase-2").hide();
		$("#btn-fase-3").hide();
		$("#btn-fase-4").hide();
	}
	
	function fileValidation() {
		var fileInput = document.getElementById("firmaLegal");
		var filePath = fileInput.value;
		var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
		if (!allowedExtensions.exec(filePath)) {
		
		} else {
			//Image preview
			if (fileInput.files && fileInput.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					document.getElementById("imagePreview").innerHTML = "<img style=\"width: 300px; height:160;\" src=\"" + e.target.result + "\"/>";
				};
				reader.readAsDataURL(fileInput.files[0]);
			}
		}
	}
	
	function chargeValidation() {
		var fileInput = document.getElementById("firmaLegal");
		var filePath = fileInput.value;
		var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
		if (!allowedExtensions.exec(filePath)) {
		
		} else {
			//Image preview
			if (fileInput.files && fileInput.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					document.getElementById("imagePreview").innerHTML = "<img style=\"width: 300px; height:160;\" src=\"" + e.target.result + "\"/>";
				};
				reader.readAsDataURL(fileInput.files[0]);
			}
		}
	}
</script>

<div class="p-5" id="app">
	<h5>Configuración de la empresa</h5>
	<div class="row">
		<div class="col l12 card esquinasRedondas right-align" style="padding: 20px;">
			<a class="linkConfiguracion" href="<?= base_url ( 'Configuracion' ); ?>" style="color: #9118bd">
				Configuración Avanzada
				<i class="material-icons iconoSetting">
					settings
				</i></a>
		</div>
	</div>
	<form
		@submit.prevent="submitForm" method="post" action="<?php echo base_url ( '' ); ?>" class="col l12"
		enctype="multipart/form-data">
		<div class="row card esquinasRedondas">
			<div class="col l5 especial-p">
				<div class="row">
					<div class="col l12" style="margin-bottom: 30px;">
						<p class="bold">Detalles de la empresa</p>
					</div>
					<div class="input-border col l12">
						<input
							v-model="data['bussinesName']" @blur="checkFormat('bussinesName')"
							:style="colorsBorder['bussinesName'] || {}" type="text" name="bussinesName"
							id="bussinesName" required>
						<label for="bussinesName">Razón Social *</label>
						<p
							v-if="colorsBorder['bussinesName'] && colorsBorder['bussinesName'].border === '1px solid red!important'"
							class="error-message">¡Razón Social inválida!</p>
					</div>
				
				</div>
				<div class="row">
					<div class="input-border col l6">
						<input
							v-model="data['nameComercial']" @blur="checkFormat('nameComercial')"
							:style="colorsBorder['nameComercial'] || {}" type="text" name="nameComercial"
							id="nameComercial" required>
						<label for="nameComercial">Nombre Comercial *</label>
						<p
							v-if="colorsBorder['nameComercial'] && colorsBorder['nameComercial'].border === '1px solid red!important'"
							class="error-message">¡Nombre Comercial inválido!</p>
					</div>
					<div class="input-border col l6">
						<select name="giro" id="giro" v-model="data['giro']" required>
							<option v-for="giro in listaGiros" :key="giro.gro_id" :value="giro.gro_id">{{ giro.gro_giro
							                                                                           }}
							</option>
						
						</select>
						<label for="giro">Giro *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l6">
						<input
							v-model="data['rfc']" @blur="checkFormat('rfc')" :style="colorsBorder['rfc'] || {}"
							type="text" name="rfc" id="rfc" minlength="12" maxlength="13" pattern="[A-Z0-9]{12,13}"
							title="Debe tener de 12 a 13 caracteres alfanuméricos" required>
						<label for="rfc">RFC *</label>
						<p
							v-if="colorsBorder['rfc'] && colorsBorder['rfc'].border === '1px solid red!important'"
							class="error-message">¡RFC inválido!</p>
					</div>
					<div class="input-border col l6">
						<select name="regimen" id="regimen" v-model="data['regimen']" required>
							<option
								v-for="(regimen,index) in listaRegimenes" :key="regimen.rg_id" :value="regimen.rg_id">{{
							                                                                                          regimen.rg_regimen
							                                                                                          }}
							</option>
						
						</select>
						<label for="regimen">Regimen Fiscal *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l6">
						<input
							v-model="data['codigoPostal']" @blur="checkFormat('codigoPostal')"
							:style="colorsBorder['codigoPostal'] || {}" type="text" name="codigoPostal"
							id="codigoPostal" maxlength="5" pattern="[0-9]{5}" required>
						<label for="codigoPostal">Codigo Postal *</label>
						<p
							v-if="colorsBorder['codigoPostal'] && colorsBorder['codigoPostal'].border === '1px solid red!important'"
							class="error-message">¡Código Postal inválido!</p>
					</div>
					<div class="input-border col l6">
						<input
							type="text" name="estado" id="estado" disabled :placeholder="data['estado']['name']"
							required>
						<label for="estado">Estado</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input
							v-model="data['direccion']" @blur="checkFormat('direccion')"
							:style="colorsBorder['direccion'] || {}" type="text" name="direccion" id="direccion"
							required>
						<label for="direccion">Direccion *</label>
						<p
							v-if="colorsBorder['direccion'] && colorsBorder['direccion'].border === '1px solid red!important'"
							class="error-message">¡Direccion inválida!</p>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l6">
						<input
							v-model="data['telefono']" @blur="checkFormat('telefono')"
							:style="colorsBorder['telefono'] || {}" type="text" name="telefono" id="telefono" required
							pattern="[0-9]{10}" maxlength="10"
							title="Por favor, ingresa exactamente 10 dígitos numéricos.">
						<label for="telefono">Telefono *</label>
						<p
							v-if="colorsBorder['telefono'] && colorsBorder['telefono'].border === '1px solid red!important'"
							class="error-message">¡Telefono inválido!</p>
					</div>
				</div>
			</div>
			<div class="col l4 line-card line-card-l especial-p">
				<div class="row">
					<div class="col l12" style="margin-bottom: 30px;">
						<p class="bold">Datos Bancarios</p>
					</div>
					<div class="input-border col l12">
						<input
							v-model="data['clabe']" @blur="checkFormat('clabe')" :style="colorsBorder['clabe'] || {}"
							type="text" name="clabe" id="clabe" required pattern="[0-9]{18}" maxlength="18"
							title="Por favor, ingresa exactamente 18 dígitos numéricos.">
						<label for="clabe" style="display: ruby">
							<span>Cuenta CLABE (A la que se enviara el saldo a favor en las conciliaciones)*</span>
						</label>
						
						<p
							v-if="colorsBorder['clabe'] && colorsBorder['clabe'].border === '1px solid red!important'"
							class="error-message">¡Cuenta CLABE inválido!</p>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input
							type="text" name="bank" id="bank" disabled :placeholder="data['bank']['bnk_alias']"
							required>
						<label for="bank">Banco emisor *</label>
					</div>
				</div>
				<div class="row" style="text-align: center;">
					<?php echo $botonProv; ?>
				</div>
				
				<div v-if="false" class="row">
					
					<p class="bold p-3">
						Soy Proveedor
					</p>
					<div class="input-border col l12">
						<input type="text" name="partner" id="partner" disabled>
						<label for="partner">Cliente *</label>
					</div>
				</div>
			
			</div>
			<div class="col l3 center-align">
				<div class="container">
					<h5 class="card-title">Seleccionar logotipo</h5>
					<img :src="imageUploadURL" alt="" style="max-width: 140px; max-height: 140px;"><br>
					<label for="imageUpload" class="button-gray p-5">
						Seleccionar Imagen
					</label>
					<input
						@change="checkFormat('imageUpload')" ref="imageUpload" name="imageUpload" id="imageUpload"
						type="file" accept="image/jpeg" maxFileSize="1048576" />
				</div>
			</div>
		</div>
		<div class="row card esquinasRedondas" style="padding:20px">
			<table id="tabla_documentos" class="stripe row-border order-column nowrap">
				<thead>
				<tr>
					<th>
						<p>Documento</p>
					</th>
					<th>
						<p>Archivo</p>
					</th>
					<th>
						<p>Actualizar</p>
					</th>
				</tr>
				</thead>
				
				<tbody>
				<tr>
					<td>
						<p>Acta Constitutiva</p>
					</td>
					<td><a :href="actaConstitutivaUploadURL" target="_blank">{{actaConstitutivaUploadName}}</a></td>
					<td>
						<label for="actaConstitutivaUpload" class="button-gray">Agregar</label>
						<input
							@change="checkFormat('actaConstitutivaUpload')" name="actaConstitutivaUpload"
							ref="actaConstitutivaUpload" id="actaConstitutivaUpload" type="file"
							accept="application/pdf" maxFileSize="5242880" />
					</td>
				</tr>
				<tr>
					<td>
						<p>Constancia de Situacion Fiscal</p>
					</td>
					<td><a :href="csfUploadURL" target="_blank">{{csfUploadName}}</a></td>
					<td>
						<label for="csfUpload" class="button-gray">Agregar </label>
						<input
							@change="checkFormat('csfUpload')" name="csfUpload" ref="csfUpload" id="csfUpload"
							type="file" accept="application/pdf" maxFileSize="5242880" />
					</td>
				</tr>
				<tr>
					<td>
						<p>Comprobante de Domicilio</p>
					</td>
					<td><a :href="comprobanteDomicilioUploadURL" target="_blank">{{comprobanteDomicilioUploadName}}</a>
					</td>
					<td>
						<label for="comprobanteDomicilioUpload" class="button-gray">Agregar</label>
						<input
							@change="checkFormat('comprobanteDomicilioUpload')" name="comprobanteDomicilioUpload"
							ref="comprobanteDomicilioUpload" id="comprobanteDomicilioUpload" type="file"
							accept="application/pdf" maxFileSize="5242880" />
					</td>
				</tr>
				<tr>
					<td>
						<p>Identificacion de Representante Legal</p>
					</td>
					<td><a :href="representanteLegalUploadURL" target="_blank">{{representanteLegalUploadName}}</a></td>
					<td>
						<label for="representanteLegalUpload" class="button-gray">Agregar</label>
						<input
							@change="checkFormat('representanteLegalUpload')" name="representanteLegalUpload"
							ref="representanteLegalUpload" id="representanteLegalUpload" type="file"
							accept="application/pdf" maxFileSize="5242880" />
					</td>
				</tr>
				</tbody>
			</table>
		
		
		</div>
		<div class="row card esquinasRedondas" style="padding: 20px">
			<div class="col l12 right-align p-5">
				<button @click="redireccion" class="button-orange" name="action">Cancelar</button>
				
				<button class="button-gray" style="margin-left: 20px;" type="submit" name="action">Guardar</button>
			</div>
		</div>
	</form>
	
	<!-- Modal Registrarse como Proveedor -->
	<div id="modal-proveedor" class="modal">
		<div class="modal-content">
			<h5>Crear cuenta clabe en Solve</h5>
			<div class="card esquinasRedondas">
				<div class="card-content">
					<div name="div-fase-1" id="div-fase-1">
						<h5 class="p-3 h5-modular">A. Informacion General</h5>
						<div class="row">
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="bussinesNameForm">Denominaci&oacute; o raz&oacute;n
										                                               social *</label>
										<input
											class="form-1"
											value="<?php echo $this->session->userdata ( 'datosEmpresa' )[ 'legal_name' ] ?>"
											type="text" name="bussinesNameForm" id="bussinesNameForm">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="nationality">Nacionalidad *</label>
										<!--<input class="form-1" type="text" name="nationality" id="nationality" value="">-->
										<select name="nationality" id="nationality">
											<option value="Mexicana">Mexicana</option>
											<option value="Extranjera">Extranjera</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="folio">Número de Folio en el Registro Público de
										                                    Comercio o su equivalente *</label>
										<input class="form-1" type="text" name="folio" id="folio" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="efirma">Número de certificado de firma electrónica
										                                     (e firma) o su equivalente *</label>
										<input class="form-1" type="text" name="efirma" id="efirma" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col l6 cover">
										<label style="top:auto" for="phoneForm">Número de teléfono *</label>
										<input
											class="form-1"
											value="<?php echo $this->session->userdata ( 'datosEmpresa' )[ 'telephone' ] ?>"
											type="text" name="phoneForm" id="phoneForm">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="web">Sitio web *</label>
										<input class="form-1" type="text" name="web" id="web" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="bankForm1">Banco Emisor *</label>
										<input
											class="form-1" value="<?php echo $bank ?>" type="text" name="bankForm1"
											id="bankForm1">
									</div>
								</div>
							</div>
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="nameComercialForm1">Nombre Comercial *</label>
										<input
											class="form-1"
											value="<?php echo $this->session->userdata ( 'datosEmpresa' )[ 'short_name' ] ?>"
											type="text" name="nameComercialForm1" id="nameComercialForm1">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="dateConst">Fecha de constituci&oacute;n *</label>
										<input
											style="height: 4rem !important;" class="form-1" value=""
											max="<?= date ( "Y-m-d" ) ?>" type="date" name="dateConst" id="dateConst">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="rfcForm">"RFC o equivalente" *</label>
										<input
											class="form-1"
											value="<?php echo $this->session->userdata ( 'datosEmpresa' )[ 'rfc' ] ?>"
											type="text" name="rfcForm" id="rfcForm">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="dom">"Domicilio fiscal" *</label>
										<input
											class="form-1"
											value="<?php echo $this->session->userdata ( 'datosEmpresa' )[ 'address' ] ?>"
											type="text" name="dom" id="dom">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="emailForm">"Correo Electrónico" *</label>
										<input class="form-1" type="text" name="emailForm" id="emailForm" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="clabeForm">"Número de cuenta, CLABE" *</label>
										<input
											class="form-1"
											value="<?php echo $this->session->userdata ( 'datosEmpresa' )[ 'account_clabe' ] ?>"
											type="text" name="clabeForm" id="clabeForm">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div hidden name="div-fase-2" id="div-fase-2">
						<h5 class="p-3 h5-modular">B. Modelo de negocio</h5>
						<div class="row">
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="socialobj">Objeto social *</label>
										<textarea
											class="form-2" name="socialobj" id="socialobj" rows="10" cols="50"
											value=""></textarea>
									</div>
								</div>
							</div>
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="descOperation">Describa cómo utilizara la cuenta de
										                                            fondos de pago electónico para su
										                                            operación *</label>
										<textarea
											class="form-2" name="descOperation" id="descOperation" rows="10"
											value=""></textarea>
									</div>
								</div>
							</div>
						</div>
						<h5 class="p-3 h5-modular">C. Perfil transaccional</h5>
						<div class="row">
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="transactMonth">Número estimado de transacciones por
										                                            mes *</label>
										<input
											class="form-2" type="text" name="transactMonth" id="transactMonth" value="">
									</div>
								</div>
							</div>
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="amount">Monto promedio de transacción (MXN o USD)
										                                     *</label>
										<input class="form-2" type="text" name="amount" id="amount" value="">
									</div>
								</div>
							</div>
						</div>
						<h5 class="p-3 h5-modular">D. Administración y representación legal</h5>
						<label>Porfavor, provea la información relativa a los representantes legales, administración y
						       principales funcionarios de la sociedad</label>
						<div class="row">
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="charge">Cargo *</label>
										<input class="form-2" type="text" name="charge" id="charge" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="curp">CURP *</label>
										<input class="form-2" type="text" name="curp" id="curp" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="idNumber">Tipo y número de identificación oficial
										                                       *</label>
										<input class="form-2" type="text" name="idNumber" id="idNumber" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="emailForm2">Correo electrónico *</label>
										<input class="form-2" type="text" name="emailForm2" id="emailForm2" value="">
									</div>
								</div>
								<div class="row">
									<div style="margin-bottom: 15px" class="input-border col cover">
										<label style="top:auto;" for="firmaLegal">Firma del representante legal
										                                          *</label>
									</div>
									<form style="margin-left: 10px" action="#">
										<div class="file-field input-field">
											<div class="btn">
												<span>Cargar Firma</span>
												<input
													style="display: block !important;" class="form-2" type="file"
													name="firmaLegal" id="firmaLegal"
													onchange="return fileValidation()">
											</div>
											<div class="file-path-wrapper">
												<input
													id="nameImage" class="file-path validate" type="text"
													placeholder="Firma del representante legal">
											</div>
										</div>
									</form>
									<div style="text-align: center" id="imagePreview"></div>
								</div>
							</div>
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="nameForm2">Nombre completo *</label>
										<input class="form-2" type="text" name="nameForm2" id="nameForm2" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="rfcForm2">RFC *</label>
										<input class="form-2" type="text" name="rfcForm2" id="rfcForm2" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="domForm2">Domicilio *</label>
										<input class="form-2" type="text" name="domForm2" id="domForm2" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="phoneForm2">Numero de teléfono *</label>
										<input class="form-2" type="text" name="phoneForm2" id="phoneForm2" value="">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<p style="top:auto; margin-top: 30px;" for="labelFirma">Al continuar con el
										                                                        formulario usted esta
										                                                        aceptando que esta firma
										                                                        es verídica y que se
										                                                        utilizará para aceptar
										                                                        los términos del
										                                                        contrato.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div hidden name="div-fase-3" id="div-fase-3">
						<h5 class="p-3 h5-modular">E. Administración y representación legal</h5>
						<p>¿Existe alguna persona que directa o indirectamente ejerza control* o tenga la titularidad
						   del 25% o mas de las acciones o partes sociales de la empresa?</p>
						<label>
							<input type="radio" name="fisica" id="fisica" value="1">
							<span>Si</span>
						</label>
						<br>
						<label>
							<input name="fisica" id="fisica" type="radio" value="0">
							<span>No</span>
						</label><br>
						<p>¿Existe alguna persona moral que directa o indirectamente ejerza control * o tenga la
						   titularidad del 25% o mas de las acciones o partes sociales de la empresa?</p>
						<label>
							<input type="radio" name="moral" id="moral" value="1">
							<span>Si</span>
						</label>
						<br>
						<label>
							<input name="moral" id="moral" type="radio" value="0">
							<span>No</span>
						</label>
						
						<h5 class="p-3 h5-modular">F. Estatus regulatorio y mejores prácticas</h5>
						<p>¿La empresa requiere licencia, permiso o registro para la prestación de sus servicios?</p>
						<label>
							<input type="radio" name="license" id="license" value="1">
							<span>Si</span>
						</label>
						<br>
						<label>
							<input name="license" id="license" type="radio" value="0">
							<span>No</span>
						</label>
						
						<p>En caso afirmativo, indicar la información siguiente:</p>
						<div class="row">
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="supervisor">Nombre de la autoridad supervisora
										                                         *</label>
										<input class="form-3" type="text" name="supervisor" id="supervisor">
									</div>
								</div>
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="dateAward">Fecha en que fue otorgado *</label>
										<input
											class="form-3" type="date" max="<?= date ( "Y-m-d" ) ?>" name="dateAward"
											id="dateAward">
									</div>
								</div>
							</div>
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="typeLicense">Tipo de permiso, licencia o registro
										                                          *</label>
										<input class="form-3" type="text" name="typeLicense" id="typeLicense">
									</div>
								</div>
							</div>
						</div>
						<p>¿La empresa ha sido auditada o sujeta a un proceso de inspección por la autoridad
						   supervisora? En caso afirmativo, proveer detalles</p>
						<label>
							<input type="radio" name="audited" id="audited" value="1">
							<span>Si</span>
						</label>
						<br>
						<label>
							<input name="audited" id="audited" type="radio" value="0">
							<span>No</span>
						</label>
						<p>¿La empresa cuenta con manuales o políticas en materia de anticorrupción?</p>
						<label>
							<input type="radio" name="anticorruption" id="anticorruption" value="1">
							<span>Si</span>
						</label>
						<br>
						<label>
							<input name="anticorruption" id="anticorruption" type="radio" value="0">
							<span>No</span>
						</label>
						<p>¿La empresa cuenta con manuales o políticas en materia de protección de datos y seguridad de
						   la información?</p>
						<label>
							<input type="radio" name="dataProtection" id="dataProtection" value="1">
							<span>Si</span>
						</label>
						<br>
						<label>
							<input name="dataProtection" id="dataProtection" type="radio" value="0">
							<span>No</span>
						</label>
					</div>
					<div hidden name="div-fase-4" id="div-fase-4">
						<h5 class="p-3 h5-modular">G. Actividades vulnerables</h5>
						<p>¿El giro o actividad de la empresa está regulado como actividad vulnerable?</p>
						<label>
							<input type="radio" name="vulnerable" id="vulnerable" value="1">
							<span>Si</span>
						</label>
						<br>
						<label>
							<input name="vulnerable" id="vulnerable" type="radio" value="0">
							<span>No</span>
						</label>
						<p>En caso afirmativo, proporcionar la información siguiente:</p>
						<div class="row">
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="servTrib">¿Se encuentra registrada la actividad
										                                       ante el Servicio de Administración
										                                       Tributaria? *</label>
										<input class="form-4" type="text" name="servTrib" id="servTrib">
									</div>
								</div>
							</div>
							<div class="col l6 especial-p">
								<div class="row">
									<div class="input-border col cover">
										<label style="top:auto" for="obligations">¿Se encuentra a corriente en el
										                                          cumplimiento de sus obligaciones en
										                                          esta materia? *</label>
										<input class="form-4" type="text" name="obligations" id="obligations">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col center-align cover">
							<a
								class="modal-close button-orange" name="cancelForm" id="cancelForm"
								style="color:#fff; color:hover:#">Cancelar</a>
							&nbsp;
							<button hidden class="button-gray" name="back-fase-1" id="back-fase-1" type="submit">Atrás
							</button>
							<button hidden class="button-gray" name="back-fase-2" id="back-fase-2" type="submit">Atrás
							</button>
							<button hidden class="button-gray" name="back-fase-3" id="back-fase-3" type="submit">Atrás
							</button>
							&nbsp;
							<button class="button-gray" name="btn-fase-1" id="btn-fase-1" type="submit">Siguiente
							</button>
							<button hidden class="button-gray" name="btn-fase-2" id="btn-fase-2" type="">Siguiente
							</button>
							<button hidden class="button-gray" name="btn-fase-3" id="btn-fase-3" type="">Siguiente
							</button>
							<a
								hidden class="modal-trigger modal-close button-gray" name="btn-fase-4" id="btn-fase-4"
								href="#modal-proveedor-final" onchange="return fileValidation()"
								style="color:#fff; color:hover:#">
								Guardar datos
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Registrarse como Proveedor -->
	<div id="modal-proveedor-final" class="modal">
		<div class="modal-content">
			<h5>Estructura accionaria</h5>
			<div class="card esquinasRedondas">
				<div class="card-content">
					<p>Manifiesto (manifestamos), que la  conformación de la estructura accionaria de mi (nuestra) representada se satisface de la siguiente forma:</p>
					<div class="row" id="accionistasM">
						<div class="col s2"></div>
						<div class="col s8">
							<table>
								<thead>
									<tr>
										<th>Accionistas</th>
										<th>Capital Social</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type="text" name="nombreaccM" id="nombreaccM"></td>
										<td><input type="number" name="capitalsocialM" id="capitalsocialM"></td>
										<td align="center">
											<input type="hidden" name="tipoaM" id="tipoaM" value="M">
											<input type="button" name="botadacc" id="botadacc" class="button-gray" value="Agregar" onClick="ad_acc(document.getElementById('nombreaccM').value, document.getElementById('capitalsocialM').value, document.getElementById('tipoaM').value)">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col s2"></div>
					</div>
					<p>Así mismo, hago de su conocimiento, que la estructura accionaria se compone de las siguientes personas físicas:</p>
					<div class="row" id="accionistasF">
						<div class="col s2"></div>
						<div class="col s8">
							<table>
								<thead>
									<th>Accionistas</th>
									<th>Capital Social</th>
									<th></th>
								</thead>
								<tbody>
									<td><input type="text" name="nombreaccF" id="nombreaccF"></td>
									<td><input type="number" name="capitalsocialF" id="capitalsocialF"></td>
									<td align="center">
										<input type="hidden" name="tipoaF" id="tipoaF" value="F">
										<input type="button" name="botadaccf" id="botadaccf" class="button-gray" value="Agregar" onClick="ad_acc(document.getElementById('nombreaccF').value, document.getElementById('capitalsocialF').value, document.getElementById('tipoaF').value)">
									</td>
								</tbody>
							</table>
						</div>
						<div class="col s2"></div>
					</div>
					<p>hago de su conocimiento que la persona que ejerce el control de la sociedad es:</p>
					<div class="row">
						<form name="festaccionariaf" id="festaccionariaf">
							<div class="row">
								<div class="input-field col s6">
									<input id="personacontrol" name="personacontrol" type="text" class="validate">
									<label for="personacontrol">Persona que ejerce el control de la sociedad</label>
								</div>
								<div class="input-field col s6">
									<input id="cargofuncion" name="cargofuncion" type="text" class="validate">
									<label for="cargofuncion">Cargo o función</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s4">
									<input id="nombre" name="nombre" type="text" class="validate">
									<label for="nombre">Nombre (s)</label>
								</div>
								<div class="input-field col s4">
									<input id="appaterno" name="appaterno" type="text" class="validate">
									<label for="appaterno">Ap. Paterno</label>
								</div>
								<div class="input-field col s4">
									<input id="apmaterno" id="apmaterno" type="text" class="validate">
									<label for="apmaterno">Ap. Materno</label>
								</div>
							</div>
							<div class="row">
								<div class="input-border col s4 cover">
									<label style="top:auto" for="dateConst">Fecha de nacimiento</label>
									<input style="height: 4rem !important;" class="form-1" value="" max="<?= date ( "Y-m-d" ) ?>" type="date" name="dateConst" id="dateConst">
								</div>
								<div class="input-field col s4">
									<input id="paisnacimiento" id="paisnacimiento" type="text" class="validate">
									<label for="paisnacimiento">Pais de nacimiento</label>
								</div>
								<div class="input-field col s4">
									<input id="entidadnacimiento" id="entidadnacimiento" type="text" class="validate">
									<label for="entidadnacimiento">Entidad de nacimiento</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s4">
									<input id="rfc" name="rfc" type="text" class="validate">
									<label for="rfc">RFC con homoclave</label>
								</div>
								<div class="input-field col s4">
									<input id="paisrecidencia" name="paisrecidencia" type="text" class="validate">
									<label for="paisrecidencia">Pais de residencia (nacional/extranjera)</label>
								</div>
								<div class="input-field col s4">
									<input id="paisresidenciafiscal" name="paisresidenciafiscal" type="text" class="validate">
									<label for="paisresidenciafiscal">Pais de residencia fiscal</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s4">
									<input id="nacionalidad" name="nacionalidad" type="text" class="validate">
									<label for="nacionalidad">Nacionalidad</label>
								</div>
								<div class="input-field col s4">
									<input id="curp" name="curp" type="text" class="validate">
									<label for="curp">Curp</label>
								</div>
							</div>
							<p>Domicilio para recibir notificaciones</p>
							<div class="row">
								<div class="input-border col s4 cover">
									<label style="top:auto" for="nationality">Tipo de Dirección *</label>
									<!--<input class="form-1" type="text" name="nationality" id="nationality" value="">-->
									<select name="nationality" id="nationality">
										<option value="Particular">Particular</option>
										<option value="Empresa">Empresa</option>
									</select>
								</div>
								<div class="input-field col s4">
									<input id="calle" name="calle" type="text" class="validate">
									<label for="calle">Calle</label>
								</div>
								<div class="input-field col s4">
									<input id="numext" name="numext" type="text" class="validate">
									<label for="numext">Num. Exterior</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s4">
									<input id="numint" name="numint" type="text" class="validate">
									<label for="numint">Num. Interior</label>
								</div>
								<div class="input-field col s4">
									<input id="pais" name="pais" type="text" class="validate">
									<label for="pais">Pais</label>
								</div>
								<div class="input-field col s4">
									<input id="cp" name="cp" type="text" class="validate">
									<label for="cp">C. P.</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s4">
									<input type="text" id="colonia" name="colonia" class="validate">
									<label for="colonia">Colonia</label>
								</div>
								<div class="input-field col s4">
									<input type="text" name="entidad" id="entidad" class="validate">
									<label for="entidad">Entidad</label>
								</div>
								<div class="input-field col s4">
									<input type="text" name="numtelefono" class="validate" id="numtelefono">
									<label for="numtelefono">Num. Telefonico</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s4">
									<input type="text" name="tipoiden" class="validate" id="tipoiden">
									<label for="tipoiden">Tipo de identificación oficial (INE, pasaporte, etc.)</label>
								</div>
								<div class="input-field col s4">
									<input type="text" name="numiden" class="validate" id="numiden">
									<label for="numiden">Num. Identificación</label>
								</div>
							</div>
							<div class="row">
								<div class="col s12 right-align">
									<input type="submit" value="Finalizar" class="button-gray" id="butfinalizar">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	
	const {
		createApp,
		computed,
		reactive,
		ref,
		isRef,
		onMounted,
		nextTick
	} = Vue;
	
	const app = createApp({
		setup() {
			const data = reactive({
				bussinesName: ref('<?= $this->session->userdata ( 'datosEmpresa' )[ 'legal_name' ] ?>'),
				nameComercial: ref('<?= $this->session->userdata ( 'datosEmpresa' )[ 'short_name' ] ?>'),
				giro: ref(<?= $this->session->userdata ( 'datosEmpresa' )[ 'id_type' ] ?>),
				rfc: ref('<?= $this->session->userdata ( 'datosEmpresa' )[ 'rfc' ] ?>'),
				regimen: ref(<?= $this->session->userdata ( 'datosEmpresa' )[ 'id_fiscal' ] ?>),
				
				codigoPostal: ref(<?= $postal ?>),
				estado: ref({
					id: ref(<?= $this->session->userdata ( 'datosEmpresa' )[ 'id_country' ] ?>),
					name: ref('<?= $state ?>')
				}),
				direccion: ref('<?= $this->session->userdata ( 'datosEmpresa' )[ 'address' ] ?>'),
				telefono: ref('<?= $this->session->userdata ( 'datosEmpresa' )[ 'telephone' ] ?>'),
				clabe: ref('<?= $this->session->userdata ( 'datosEmpresa' )[ 'account_clabe' ] ?>'),
				createdat: ref('<?= $this->session->userdata ( 'datosEmpresa' )[ 'created_at' ] ?>'),
				bank: ref({
					bnk_id: ref(<?= $this->session->userdata ( 'datosEmpresa' )[ 'id_broadcast_bank' ] ?>),
					bnk_alias: ref('<?= $bank ?>')
				}),
				
				imageUpload: ref(""),
				csfUpload: ref(""),
				actaConstitutivaUpload: ref(""),
				comprobanteDomicilioUpload: ref(""),
				representanteLegalUpload: ref(""),
				
				
				uniqueString: ref("")
				
			});
			
			// partes del image
			const imageUpload = ref(null);
			const imageUploadURL = ref('<?= $urlArchivos ?>logo.jpeg');
			const colorsBorder = reactive({});
			//partes del pdf
			const csfUpload = ref(null);
			const csfUploadName = ref("constanciaSituacionFiscal.pdf");
			const csfUploadURL = ref('<?= $urlArchivos ?>constanciaSituacionFiscal.pdf');
			//partes del pdf
			const actaConstitutivaUpload = ref(null);
			const actaConstitutivaUploadName = ref("actaConstitutiva.pdf");
			const actaConstitutivaUploadURL = ref('<?= $urlArchivos ?>actaConstitutiva.pdf');
			//partes del pdf
			const comprobanteDomicilioUpload = ref(null);
			const comprobanteDomicilioUploadName = ref("comprobanteDomicilio.pdf");
			const comprobanteDomicilioUploadURL = ref('<?= $urlArchivos ?>comprobanteDomicilio.pdf');
			//partes del pdf
			const representanteLegalUpload = ref(null);
			const representanteLegalUploadName = ref("representanteLegal.pdf");
			const representanteLegalUploadURL = ref('<?= $urlArchivos ?>representanteLegal.pdf');
			//partes de listar
			const listaRegimenes = ref([]);
			const listaGiros = ref([]);
			const codigoPostalID = ref('<?= $this->session->userdata ( 'datosEmpresa' )[ 'id_postal_code' ] ?>');
			// Se pudo haber hecho con evet
			const checkFormat = (nombreInput) => {
				if (!isRef(colorsBorder[nombreInput])) {
					colorsBorder[nombreInput] = ref("");
				}
				
				switch (nombreInput) {
					case "telefono":
						var patron = /[^0-9]/;
						if (data[nombreInput] != "" && data[nombreInput].length == 10 && !patron.test(data[nombreInput])) {
							
							colorsBorder[nombreInput] = {
								border: "1px solid #03BB85!important",
							};
							
						} else {
							colorsBorder[nombreInput] = {
								border: "1px solid red!important",
							};
							
						}
						break;
					case "codigoPostal":
						var patron = /[^0-9]/;
						if (data[nombreInput] != "" && data[nombreInput].length == 5 && !patron.test(data[nombreInput])) {
							var requestOptions = {
								method: "GET",
								redirect: "follow"
							};
							
							fetch("<?php echo base_url ( 'herramientas/listaPostal/' ); ?>" + data[nombreInput].toString(), requestOptions)
								.then(response => response.json())
								.then(result => {
									// console.log(typeof result);
									if (Object.keys(result).length === 0) {
										colorsBorder[nombreInput] = {
											border: "1px solid red!important",
										};
									} else {
										codigoPostalID.value = result[0].zip_id;
										// console.log(codigoPostalID.value);
										data["estado"]["id"] = result[0].zip_state;
										
										fetch("<?php echo base_url ( 'herramientas/listaEstado/' ); ?>" + String(data["estado"]["id"]), requestOptions)
											.then(response => response.json())
											.then(result => {
												//console.log(result);
												data["estado"]["name"] = result[0]["stt_name"];
												//console.log(data['estado']['name']);
											})
											.catch(error => console.log("error", error));
										colorsBorder[nombreInput] = {
											border: "1px solid #03BB85!important",
										};
									}
								})
								.catch(error => console.log("error", error));
							
							
						} else {
							colorsBorder[nombreInput] = {
								border: "1px solid red!important",
							};
							
						}
						break;
					case "estado":
						if (data[nombreInput] !== "") {
							colorsBorder[nombreInput] = {
								border: "1px solid #03BB85!important",
							};
							
						} else {
							colorsBorder[nombreInput] = {
								border: "1px solid red!important",
							};
							
						}
						
						break;
					case "direccion":
						if (data[nombreInput] !== "") {
							
							colorsBorder[nombreInput] = {
								border: "1px solid #03BB85!important",
							};
							
						} else {
							colorsBorder[nombreInput] = {
								border: "1px solid red!important",
							};
							
						}
						
						break;
					case "bussinesName":
						if (data[nombreInput] !== "") {
							
							colorsBorder[nombreInput] = {
								border: "1px solid #03BB85!important",
							};
							
						} else {
							colorsBorder[nombreInput] = {
								border: "1px solid red!important",
							};
							
						}
						
						break;
					case "nameComercial":
						if (data[nombreInput] !== "") {
							
							colorsBorder[nombreInput] = {
								border: "1px solid #03BB85!important",
							};
							
						} else {
							colorsBorder[nombreInput] = {
								border: "1px solid red!important",
							};
							
						}
						break;
					case "rfc":
						data[nombreInput] = data[nombreInput].toUpperCase();
						var patron = /[^A-Z0-9]/;
						if (data[nombreInput] != "" && (data[nombreInput].length == 12 || data[nombreInput].length == 13) && !patron.test(data[nombreInput])) {
							
							colorsBorder[nombreInput] = {
								border: "1px solid #03BB85!important",
							};
							
						} else {
							colorsBorder[nombreInput] = {
								border: "1px solid red!important",
							};
							
						}
						break;
					case "clabe":
						var patron = /[^0-9]/;
						if (data[nombreInput] != "" && data[nombreInput].length == 18 && !patron.test(data[nombreInput])) {
							
							//Aqui estoy
							var requestOptions = {
								method: "GET",
								redirect: "follow"
							};
							
							fetch("<?php echo base_url ( 'herramientas/listaBanco/' ); ?>" + data[nombreInput].toString().substring(0, 3), requestOptions)
								.then(response => response.json())
								.then(result => {
									if (result.length == 0) {
										colorsBorder[nombreInput] = {
											border: "1px solid red!important",
										};
									} else {
										data["bank"] = result[0];
										colorsBorder[nombreInput] = {
											border: "1px solid #03BB85!important",
										};
									}
								})
								.catch(error => console.log("error", error));
							
						} else {
							colorsBorder[nombreInput] = {
								border: "1px solid red!important",
							};
							
						}
						break;
					case "partner":
						data[nombreInput] = data[nombreInput].toUpperCase();
						var patron = /[^A-Z0-9]/;
						if (data[nombreInput] != "" && (data[nombreInput].length == 12 || data[nombreInput].length == 13) && !patron.test(data[nombreInput])) {
							
							colorsBorder[nombreInput] = {
								border: "1px solid #03BB85!important",
							};
							
						} else {
							colorsBorder[nombreInput] = {
								border: "1px solid red!important",
							};
							
						}
						break;
					case "imageUpload":
						if (imageUpload.value.files.length == 1) {
							
							if (imageUpload.value.files[0].size <= 1024 * 1024) {
								imageUploadURL.value = URL.createObjectURL(imageUpload.value.files[0]);
								data[nombreInput] = imageUpload.value;
								subirArchivo(data[nombreInput], "logo");
								
							} else {
								imageUploadURL.value = "";
								
							}
							
							
						} else if (imageUpload.value.files.length == 0) {
						}
						
						
						break;
					case "csfUpload":
						//falta el caso en el que se tiene que vaciar la variable porque no aceptamos su archivo creo va en el else
						if (csfUpload.value.files.length == 1) {
							
							if (csfUpload.value.files[0].size <= 1024 * 1024 * 30) {
								
								csfUploadURL.value = URL.createObjectURL(csfUpload.value.files[0]);
								csfUploadName.value = csfUpload.value.files[0].name;
								data[nombreInput] = csfUpload.value;
								subirArchivo(data[nombreInput], "constanciaSituacionFiscal");
								
							} else {
								csfUploadName.value = "";
							}
							
							
						} else if (csfUpload.value.files.length == 0) {
						}
						break;
					case "actaConstitutivaUpload":
						if (actaConstitutivaUpload.value.files.length == 1) {
							
							if (actaConstitutivaUpload.value.files[0].size <= 1024 * 1024 * 30) {
								
								actaConstitutivaUploadURL.value = URL.createObjectURL(actaConstitutivaUpload.value.files[0]);
								actaConstitutivaUploadName.value = actaConstitutivaUpload.value.files[0].name;
								data[nombreInput] = actaConstitutivaUpload.value;
								subirArchivo(data[nombreInput], "actaConstitutiva");
								
							} else {
								actaConstitutivaUploadName.value = "";
							}
							
							
						} else if (actaConstitutivaUpload.value.files.length == 0) {
						}
						break;
					case "comprobanteDomicilioUpload":
						if (comprobanteDomicilioUpload.value.files.length == 1) {
							
							if (comprobanteDomicilioUpload.value.files[0].size <= 1024 * 1024 * 30) {
								
								comprobanteDomicilioUploadURL.value = URL.createObjectURL(comprobanteDomicilioUpload.value.files[0]);
								comprobanteDomicilioUploadName.value = comprobanteDomicilioUpload.value.files[0].name;
								data[nombreInput] = comprobanteDomicilioUpload.value;
								subirArchivo(data[nombreInput], "comprobanteDomicilio");
								
							} else {
								comprobanteDomicilioUploadName.value = "";
							}
							
							
						} else if (comprobanteDomicilioUpload.value.files.length == 0) {
						}
						break;
					case "representanteLegalUpload":
						if (representanteLegalUpload.value.files.length == 1) {
							
							if (representanteLegalUpload.value.files[0].size <= 1024 * 1024 * 30) {
								
								representanteLegalUploadURL.value = URL.createObjectURL(representanteLegalUpload.value.files[0]);
								representanteLegalUploadName.value = representanteLegalUpload.value.files[0].name;
								data[nombreInput] = representanteLegalUpload.value;
								subirArchivo(data[nombreInput], "representanteLegal");
								
							} else {
								representanteLegalUploadName.value = "";
							}
							
							
						} else if (representanteLegalUpload.value.files.length == 0) {
						}
						break;
					default:
					// Código a ejecutar si valor no coincide con ningún caso
				}
				
			};
			
			// Hacer la solicitud Fetch a tu API
			const subirArchivo = (archivo, nombre, lugar = 0) => {
				const formData = new FormData();
				formData.append("archivo", archivo.files[0]);
				
				
				var requestOptions = {
					method: "POST",
					body: formData,
					redirect: "follow"
				};
				
				fetch("<?php echo base_url ( 'herramientas/subirArchivo/' ); ?>" + data["uniqueString"] + "/" + nombre + "/" + lugar, requestOptions)
					.then(response => response.json())
					.then(result => {
						/*console.log(result)*/
					})
					.catch(error => console.log("error", error));
			};
			const idUnico = () => {
				var requestOptions = {
					method: "GET",
					redirect: "follow"
				};
				fetch("<?php echo base_url ( 'herramientas/idUnico' ); ?>", requestOptions)
					.then((response) => response.json())
					.then((result) => {
						data["uniqueString"] = result.idUnico; // Almacenar los datos en la propiedad listaEstados
						// console.log(data['uniqueString']);
						
					});
			};
			const listarEstados = () => {
				var requestOptions = {
					method: "GET",
					redirect: "follow"
				};
				fetch("<?php echo base_url ( 'herramientas/listaEstados' ); ?>", requestOptions)
					.then((response) => response.json())
					.then((result) => {
						listaEstados.value = JSON.parse(result); // Almacenar los datos en la propiedad listaEstados
						// console.log(listaEstados.value);
						nextTick(() => {
							M.FormSelect.init(document.getElementById("estado"));
						});
						
					});
			};
			const listarRegimen = () => {
				var requestOptions = {
					method: "GET",
					redirect: "follow"
				};
				fetch("<?php echo base_url ( 'herramientas/listaRegimenes/2' ); ?>", requestOptions)
					.then((response) => response.json())
					.then((result) => {
						listaRegimenes.value = result; // Almacenar los datos en la propiedad listaRegimenes
						// console.log(listaRegimenes.value);
						nextTick(() => {
							M.FormSelect.init(document.getElementById("regimen"));
						});
						
					});
			};
			const listarGiro = () => {
				var requestOptions = {
					method: "GET",
					redirect: "follow"
				};
				
				fetch("<?php echo base_url ( 'herramientas/listaGiro' ); ?>", requestOptions)
					.then((response) => response.json())
					.then((result) => {
						listaGiros.value = result; // Almacenar los datos en la propiedad listaRegimenes
						//console.log(listaGiros.value);
						nextTick(() => {
							M.FormSelect.init(document.getElementById("giro"));
						});
						
					});
			};
			const submitForm = () => {
				// Obtén el objeto data
				const dataObject = {
					bussinesName: data.bussinesName,
					nameComercial: data.nameComercial,
					codigoPostal: codigoPostalID.value,
					estado: data.estado.id,
					direccion: data.direccion,
					telefono: data.telefono,
					type: data.giro,
					rfc: data.rfc,
					fiscal: data.regimen,
					clabe: data.clabe,
					bank: data.bank.bnk_id,
					documentos: data.uniqueString,
				};
				
				console.log(dataObject);
				
			};
			const redireccion = () => {
				window.location.replace("<?php echo base_url ( '' ); ?>");
			};
			
			
			onMounted(
				() => {
					idUnico();
					listarRegimen();
					listarGiro();
				}
			);
			
			
			return {
				data,
				colorsBorder,
				checkFormat,
				imageUpload,
				imageUploadURL,
				csfUpload,
				csfUploadName,
				csfUploadURL,
				actaConstitutivaUpload,
				actaConstitutivaUploadName,
				actaConstitutivaUploadURL,
				comprobanteDomicilioUpload,
				comprobanteDomicilioUploadName,
				comprobanteDomicilioUploadURL,
				representanteLegalUpload,
				representanteLegalUploadName,
				representanteLegalUploadURL,
				listaRegimenes,
				listaGiros,
				submitForm,
				redireccion,
				actaConstitutivaUploadURL
				
				
			};
		}
	});
</script>
<style>
	.card-title {
		margin-bottom: 30px !important;
		font-weight: bold !important;
	}
	
	.modal {
		max-height: 83% !important;
		width: 80% !important;
	}
	
	.h5-modular {
		line-height: 0%;
	}
	
	.btn {
		background: #444444;
	}
	
	.btn:hover {
		background: #e0e51d;
	}
	
	.especial-p {
		padding-right: 4% !important;
	}
	
	.cover {
		width: 99%;
	}
	
	input[type="file"] {
		display: none;
	}
	
	.custom-file-upload {
		color: white;
		background: #444;
		display: inline-block;
		padding: 10px 40px;
		cursor: pointer;
		border-radius: 3px !important;
	}
	
	.error-message {
		color: red;
		font-size: 10px;
		top: -25px;
		position: relative;
	}
	
	.iconoSetting {
		position: relative;
		top: 6px;
	}
	
	.linkConfiguracion {
		color: black;
	}
	
	.custom-file-upload:hover {
		border: none;
	}
	
	.cancelar:hover,
	.cancelar:focus {
		background-color: #444 !important;
	}
	
	.guardar,
	.cancelar:focus {
		background-color: #e0e51d !important;
	}
	
	]


</style>
<script>
	var tabla_61 = $("#tabla_documentos").DataTable({
		deferRender: true,
		language: {
			decimal: ".",
			thousands: ",",
			url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
		},
		paging: false,
		info: false,
		searching: false,
		sort: true
	});

	<?php if ( empty( $this->session->userdata ( 'datosEmpresa' )[ 'rec_id' ] ) ) { ?>

	$(document).ready(function(){
		$('#modal-proveedor').modal('open');
	});

	<?php } if( $this->session->userdata('datosEmpresa')['accionistas'] == 0 )	{ ?>
		
	$(document).ready(function(){
		$('#modal-proveedor-final').modal('open');
	});

	<?php }	?>

function ad_acc(nombreacc, capital, tipo){
	$.ajax({
		type: 'POST',
		url : '<?php echo base_url('Proveedor/registra_accionista');?>',
		data: 'nombreacc=' + nombreacc + '&capitalsocial=' + capital + '&tipoa=' + tipo
    }).done (function ( info ){
		$('#accionistas' + tipo).html(info);
	});
}
</script>
