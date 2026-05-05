var tabla;

// 1. NUESTRA TRAMPA DE MEMORIA (Guarda la foto apenas la tocas)
var imagenActiva = null;
$(document).on("mousedown", ".note-editable img", function () {
	imagenActiva = $(this);
});

// --- NUESTRA FUNCIÓN PARA INSERTAR VIDEOS DE YOUTUBE ---
var BotonVideo = function (context) {
	var ui = $.summernote.ui;
	var button = ui.button({
		contents: '<i class="fa-brands fa-youtube" style="color: red;"></i> YouTube',
		click: function () {
			Swal.fire({
				title: 'YouTube',
				text: 'Pega el enlace del video:',
				input: 'url',
				inputPlaceholder: 'https://www.youtube.com/watch?v=...',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Siguiente <i class="fa-solid fa-arrow-right"></i>',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed && result.value) {
					var url = result.value;
					var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
					var match = url.match(regExp);

					if (match && match[2].length === 11) {
						var videoId = match[2];
						
						// Si la URL es válida, pedimos el tamaño con otro SweetAlert
						Swal.fire({
							title: 'Tamaño del video',
							text: '¿Qué ancho quieres que ocupe?',
							input: 'select',
							inputOptions: {
								'100': '100% (Todo el ancho)',
								'75': '75% (Grande y centrado)',
								'50': '50% (Mediano y centrado)'
							},
							inputPlaceholder: 'Selecciona un tamaño',
							showCancelButton: true,
							confirmButtonText: 'Insertar',
							cancelButtonText: 'Cancelar'
						}).then((resTamano) => {
							if (resTamano.isConfirmed && resTamano.value) {
								var claseAncho = "w-100";
								if (resTamano.value === "75") claseAncho = "w-75 mx-auto";
								if (resTamano.value === "50") claseAncho = "w-50 mx-auto";

								var iframeHtml =
									'<div class="' + claseAncho + ' my-4">' +
									'<div class="ratio ratio-16x9">' +
									'<iframe src="https://www.youtube.com/embed/' + videoId + '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>' +
									"</div></div><p>Escribe tu texto aquí...</p>";

								context.invoke("editor.pasteHTML", iframeHtml);
							}
						});
					} else {
						Swal.fire('Oops...', 'No parece un enlace válido de YouTube.', 'error');
					}
				}
			});
		},
	});
	return button.render();
};

// --- NUESTRA FUNCIÓN PARA INSERTAR INSTAGRAM ---
var BotonInstagram = function(context) {
    var ui = $.summernote.ui;
    var button = ui.button({
        contents: '<i class="fa-brands fa-instagram" style="color: #E1306C;"></i> Instagram', 
        click: function() {
			Swal.fire({
				title: 'Instagram',
				text: 'Pega el enlace del Post o Reel:',
				input: 'url',
				showCancelButton: true,
				confirmButtonText: 'Insertar',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed && result.value) {
					var url = result.value;
					var regExp = /(?:instagram\.com.*(?:\/p\/|\/reel\/|\/tv\/))([^\/\?]+)/i;
					var match = url.match(regExp);
					
					if (match && match[1]) {
						var instaId = match[1];
						var iframeHtml = '<div class="d-flex justify-content-center my-4">' +
										 '<iframe src="https://www.instagram.com/p/' + instaId + '/embed/captioned" width="400" height="550" frameborder="0" scrolling="no" allowtransparency="true" style="border: 1px solid #dbdbdb; border-radius: 4px; box-shadow: none; max-width: 100%;"></iframe>' +
										 '</div><p>Escribe tu texto aquí...</p>';
						
						context.invoke('editor.pasteHTML', iframeHtml);
					} else {
						Swal.fire('Oops...', 'Asegúrate de copiar el enlace directo al Post o Reel.', 'error');
					}
				}
			});
        }
    });
    return button.render();
}

// --- NUESTRA FUNCIÓN PARA INSERTAR X (TWITTER) ---
var BotonX = function(context) {
    var ui = $.summernote.ui;
    var button = ui.button({
        contents: '<i class="fa-brands fa-x-twitter" style="color: black;"></i> Post de X', 
        click: function() {
			Swal.fire({
				title: 'X (Twitter)',
				text: 'Pega el enlace del post:',
				input: 'url',
				showCancelButton: true,
				confirmButtonText: 'Insertar',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed && result.value) {
					var url = result.value;
					var regExp = /^https?:\/\/(?:www\.)?(?:x\.com|twitter\.com)\/(?:#!\/)?(\w+)\/status(?:es)?\/(\d+)/i;
					var match = url.match(regExp);
					
					if (match && match[2]) {
						var xHtml = '<div class="d-flex justify-content-center my-4">' +
									'<blockquote class="twitter-tweet" data-theme="light">' +
									'<a href="' + url + '"></a>' +
									'</blockquote></div><p>Escribe tu texto aquí...</p>';
						
						context.invoke('editor.pasteHTML', xHtml);

						if (!$('#x-widget-script').length) {
							$('head').append('<script id="x-widget-script" async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>');
						} else if (typeof twttr !== 'undefined' && twttr.widgets) {
							twttr.widgets.load();
						}
					} else {
						Swal.fire('Oops...', 'El enlace de X no parece válido.', 'error');
					}
				}
			});
        }
    });
    return button.render();
}

