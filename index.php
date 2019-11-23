<html>
    <head>
        <title>REAC</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/reac.css" />
    </head>
    <body>
		<input type="hidden" name="idioma" id="idioma" value="es" />
        <div id="contenedor">
            <h1>REAC - Estamos para ayudarte</h1>
			<div class="pagina" id="pagina">
				<h2>Selecciona un idioma</h2>
				<hr/>
				<div class="selectorIdioma">
					<div><img id="es" src="img/es.png" alt="es" onclick="escogerIdioma('es')" />
					<br/>Español</div>
					<div><img id="en" src="img/en.png" alt="en"  onclick="escogerIdioma('en')" />
					<br/>English</div>
					<div><img id="de" src="img/de.png" alt="de"  onclick="escogerIdioma('de')" />
					<br/>Deutsch</div>
					<div><img src="img/0.png" alt="0" onclick="detectarIdioma();" />
					<br/>Other</div>
				</div>
			</div>
			
        </div>
        
    </body>
    <script src="js/jQuery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/reac.js"></script>

</html>