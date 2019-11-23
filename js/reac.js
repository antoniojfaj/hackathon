function escogerIdioma(idioma) {
	$("#idioma").val(idioma);

	var parametros = {
		lang : $("#idioma").val(),
	};
	
	$("#pagina").css("opacity","0");

	setTimeout(function() {
		$.ajax({
			data:  parametros,
			url:  '/paginas/paso2.php',
			type:  'post',
			beforeSend: function () {
				
			},
			success:  function (response, textStatus, error) {
				$("#pagina").html(response);
				$("#pagina").css("opacity","1");
			},
		});
	},1000);
}

function detectarIdioma() {
	
	$("#pagina").css("opacity","0");

	setTimeout(function() {
		$.ajax({
			url:  '/paginas/paso1.php',
			type:  'get',
			beforeSend: function () {
			},
			success:  function (response, textStatus, error) {
				$("#pagina").html(response);
				$("#pagina").css("opacity","1");
			},
		});
	},1000);

}