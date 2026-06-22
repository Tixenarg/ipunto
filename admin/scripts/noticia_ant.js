var tabla;
var contadorSecciones = 0; // Inicia en 0 para que la función limpiar() agregue la primera

function init() {
	// MAGIA ULTRA UX EXCLUSIVA: Inyectamos estilos premium para fotos, zonas de carga y animaciones
	$("<style>")
		.prop("type", "text/css")
		.html(
			`
			#imagenmuestra, .preview-img {
				width: 100% !important;
				height: 100% !important;
				object-fit: cover !important;
				object-position: center center !important;
				border-radius: inherit !important;
			}
			.seccion-card {
				animation: fadeInCard 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
			}
			@keyframes fadeInCard {
				from { opacity: 0; transform: translateY(12px); }
				to { opacity: 1; transform: translateY(0); }
			}
			.drop-zone { transition: all 0.25s ease-in-out !important; }
			.drop-zone:hover {
				border-color: #0d6efd !important;
				background-color: #f0f7ff !important;
				transform: scale(1.02);
				box-shadow: 0 4px 12px rgba(13, 110, 253, 0.08) !important;
			}
			.drop-zone:hover .placeholder-content i { color: #0d6efd !important; transform: translateY(-2px); }
			.drop-zone .placeholder-content i { transition: transform 0.2s ease, color 0.2s ease; }
			.form-control:focus {
				box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15) !important;
				border-color: #0d6efd !important;
			}
			/* Estilo para los separadores del preview en vivo */
			.preview-separador-bloque {
				border: 0;
				height: 1px;
				background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0));
				margin: 40px 0;
			}
		`,
		)
		.appendTo("head");

	// 1. Mostrar listado al inicio
	mostrarform(false);
	listar();

	// 2. Controlar el envío del nuevo formulario
	$("#formulario")
		.off("submit")
		.on("submit", function (e) {
			e.preventDefault();
			guardaryeditar(e);
		});

	// INTERCEPTOR INTELIGENTE: Botón Previsualizar Nota
	$("#btnPrevisualizar").on("click", function () {
		construirPrevisualizacionEnVivo();
	});

	// BOTÓN INTERNO DEL MODAL: Permite publicar directo desde el preview
	$("#btnConfirmarPublicacionDesdePreview")
		.off("click")
		.on("click", function (e) {
			e.preventDefault();
			$("#modalPreview").modal("hide");
			guardaryeditar(); // CORRECCIÓN: Llama directo al motor de guardado sin fallar
		});

	// 5. Contador de caracteres para el título
	$("#titulo").on("input", function () {
		var limite = 100;
		var actual = $(this).val().length;
		$("#titulo_count").text(actual + "/" + limite);
		if (actual >= limite) {
			$("#titulo_count").css("color", "red");
		} else {
			$("#titulo_count").css("color", "#6c757d");
		}
	});
}

// ==========================================
// PREVISUALIZACIÓN UX/UI GLOBAL (Portada y Secciones)
// ==========================================
$(document).on("change", ".file-upload-input", function () {
	var archivo = this.files[0];
	var dropZone = $(this).closest(".drop-zone");
	var preview = dropZone.find(".preview-img");
	var placeholder = dropZone.find(".placeholder-content");

	if (archivo) {
		var reader = new FileReader();
		reader.onload = function (e) {
			preview.attr("src", e.target.result).fadeIn();
			placeholder.hide();
		};
		reader.readAsDataURL(archivo);
	} else {
		preview.hide().attr("src", "");
		placeholder.fadeIn();
	}
});

