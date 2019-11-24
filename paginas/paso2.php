<?php
	if (file_exists("../lang/".$_POST['lang'].".php")) {
		include_once("../lang/".$_POST['lang'].".php");
	}
	else {
		include_once("../lang/es.php");
	}
		
	print '<div class="separado-up"><h2>'._DEF_1_.'</h2>
	<h3>'._DEF_2_.'</h3>
	<div class="centrado">
		<button class="botonOK botonGrande" id="botonOK" onclick="OK();"><i class="fas fa-microphone-alt"></i></button> 
		<button class="botonKO botonGrande oculto" id="botonKO" onclick="KO();"><i class="fas fa-microphone-alt-slash"></i></button> 
		<button class="boton botonGrande" onclick="location.reload();"><i class="fas fa-home"></i></button>
		<h4 class="separado-up">'._DEF_5_.'</h4>
		<hr/ class="separado-up">
		<input type="hidden" id="pagina2" value="1" />
	</div></div>';