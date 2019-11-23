<?php
	if (file_exists("../lang/".$_POST['lang'].".php")) {
		include_once("../lang/".$_POST['lang'].".php");
	}
	else {
		include_once("../lang/es.php");
	}
		
	print '<div class="centrado separado-up"><i class="fas fa-check fa-5x"></i></div>';
	print '<div class="separado-up"><h2>'._DEF_4_.'</h2>
	<div class="centrado separado-up"><button class="boton" onclick="location.reload();"><i class="fas fa-home"></i></button></div>';
	
?>