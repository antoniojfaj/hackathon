<?php
	if (file_exists("../lang/".$_POST['lang'].".php")) {
		include_once("../lang/".$_POST['lang'].".php");
	}
	else {
		include_once("../lang/es.php");
	}
		
	print '<div class="separado-up"><h2>'._DEF_1_.'</h2>
	<h3>'._DEF_2_.'</h3>
	<h4>'._DEF_5_.'</h4>
	<div class="centrado">
		<button class="botonOK" id="botonOK" onclick="OK();"><i class="fas fa-microphone-alt"></i></button> 
		<button class="botonKO oculto" id="botonKO" onclick="KO();"><i class="fas fa-microphone-alt-slash"></i></button> 
		<button class="boton" onclick="location.reload();"><i class="fas fa-home"></i></button>
		<hr/ class="separado-up">
		<input type="hidden" id="pagina2" value="1" />
	</div></div>';