// ==========================================
// FUNCIÓN DE BLOQUES DINÁMICOS REDISEÑADA (NIVEL DIOS)
// ==========================================
function agregarSeccion() {
	contadorSecciones++;

	const htmlBloque = `
        <div class="card mb-4 seccion-card border-0 shadow-sm" style="border-left: 5px solid #0d6efd !important; border-radius: 10px; background-color: #ffffff;">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-0 py-2 px-3" style="border-top-right-radius: 10px; background-color: #f8fafc;">
                <span class="numero-seccion" style="background-color: #e7f1ff; color: #0d6efd; font-weight: 700; border-radius: 6px; padding: 4px 10px; font-size: 0.85rem;">Bloque ${contadorSecciones}</span>
                <button type="button" class="btn btn-sm text-danger border-0 p-0 d-flex align-items-center" onclick="eliminarSeccion(this)" title="Eliminar bloque" style="background: none; gap: 4px;">
                    <i class="fa fa-trash"></i> <span style="font-size: 0.85rem;" class="fw-bold">Eliminar bloque</span>
                </button>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-8 col-lg-9 order-2 order-md-1">
                        
                        <div class="form-group mb-2" style="max-width: 280px;">
                            <label class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.72rem; letter-spacing: 0.8px;">Volanta / Categoría del Bloque <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm text-uppercase fw-bold text-secondary" name="categorias_seccion[]" placeholder="Ej: POLÍTICA, ACTUALIDAD..." style="border-radius: 6px; background-color: #fdfdfd; font-size: 0.8rem; letter-spacing: 0.5px; border-color: #cbd5e1;" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bold mb-1 text-muted small" style="font-size: 0.88rem;">Subtítulo Destacado <span class="text-muted fw-normal">(Opcional)</span></label>
                            <input type="text" class="form-control form-control-lg fw-bold text-dark" name="subtitulos[]" placeholder="Escribí un subtítulo o dejalo en blanco si es un párrafo continuo..." style="border-radius: 8px; font-size: 1.25rem; border-color: #cbd5e1;">
                        </div>

                        <div class="form-group mb-0">
                            <label class="fw-bold mb-1 text-muted small">Cuerpo del Bloque <span class="text-danger">*</span></label>
                            <div style="max-width: 680px;">
                                <textarea class="form-control shadow-inner" name="cuerpos_seccion[]" rows="5" placeholder="Escribí el desarrollo de este párrafo. Acordate: bloques cortos, concisos y directo al grano..." style="font-size: 0.95rem; line-height: 1.6; resize: vertical; background-color: #fafafa; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px;" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 mb-4 mb-md-0 order-1 order-md-2 d-flex flex-column align-items-md-center justify-content-start">
                        <label class="fw-bold mb-2 text-muted small align-self-start align-self-md-center">Foto Opcional</label>
                        <div class="drop-zone dz-seccion shadow-sm" style="width: 100%; max-width: 240px; aspect-ratio: 16/9; position: relative; border: 2px dashed #cbd5e1; border-radius: 12px; background-color: #f8fafc; overflow: hidden; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; cursor: pointer;">
                            <div class="placeholder-content text-center text-muted p-2">
                                <i class="fa fa-image mb-1" style="font-size: 1.4rem; color: #64748b;"></i>
                                <span class="d-block fw-bold text-secondary" style="font-size: 0.75rem;">Subir imagen</span>
                                <span class="text-muted d-block" style="font-size: 0.65rem;">(Obligatorio - Formato 3:2 - 1200x800)</span>
                            </div>
                            <input type="file" class="file-upload-input" name="imagenes_seccion[]" accept="image/jpeg, image/png, image/webp" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 2;">
                            <img src="" class="preview-img" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1; display: none;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

	$("#contenedor-secciones").append(htmlBloque);
}

function eliminarSeccion(boton) {
	var tarjeta = $(boton).closest(".seccion-card");
	tarjeta.animate({ opacity: 0, marginTop: "-20px" }, 250, function () {
		tarjeta.remove();
		actualizarNumeros();
	});
}

function actualizarNumeros() {
	contadorSecciones = 0;
	$(".numero-seccion").each(function () {
		contadorSecciones++;
		$(this).text("Bloque " + contadorSecciones);
	});
}

// ==========================================
// FUNCIONES CRUD TRADICIONALES
// ==========================================

function limpiar() {
	$("#idnoticia").val("");
	$("#titulo").val("");
	$("#resumen").val("");
	$("#cuerpo").val("");
	$("#autor").val("Redacción I.");
	$("#idcategoria").val("1");
	$("#imagenmuestra").attr("src", "").hide();
	$("#imagenactual").val("");
	$("#imagen").val("");

	// PROTECCIÓN EXCLUSIVA: Reiniciamos las opciones nativas del select de clasificación para que no se pierdan
	$("#clasificacion").html(`
		<option value="" disabled selected>Seleccione Clasificación...</option>
		<option value="Noticia">Noticia Estándar</option>
		<option value="Destacada">Nota Destacada</option>
		<option value="Urgente">Alerta / Último Momento</option>
		<option value="Opinion">Artículo de Opinión</option>
	`);

	$("#contenedor-secciones").empty();
	contadorSecciones = 0;
	agregarSeccion();
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

function mostrar(idnoticia) {
	limpiar();
	mostrarform(true);

	$.post(
		RUTA_BASE + "ajax/noticia.php?op=mostrar",
		{ idnoticia: idnoticia },
		function (data, status) {
			if (typeof data === "string") {
				data = JSON.parse(data);
			}

			// 1. Rellenamos la noticia principal
			$("#idnoticia").val(data.idnoticia);
			$("#idcategoria").val(data.idcategoria);
			$("#titulo").val(data.titulo);
			$("#resumen").val(data.resumen);
			$("#cuerpo").val(data.cuerpo);
			$("#autor").val(data.autor);
			$("#explicacion_calificacion").val(data.explicacion_calificacion);

			// ==========================================
			// FIX DEFINITIVO: SELECTOR INTELIGENTE DE CLASIFICACIÓN
			// ==========================================
			var valorBd = (data.calificacion || data.clasificacion || "").trim();
			var selectCalificacion =
				$("#calificacion").length > 0 ? $("#calificacion") : $("#clasificacion");

			if (valorBd !== "") {
				var encontrado = false;
				selectCalificacion.find("option").each(function () {
					if (
						$(this).val().toLowerCase() === valorBd.toLowerCase() ||
						$(this).text().toLowerCase() === valorBd.toLowerCase()
					) {
						selectCalificacion.val($(this).val());
						encontrado = true;
					}
				});
				// Si no encuentra coincidencia, asume Noticia por seguridad
				if (!encontrado) selectCalificacion.val("Noticia");
			} else {
				selectCalificacion.val("Noticia");
			}
			// ==========================================

			$("#titulo").trigger("input");

			if (data.imagen) {
				$("#imagenmuestra").show();
				$("#imagenmuestra").attr("src", "../public/files/noticias/" + data.imagen);
				$("#imagenactual").val(data.imagen);
			} else {
				$("#imagenmuestra").hide();
				$("#imagenactual").val("");
			}

			// 3. Renderizado de los bloques dinámicos guardados (Diseño Premium)
			$("#contenedor-secciones").empty();
			contadorSecciones = 0;

			if (data.secciones && data.secciones.length > 0) {
				data.secciones.forEach(function (seccion, index) {
					contadorSecciones++;

					let tieneImagen = seccion.imagen && seccion.imagen !== "";
					let srcImagen = tieneImagen
						? `../public/files/noticias/${seccion.imagen}`
						: "";

					let htmlBloque = `
                    <div class="card mb-4 seccion-card border-0 shadow-sm" style="border-left: 5px solid #0d6efd !important; border-radius: 10px; background-color: #ffffff;">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom-0 py-2 px-3" style="border-top-right-radius: 10px; background-color: #f8fafc;">
                            <span class="numero-seccion" style="background-color: #e7f1ff; color: #0d6efd; font-weight: 700; border-radius: 6px; padding: 4px 10px; font-size: 0.85rem;">Bloque ${contadorSecciones}</span>
                            <button type="button" class="btn btn-sm text-danger border-0 p-0 d-flex align-items-center" onclick="eliminarSeccion(this)" title="Eliminar bloque" style="background: none; gap: 4px;">
                                <i class="fa fa-trash"></i> <span style="font-size: 0.85rem;" class="fw-bold">Eliminar bloque</span>
                            </button>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-8 col-lg-9 order-2 order-md-1">
                                    <div class="form-group mb-2" style="max-width: 280px;">
                                        <label class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.72rem; letter-spacing: 0.8px;">Volanta / Categoría del Bloque <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm text-uppercase fw-bold text-secondary" name="categorias_seccion[]" value="${seccion.categoria_seccion || ""}" placeholder="Ej: POLÍTICA, ACTUALIDAD..." style="border-radius: 6px; background-color: #fdfdfd; font-size: 0.8rem; letter-spacing: 0.5px; border-color: #cbd5e1;" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="fw-bold mb-1 text-muted small" style="font-size: 0.88rem;">Subtítulo Destacado <span class="text-muted fw-normal">(Opcional)</span></label>
                                        <input type="text" class="form-control form-control-lg fw-bold text-dark" name="subtitulos[]" value="${seccion.subtitulo || ""}" placeholder="Escribí un subtítulo o dejalo en blanco si es un párrafo continuo..." style="border-radius: 8px; font-size: 1.25rem; border-color: #cbd5e1;">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="fw-bold mb-1 text-muted small">Cuerpo del Bloque <span class="text-danger">*</span></label>
                                        <div style="max-width: 680px;">
                                            <textarea class="form-control shadow-inner" name="cuerpos_seccion[]" rows="5" placeholder="Escribí el desarrollo de este párrafo..." style="font-size: 0.95rem; line-height: 1.6; resize: vertical; background-color: #fafafa; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px;" required>${seccion.cuerpo || ""}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3 mb-4 mb-md-0 order-1 order-md-2 d-flex flex-column align-items-md-center justify-content-start">
                                    <label class="fw-bold mb-2 text-muted small align-self-start align-self-md-center">Foto Opcional</label>
                                    <div class="drop-zone dz-seccion shadow-sm" style="width: 100%; max-width: 240px; aspect-ratio: 16/9; position: relative; border: 2px dashed #cbd5e1; border-radius: 12px; background-color: #f8fafc; overflow: hidden; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; cursor: pointer;">
                                        <div class="placeholder-content text-center text-muted p-2" style="${tieneImagen ? "display:none;" : ""}">
                                            <i class="fa fa-image mb-1" style="font-size: 1.4rem; color: #64748b;"></i>
                                            <span class="d-block fw-bold text-secondary" style="font-size: 0.75rem;">Subir imagen</span>
                                            <span class="text-muted d-block" style="font-size: 0.65rem;">Formato horizontal 16:9</span>
                                        </div>
                                        <input type="file" class="file-upload-input" name="imagenes_seccion[]" accept="image/jpeg, image/png, image/webp" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 2;">
                                        <input type="hidden" name="imagenes_seccion_actuales[]" value="${seccion.imagen || ""}">
                                        <img src="${srcImagen}" class="preview-img" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1; ${tieneImagen ? "display:block;" : "display:none;"}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
					$("#contenedor-secciones").append(htmlBloque);
				});
			} else {
				agregarSeccion();
			}
		},
	);
}

