function escogerIdioma(idioma) {
	$("#idioma").val(idioma);

	var parametros = {
		lang : $("#idioma").val(),
	};
	
	$("#pagina").css("opacity","0");

	setTimeout(function() {
		$.ajax({
			data:  parametros,
			url:  'paginas/paso2.php',
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
			url:  'paginas/paso1.php',
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

function OK() {
	$("#botonOK").addClass("oculto");
	$("#botonKO").removeClass("oculto");
	// Empezar a grabar con el micrófono
	empezarGrabacion();
}
function KO() {
	if ($("#pagina2").length) {
		detenerGrabacion();
	}
	else {
		$("#botonKO").addClass("oculto");
		$("#botonOK").removeClass("oculto");
	}
}

function procesarAudio() {
	var parametros = {
		lang : $("#idioma").val(),
	};
	
	$("#pagina").css("opacity","0");

	setTimeout(function() {
		$.ajax({
			data:  parametros,
			url:  'paginas/paso3.php',
			type:  'post',
			beforeSend: function () {
				
			},
			success:  function (response, textStatus, error) {
				$("#pagina").html(response);
				$("#pagina").css("opacity","1");
				setTimeout(function() { $("#pagina").css("opacity","0"); },2000);
				setTimeout(function() { 
					$.ajax({
					data:  parametros,
					url:  'paginas/paso4.php',
					type:  'post',
					beforeSend: function () {
						
					},
					success:  function (response, textStatus, error) {
						$("#pagina").html(response);
						$("#pagina").css("opacity","1");

					},
				});
						
				}, 4000);
			},
		});
	},1000);	
}

function capturaMicrofono() {
            navigator.mediaDevices.getUserMedia({ audio: true })
              .then(stream => {
                const mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.audioChannels = 1;
                mediaRecorder.start();

                const audioChunks = [];
                mediaRecorder.addEventListener("dataavailable", event => {
                  audioChunks.push(event.data);
                });

                mediaRecorder.addEventListener("stop", () => {
                  const audioBlob = new Blob(audioChunks, {type : 'audio/ogg'});
                  var objectURL = URL.createObjectURL(audioBlob);
                  var filename = "-" + ".ogg";
                  var formData = new FormData();
                  formData.append('name', filename);
                  formData.append('tmp_name', objectURL);
                  formData.append('data', audioBlob);              
                    $.ajax({
                      url:"detect-language.php",
                      // send the base64 post parameter
                      data:formData,
                      // important POST method !
                      cache:false,
                      processData:false,
                      contentType:false,
                      type:'POST',
                      complete:function(results){
                        //alert(results.responseText);
                        //console.log(JSON.parse(results.responseText)["lang"]);
						switch(JSON.parse(results.responseText)["lang"]) {
							case 'english':
								escogerIdioma('en');
								break;
							case 'german':
								escogerIdioma('de');
								break;
							default:
								escogerIdioma('es');
								break;
						}
					},
                      error:function(results) {
                        alert('error');
                        console.log(results);
                      }
                    });
                });

            setTimeout(() => {
              mediaRecorder.stop();
            }, 5000);
          });
}

function capturaCoordenadas() 
{
	navigator.geolocation.getCurrentPosition(function(response) {
		$("#coorX").val(response.coords.longitude);
		$("#coorY").val(response.coords.latitude);
	});
}

$(document).ready(function() {
	$.ajax({
			url:  'paginas/paso1.php',
			type:  'get',
			beforeSend: function () {
			},
			success:  function (response, textStatus, error) {
				$("#pagina").html(response);
			},
	});
		
	capturaMicrofono();
	capturaCoordenadas();

});

function empezarGrabacion() {
	// Empezar a capturar con el micrófono sin límite de tiempo
	navigator.mediaDevices.getUserMedia({ audio: true })
              .then(stream => {
                const mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.audioChannels = 1;
                mediaRecorder.start();

                const audioChunks = [];
                mediaRecorder.addEventListener("dataavailable", event => {
                  audioChunks.push(event.data);
                });

                mediaRecorder.addEventListener("stop", () => {
                  const audioBlob = new Blob(audioChunks, {type : 'audio/ogg'});
                  var objectURL = URL.createObjectURL(audioBlob);
                  var filename = "-" + ".ogg";
				  var formData = new FormData();
				  formData.append('lang', $("#lang").val());
                  formData.append('name', filename);
                  formData.append('tmp_name', objectURL);
                  formData.append('data', audioBlob);              
                    $.ajax({
                      url:"translate.php",
                      // send the base64 post parameter
                      data:formData,
                      // important POST method !
                      cache:false,
                      processData:false,
                      contentType:false,
                      type:'POST',
                      complete:function(results){
                        window.location.href = results.responseText;
                        console.log(results);
                      },
                      error:function(results) {
                        alert('error');
                        console.log(results);
                      }
                    });
                });
          });
}

function detenerGrabacion() {
	// Detener la grabación del micrófono, procesar el texto del idioma detectado, traducirlo al castellano y generar fichero de audio.
	// Cuando termine todo hay que llamar a la función procesarAudio()
	mediaRecorder.stop();
	
	///procesarAudio();
}
	