// --- NUEVA FUNCIÓN PARA INSERTAR FACEBOOK ---
var BotonFacebook = function(context) {
    var ui = $.summernote.ui;
    var button = ui.button({
        contents: '<i class="fa-brands fa-facebook" style="color: #1877F2;"></i> Facebook', 
        click: function() {
			Swal.fire({
				title: 'Facebook',
				text: 'Pega el enlace de la publicación o video de Facebook:',
				input: 'url',
				showCancelButton: true,
				confirmButtonText: 'Insertar',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed && result.value) {
					var url = result.value;
					// Chequeo básico para saber si es de Facebook
					var regExp = /facebook\.com|fb\.watch/i;
					
					if (regExp.test(url)) {
						// Para Facebook, usamos su iframe oficial codificando la URL que pega el usuario
						var encodedUrl = encodeURIComponent(url);
						var iframeHtml = '<div class="d-flex justify-content-center my-4">' +
										 '<iframe src="https://www.facebook.com/plugins/post.php?href=' + encodedUrl + '&show_text=true&width=500" width="500" height="600" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>' +
										 '</div><p>Escribe tu texto aquí...</p>';
						
						context.invoke('editor.pasteHTML', iframeHtml);
					} else {
						Swal.fire('Oops...', 'Asegúrate de copiar un enlace válido desde Facebook.', 'error');
					}
				}
			});
        }
    });
    return button.render();
}

// --- NUESTRA FUNCIÓN REFORZADA PARA DARLE MARGEN A LAS FOTOS ---
var BotonMargen = function (context) {
	var ui = $.summernote.ui;
	var button = ui.button({
		contents: '<i class="fa-solid fa-expand"></i> Dar Aire',
		click: function (e) {
			e.preventDefault();
			var target = context.invoke("editor.restoreTarget");
			var $foto = target && target[0] ? $(target[0]) : imagenActiva;

			if ($foto && $foto.length > 0 && $foto.is("img")) {
				Swal.fire({
					title: 'Dar Aire a la foto',
					text: '¿Cuántos píxeles de espacio quieres darle? (Ejemplo: 20)',
					input: 'number',
					inputValue: 20,
					showCancelButton: true,
					confirmButtonText: 'Aplicar',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed && result.value) {
						$foto.css({
							margin: result.value + "px",
							display: "inline-block",
						});
						context.invoke("editor.saveRange");
					}
				});
			} else {
				Swal.fire('Atención', 'No se detectó la foto. Haz clic sobre la imagen antes de presionar el botón.', 'warning');
			}
		},
	});
	return button.render();
};

function init() {
	// 1. INICIALIZAMOS SUMMERNOTE CON NUESTROS 5 BOTONES MÁGICOS
	$("#cuerpo").summernote({
		placeholder:
		  "Escribe el desarrollo de la noticia aquí. Puedes arrastrar y soltar fotos directamente dentro de esta caja de texto...",
		tabsize: 2,
		height: 600,
		minHeight: 400,
		lang: "es-ES",

		buttons: {
		  botonAire: BotonMargen,
		  botonVideo: BotonVideo,
		  botonInstagram: BotonInstagram,
		  botonX: BotonX,
		  botonFacebook: BotonFacebook // <--- Agregamos Facebook
		},

		popover: {
		  image: [
			["dimensiones", ["resizeFull", "resizeHalf", "resizeQuarter", "resizeNone"]],
			["alineacion", ["floatLeft", "floatRight", "floatNone"]],
			["espaciado", ["botonAire"]],
			["borrar", ["removeMedia"]],
		  ],
		},

		toolbar: [
		  ["style", ["style"]],
		  ["font", ["bold", "italic", "underline", "clear"]],
		  ["color", ["color"]],
		  ["para", ["ul", "ol", "paragraph"]],
		  ["table", ["table"]],
		  // AQUÍ ENFILAMOS TODOS LOS BOTONES DE REDES SOCIALES INCLUYENDO FB
		  ["insert", ["link", "picture", "botonVideo", "botonInstagram", "botonX", "botonFacebook"]],
		  ["view", ["fullscreen", "codeview"]],
		],
	});

	// 2. DESPUÉS HACEMOS LO DEMÁS
	mostrarform(false);
	listar();


	$("#formulario").off("submit").on("submit", function (e) {
		e.preventDefault(); // Corta en seco cualquier comportamiento por defecto
		guardaryeditar(e);
	});

	$.post("../ajax/noticia.php?op=selectCategoria", function (r) {
		$("#idcategoria").html(r);
	});

	// PREVISUALIZAR IMAGEN AL SELECCIONARLA
	$("#imagen").change(function () {
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#imagenmuestra").attr("src", e.target.result).show();
				$("#imagenmuestra").css({
					width: "200px",
					"aspect-ratio": "16/9",
					"object-fit": "cover",
				});
			};
			reader.readAsDataURL(this.files[0]);
		} else {
			$("#imagenmuestra").hide().attr("src", "");
		}
	});
}