// Variable global para recordar qué pestaña estamos viendo
var filtroActual = "activas";

function listar() {
	tabla = $("#tbllistado").DataTable({
		ajax: {
			url: RUTA_BASE + "ajax/noticia.php?op=listar",
			type: "get",
			dataType: "json",
		},
		autoWidth: false,
		responsive: true,
		columnDefs: [
			{ targets: 0, width: "120px", className: "text-center align-middle" },
			{ targets: 1, width: "100px", className: "text-center align-middle" },
			{ targets: 2, className: "align-middle" },
			{ targets: 3, width: "140px", className: "text-center align-middle" },
			{ targets: 4, width: "110px", className: "text-center align-middle" },
		],
		language: {
			sProcessing: "Procesando...",
			sLengthMenu: "Mostrar _MENU_ registros",
			sZeroRecords: "No se encontraron resultados",
			sEmptyTable: "Ningún dato disponible en esta tabla",
			sInfo:
				"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
			sSearch: "Buscar nota rápida:",
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

function cambiarFiltro(nuevoFiltro) {
	filtroActual = nuevoFiltro;

	$(".nav-pills .nav-link").removeClass("active").addClass("text-secondary");
	$("#tab-" + nuevoFiltro)
		.addClass("active")
		.removeClass("text-secondary");

	tabla.ajax
		.url(RUTA_BASE + "ajax/noticia.php?op=listar&filtro=" + filtroActual)
		.load();
}

var procesando_envio = false;
function guardaryeditar(e) {
	if (e) e.preventDefault();

	if (procesando_envio === true) return;

	procesando_envio = true;
	var btnContenidoOriginal = $("#btnGuardar").html();
	$("#btnGuardar")
		.prop("disabled", true)
		.html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Guardando...');

	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: RUTA_BASE + "ajax/noticia.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			Swal.fire({
				title: "¡Sistema Actualizado!",
				text: datos,
				icon: "success",
				confirmButtonText: "Aceptar",
			});
			mostrarform(false);
			if (typeof tabla !== "undefined") tabla.ajax.reload();

			$("#btnGuardar").prop("disabled", false).html(btnContenidoOriginal);
			procesando_envio = false;
		},
		error: function (error) {
			console.log("Error crítico de AJAX:", error);
			Swal.fire({
				title: "Error",
				text: "Hubo un error al procesar el servidor. Revisa la consola (F12).",
				icon: "error",
			});
			$("#btnGuardar").prop("disabled", false).html(btnContenidoOriginal);
			procesando_envio = false;
		},
	});
}

