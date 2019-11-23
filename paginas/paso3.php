<?php
	if (file_exists("../lang/".$_POST['lang'].".php")) {
		include_once("../lang/".$_POST['lang'].".php");
	}
	else {
		include_once("../lang/es.php");
	}
		
	print '<div class="separado-up"><h2>'._DEF_3_.'</h2>';
	print '<h2 class="separado-up"><i class="fas fa-spinner fa-spin fa-5x"></i></h2></div>';
	
?>