<?php
	if (file_exists("../lang/".$_POST['lang'].".php")) {
		include_once("../lang/".$_POST['lang'].".php");
	}
	else {
		include_once("../lang/es.php");
	}
		
	print '<h2>'._DEF_4_.'</h2>';
	print '<h2 class="separado-up"><i class="fas fa-smile-wink fa-5x"></i></h2>';
	
?>