function limpiar() {
	$("#idnoticia").val("");
	$("#titulo").val("");
	$("#resumen").val("");
	$("#explicacion_calificacion").val("");
	$("#imagenmuestra").attr("src", "").hide();
	$("#imagenactual").val("");
	$("#imagen").val("");
	$("#cuerpo").summernote("code", "");
}

function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

function cancelarform() {
	mostrarform(false);
}

function listar() {
	tabla = $("#tbllistado").DataTable({
		ajax: {
			url: "../ajax/noticia.php?op=listar",
			type: "get",
			dataType: "json",
		},
		language: {
			sProcessing: "Procesando...",
			sLengthMenu: "Mostrar _MENU_ registros",
			sZeroRecords: "No se encontraron resultados",
			sEmptyTable: "Ningún dato disponible en esta tabla",
			sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
			sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
			sSearch: "Buscar:",
			sLoadingRecords: "Cargando...",
			oPaginate: {
				sFirst: "Primero",
				sLast: "Último",
				sNext: "Siguiente",
				sPrevious: "Anterior",
			},
		},
	});
}



// Variable global que funciona como candado
// Candado global
var procesando_envio = false;

function guardaryeditar(e) {
    // Si viene un evento, lo frenamos
    if(e) e.preventDefault(); 

    if (procesando_envio === true) {
        return; 
    }

    // Pasamos el texto de Summernote al textarea oculto ANTES de armar el FormData
    if ($('#cuerpo').length) {
        $('#cuerpo').val($('#cuerpo').summernote('code'));
    }

    procesando_envio = true;
    var btnContenidoOriginal = $("#btnGuardar").html(); 
    $("#btnGuardar").prop("disabled", true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Guardando...');
    
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/noticia.php?op=guardaryeditar", 
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            Swal.fire({
                title: '¡Listo!',
                text: datos,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
            mostrarform(false);
            if (typeof tabla !== 'undefined') tabla.ajax.reload();
            
            $("#btnGuardar").prop("disabled", false).html(btnContenidoOriginal);
            procesando_envio = false;
        },
        error: function(error) {
            console.log("Error crítico de AJAX:", error);
            Swal.fire({
                title: 'Error',
                text: 'Revisar consola (F12). Posible error de PHP en local.',
                icon: 'error'
            });
            $("#btnGuardar").prop("disabled", false).html(btnContenidoOriginal);
            procesando_envio = false;
        }
    });
}



function mostrar(idnoticia) {
	$.post(
		"../ajax/noticia.php?op=mostrar",
		{ idnoticia: idnoticia },
		function (data) {
			data = JSON.parse(data);
			mostrarform(true);
			$("#idnoticia").val(data.idnoticia);
			$("#titulo").val(data.titulo);
			$("#idcategoria").val(data.idcategoria);
			$("#resumen").val(data.resumen);
			$("#autor").val(data.autor);
			$("#calificacion").val(data.calificacion);
			$("#explicacion_calificacion").val(data.explicacion_calificacion);
			$("#cuerpo").summernote("code", data.cuerpo);
			$("#imagenmuestra").show();
			$("#imagenmuestra").attr("src", "../public/files/noticias/" + data.imagen);
			$("#imagenactual").val(data.imagen);
			$("#imagenmuestra").css({
				width: "200px",
				"aspect-ratio": "16/9",
				"object-fit": "cover",
			});
		},
	);
}

function desactivar(idnoticia) {
	// REEMPLAZAMOS BOOTBOX POR SWEETALERT
	Swal.fire({
		title: '¿Estás seguro?',
		text: "¿Quieres desactivar esta noticia?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, desactivar',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if (result.isConfirmed) {
			$.post(
				"../ajax/noticia.php?op=desactivar",
				{ idnoticia: idnoticia },
				function (e) {
					tabla.ajax.reload();
					Swal.fire('Desactivada', 'La noticia ha sido desactivada.', 'success');
				}
			);
		}
	});
}

function activar(idnoticia) {
	// REEMPLAZAMOS BOOTBOX POR SWEETALERT
	Swal.fire({
		title: '¿Estás seguro?',
		text: "¿Quieres volver a activar esta noticia?",
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, activar',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if (result.isConfirmed) {
			$.post(
				"../ajax/noticia.php?op=activar",
				{ idnoticia: idnoticia },
				function (e) {
					tabla.ajax.reload();
					Swal.fire('Activada', 'La noticia vuelve a estar pública.', 'success');
				}
			);
		}
	});
}

$("#titulo").on("input", function() {
    var limite = 100;
    var actual = $(this).val().length;
    $("#titulo_count").text(actual + "/" + limite);
    
    if (actual >= limite) {
        $("#titulo_count").css("color", "red");
    } else {
        $("#titulo_count").css("color", "#6c757d");
    }
});

init();