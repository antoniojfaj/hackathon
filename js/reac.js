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

function OK() {
	$("#botonOK").addClass("oculto");
	$("#botonKO").removeClass("oculto");
}
function KO() {
	if ($("#pagina2").length) {
		procesarAudio();
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
			url:  '/paginas/paso3.php',
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
					url:  '/paginas/paso4.php',
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
                mediaRecorder.start();

                const audioChunks = [];
                mediaRecorder.addEventListener("dataavailable", event => {
                  audioChunks.push(event.data);
                });

                mediaRecorder.addEventListener("stop", () => {
                  const audioBlob = new Blob(audioChunks);
                  var reader = new FileReader();
                  var base64data;
                  reader.readAsDataURL(audioBlob); 
                  reader.onloadend = function() {
                    base64data = reader.result;                
                    $.ajax({
                      url:"services.php",
                      // send the base64 post parameter
                      data:{
                        audio: base64data
                      },
                      // important POST method !
                      type:"post",
                      complete:function(results){
                        //alert(results.responseText);
                        //console.log(results);
						switch(results.responseText) {
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
                  }
                });

            setTimeout(() => {
              mediaRecorder.stop();
            }, 3000);
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
			url:  '/paginas/paso1.php',
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
	