function desactivar(idnoticia) {
	Swal.fire({
		title: "¿Estás seguro?",
		text: "¿Quieres desactivar esta noticia?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sí, desactivar",
		cancelButtonText: "Cancelar",
	}).then((result) => {
		if (result.isConfirmed) {
			$.post(
				"../ajax/noticia.php?op=desactivar",
				{ idnoticia: idnoticia },
				function (e) {
					tabla.ajax.reload();
					Swal.fire("Desactivada", "La noticia ha sido desactivada.", "success");
				},
			);
		}
	});
}

function activar(idnoticia) {
	Swal.fire({
		title: "¿Estás seguro?",
		text: "¿Quieres volver a activar esta noticia?",
		icon: "question",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sí, activar",
		cancelButtonText: "Cancelar",
	}).then((result) => {
		if (result.isConfirmed) {
			$.post(
				"../ajax/noticia.php?op=activar",
				{ idnoticia: idnoticia },
				function (e) {
					tabla.ajax.reload();
					Swal.fire("Activada", "La noticia vuelve a estar pública.", "success");
				},
			);
		}
	});
}


        // ==========================================
        // MOTOR DE MAQUETACIÓN EN VIVO (ANTI-CACHÉ)
        // ==========================================
        function construirPrevisualizacionEnVivo() {
            // 1. Cabecera
            var categoriaTexto = $("#idcategoria option:selected").text();
            $("#preview-principal-categoria").text(categoriaTexto === "Seleccione Categoría" ? "GENERAL" : categoriaTexto);
            $("#preview-principal-titulo").text($("#titulo").val() || "Sin título cargado todavía");
            $("#preview-principal-resumen").text($("#resumen").val() || "");
            $("#preview-principal-autor").text($("#autor").val() || "Redacción I.");

            var cuerpoPrincipal = $("#cuerpo").val() || "";
            $("#preview-principal-cuerpo").html(cuerpoPrincipal ? cuerpoPrincipal.replace(/\n/g, '<br>') : "<i>Sin cuerpo base redactado...</i>");

            // 2. Foto portada (Arreglado para que no falle por CSS del dropzone)
            var inputFotoPrincipal = document.getElementById('imagen');
            var srcMuestra = $("#imagenmuestra").attr("src");

            if (inputFotoPrincipal && inputFotoPrincipal.files && inputFotoPrincipal.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#preview-principal-img").attr("src", e.target.result).show();
                }
                reader.readAsDataURL(inputFotoPrincipal.files[0]);
            } else if (srcMuestra && srcMuestra.trim() !== "") {
                $("#preview-principal-img").attr("src", srcMuestra).show();
            } else {
                // Si no hay foto de ninguna forma, escondemos todo
                $("#preview-principal-img").hide().attr("src", "");
            }

            // 3. Bloques limpios sin basura
            var contenedorDestino = $("#preview-contenedor-bloques");
            contenedorDestino.empty();

            $(".seccion-card").each(function(index, elemento) {
                var bloque = $(elemento);
                var volanta = bloque.find("input[name='categorias_seccion[]']").val() || "";
                var subtitulo = bloque.find("input[name='subtitulos[]']").val() || "";
                var cuerpoBloque = bloque.find("textarea[name='cuerpos_seccion[]']").val() || "";

                var inputImgBloque = bloque.find(".file-upload-input")[0];
                var srcMuestraBloque = bloque.find(".preview-img").attr("src");
                var idImgUnica = "preview-img-bloque-" + index;

                var htmlBloquePreview = `
			${index > 0 ? '<hr style="border: 0; border-top: 1px solid #fca5a5; margin: 40px 0; opacity: 0.8;">' : ''}
			<div class="row align-items-start mb-4">
				<div class="col-md-8 col-lg-9 order-2 order-md-1">
					<div style="border-left: 4px solid #da251d; padding-left: 20px; margin-bottom: 15px;">
						${volanta ? '<span class="text-uppercase fw-bold d-block mb-2" style="color: #da251d; font-size: 0.85rem; letter-spacing: 0.5px;">' + volanta + '</span>' : ''}
						${subtitulo ? '<h3 class="text-dark mb-3" style="font-weight: 900; font-size: 1.6rem; line-height: 1.3; letter-spacing: -0.5px;">' + subtitulo + '</h3>' : ''}
						<div class="text-secondary" style="font-size: 1.05rem; line-height: 1.7; color: #333 !important;">
							${cuerpoBloque.replace(/\n/g, '<br>')}
						</div>
					</div>
				</div>
				<div class="col-md-4 col-lg-3 order-1 order-md-2 mb-3 mb-md-0" id="contenedor-img-${idImgUnica}">
					<img id="${idImgUnica}" src="" style="width:100%; border-radius:8px; object-fit:cover; display:none;">
				</div>
			</div>
		`;

                contenedorDestino.append(htmlBloquePreview);

                if (inputImgBloque && inputImgBloque.files && inputImgBloque.files[0]) {
                    var readerBloque = new FileReader();
                    readerBloque.onload = function(e) {
                        $("#" + idImgUnica).attr("src", e.target.result).show();
                    }
                    readerBloque.readAsDataURL(inputImgBloque.files[0]);
                } else if (srcMuestraBloque && srcMuestraBloque.trim() !== "") {
                    $("#" + idImgUnica).attr("src", srcMuestraBloque).show();
                } else {
                    $("#contenedor-img-" + idImgUnica).remove();
                    contenedorDestino.children().last().find(".col-md-8").removeClass("col-md-8 col-lg-9").addClass("col-12");
                }
            });

            $("#modalPreview").modal("show");
        }
// INICIALIZACIÓN DE SCRIPT
init();
