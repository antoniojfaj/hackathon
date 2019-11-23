<html>
    <head>
        <title>REAC</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/reac.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
	
    </head>
    <body>
		<input type="hidden" name="idioma" id="idioma" value="es" />
        <div id="contenedor">
            <h1>REAC</h1>
			<div class="pagina" id="pagina">
				<hr/>
				<div class="selectorIdioma">
					<div><img class="imagenIdioma" id="es" src="img/es.png" alt="es" onclick="escogerIdioma('es')" />
					<br/>Español</div>
					<div><img class="imagenIdioma" id="en" src="img/en.png" alt="en"  onclick="escogerIdioma('en')" />
					<br/>English</div>
					<div><img class="imagenIdioma" id="de" src="img/de.png" alt="de"  onclick="escogerIdioma('de')" />
					<br/>Deutsch</div>
					<div><img class="imagenIdioma" id="0" src="img/0.png" alt="0" onclick="detectarIdioma();" />
					<br/>Other</div>
				</div>
			</div>
			
        </div>
        
    </body>
    <script src="js/jQuery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/reac.js"></script>

</html>