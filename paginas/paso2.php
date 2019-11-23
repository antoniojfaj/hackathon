<?php
	if (file_exists("../lang/".$_POST['lang'].".php")) {
		include_once("../lang/".$_POST['lang'].".php");
	}
	else {
		include_once("../lang/es.php");
	}
		
	print '<h2>'._DEF_1_.'</h2>
	<h3>'._DEF_2_.'</h3>
	<div class="centrado">
		<button class="botonOK"><i class="fas fa-microphone-alt"></i></button> 
		<button class="botonKO" disabled="disabled"><i class="fas fa-microphone-alt-slash"></i></button> 
		<button class="boton" onclick="location.reload();"><i class="fas fa-home"></i></button>
	</div>';