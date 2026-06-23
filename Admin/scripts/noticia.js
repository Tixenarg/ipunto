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
	var col = $(this).closest(".col-md-4");
	var btnQuitar = col.find(".btn-quitar-foto-seccion");

	if (archivo) {
		var reader = new FileReader();
		reader.onload = function (e) {
			preview.attr("src", e.target.result).fadeIn();
			placeholder.hide();
			if (btnQuitar.length) btnQuitar.show(); // Mostrar el botón de anular si se cargó una foto
		};
		reader.readAsDataURL(archivo);
	} else {
		preview.hide().attr("src", "");
		placeholder.fadeIn();
		if (btnQuitar.length) btnQuitar.hide();
	}
});

// ==========================================
// ACCIÓN PARA ANULAR FOTO EN SECCIONES (REQUERIMIENTO 2)
// ==========================================
function quitarFotoSeccion(boton) {
	var col = $(boton).closest(".col-md-4");
	var dropZone = col.find(".drop-zone");
	var preview = dropZone.find(".preview-img");
	var placeholder = dropZone.find(".placeholder-content");
	var fileInput = dropZone.find(".file-upload-input");
	var hiddenInput = col.find("input[name='imagenes_seccion_actuales[]']");

	fileInput.val(""); // Resetea el selector de archivos
	if (hiddenInput.length) {
		hiddenInput.val(""); // Resetea el campo oculto de la BD para que guarde vacío
	}
	preview.hide().attr("src", "");
	placeholder.fadeIn();
	$(boton).hide(); // Esconde el botón de quitar foto
}

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
                        <div class="drop-zone dz-seccion shadow-sm" style="width: 100%; max-width: 240px; aspect-ratio: 3 / 2; position: relative; border: 2px dashed #cbd5e1; border-radius: 12px; background-color: #f8fafc; overflow: hidden; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; cursor: pointer;">
                            <div class="placeholder-content text-center text-muted p-2">
                                <i class="fa fa-image mb-1" style="font-size: 1.4rem; color: #64748b;"></i>
                                <span class="d-block fw-bold text-secondary" style="font-size: 0.75rem;">Subir imagen</span>
                                <span class="text-muted d-block" style="font-size: 0.65rem;">(Opcional - Formato 3:2)</span>
                            </div>
                            <input type="file" class="file-upload-input" name="imagenes_seccion[]" accept="image/jpeg, image/png, image/webp" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 2;">
                            <img src="" class="preview-img" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1; display: none;">
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 mt-2 fw-bold btn-quitar-foto-seccion" onclick="quitarFotoSeccion(this)" style="font-size: 0.8rem; display: none; text-decoration: none;">
                            <i class="fa-solid fa-image-slash me-1"></i> Quitar foto de sección
                        </button>
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
                                    <div class="drop-zone dz-seccion shadow-sm" style="width: 100%; max-width: 240px; aspect-ratio: 3 / 2; position: relative; border: 2px dashed #cbd5e1; border-radius: 12px; background-color: #f8fafc; overflow: hidden; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; cursor: pointer;">
                                        <div class="placeholder-content text-center text-muted p-2" style="${tieneImagen ? "display:none;" : ""}">
                                            <i class="fa fa-image mb-1" style="font-size: 1.4rem; color: #64748b;"></i>
                                            <span class="d-block fw-bold text-secondary" style="font-size: 0.75rem;">Subir imagen</span>
                                            <span class="text-muted d-block" style="font-size: 0.65rem;">Formato 3:2</span>
                                        </div>
                                        <input type="file" class="file-upload-input" name="imagenes_seccion[]" accept="image/jpeg, image/png, image/webp" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 2;">
                                        <input type="hidden" name="imagenes_seccion_actuales[]" value="${seccion.imagen || ""}">
                                        <img src="${srcImagen}" class="preview-img" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1; ${tieneImagen ? "display:block;" : "display:none;"}">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 mt-2 fw-bold btn-quitar-foto-seccion" onclick="quitarFotoSeccion(this)" style="font-size: 0.8rem; ${tieneImagen ? "display: inline-block;" : "display: none;"} text-decoration: none;">
                                        <i class="fa-solid fa-image-slash me-1"></i> Quitar foto de sección
                                    </button>
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

	// --- REQUERIMIENTO 1: VALIDACIÓN DE FOTO DE PORTADA OBLIGATORIA ---
	var tieneNuevaImagen = $("#imagen")[0].files.length > 0;
	var tieneImagenActual = $("#imagenactual").val().trim() !== "";

	if (!tieneNuevaImagen && !tieneImagenActual) {
		Swal.fire({
			title: "¡Foto de Portada Obligatoria!",
			text: "Por favor, selecciona una foto de portada principal. La noticia no puede ser guardada sin su imagen principal.",
			icon: "warning",
			confirmButtonText: "Entendido",
		});
		return; // Frena el proceso por completo
	}
	// ------------------------------------------------------------------

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
// ==========================================
// MOTOR DE MAQUETACIÓN EN VIVO (ESPEJO PÚBLICO)
// ==========================================
// ==========================================
// MOTOR DE MAQUETACIÓN EN VIVO (ESPEJO PÚBLICO VERSIÓN EXACTA)
// ==========================================
// ==========================================
// MOTOR DE MAQUETACIÓN EN VIVO (CON DIVISORES ROJOS)
// ==========================================
// ==========================================
// MOTOR DE MAQUETACIÓN EN VIVO (CON FAVICON CUADRADO)
// ==========================================
function construirPrevisualizacionEnVivo() {
	// 1. Recolectamos los datos de los inputs del formulario
	var categoriaTexto = $("#idcategoria option:selected").text();
	var volanta = categoriaTexto === "Seleccione Categoría" ? "GENERAL" : categoriaTexto;
	var titulo = $("#titulo").val() || "Sin título cargado todavía";
	var resumen = $("#resumen").val() || "";
	var cuerpoPrincipal = $("#cuerpo").val() || "";

	// 2. Procesamos la foto de portada de la noticia principal
	var inputFotoPrincipal = document.getElementById("imagen");
	var srcMuestra = $("#imagenmuestra").attr("src");
	var srcPortada = "";

	if (inputFotoPrincipal && inputFotoPrincipal.files && inputFotoPrincipal.files[0]) {
		srcPortada = URL.createObjectURL(inputFotoPrincipal.files[0]);
	} else if (srcMuestra && srcMuestra.trim() !== "") {
		srcPortada = srcMuestra;
	}

	// 3. ARMAMOS EL CONTENEDOR ESPEJO
	var htmlPreview = `
		<style>
			#modalPreview .modal-body {
				--primary-dark: #1a1a1a;
				--ipunto-red: #c93b28;
				background-color: #ffffff !important;
				color: var(--primary-dark) !important;
				font-family: 'Metropolis', Arial, sans-serif;
				padding: 3rem 1.5rem !important;
				text-align: left !important;
			}
			#modalPreview .article-container {
				max-width: 760px;
				margin: 0 auto;
			}
			#modalPreview .article-hero-title {
				font-family: 'Metropolis', sans-serif;
				font-weight: 900;
				font-size: 2.6rem; 
				line-height: 1.15;
				letter-spacing: -0.03em;
				color: var(--primary-dark);
			}
			#modalPreview .article-lead {
				font-family: 'Metropolis', sans-serif;
				font-size: 1.25rem;
				line-height: 1.6;
				color: #4a4a4a;
				font-weight: normal;
				border-left: 4px solid var(--ipunto-red);
				padding-left: 1.5rem;
				margin-bottom: 1.5rem;
			}
			#modalPreview .article-meta {
				font-family: 'Metropolis', sans-serif;
				font-size: 0.85rem;
				text-transform: uppercase;
				letter-spacing: 1px;
				color: #888;
				border-top: 1px solid #eaeaea;
				border-bottom: 1px solid #eaeaea;
				padding: 0.8rem 0;
				margin-bottom: 2rem;
			}
			#modalPreview .article-hero-image, 
			#modalPreview .seccion-dinamica-img {
				width: 100%;
				height: auto;
				aspect-ratio: 3 / 2;
				border-radius: 8px;
				margin-bottom: 1.5rem;
				object-fit: cover;
			}
			#modalPreview .article-body, 
			#modalPreview .seccion-dinamica .article-content {
				font-family: 'Metropolis', sans-serif;
				font-weight: normal;
				font-size: 1.15rem;
				line-height: 1.8;
				color: #2b2b2b;
			}
			#modalPreview .article-body br, 
			#modalPreview .seccion-dinamica .article-content br {
				content: "";
				display: block;
				margin-top: 1.2rem;
			}
			#modalPreview .seccion-dinamica {
				margin-top: 3.5rem;
			}
			#modalPreview .seccion-contenido-lateral {
				border-left: 4px solid var(--ipunto-red); 
				padding-left: 1.5rem;           
				margin-bottom: 2rem;
			}
			#modalPreview .seccion-categoria {
				display: block;
				color: var(--ipunto-red);
				font-family: 'Metropolis', sans-serif;
				font-size: 0.85rem;
				text-transform: uppercase;
				letter-spacing: 1.5px;
				font-weight: 900;
				margin-bottom: 0.5rem;
			}
			#modalPreview .seccion-subtitulo {
				font-family: 'Metropolis', sans-serif;
				font-weight: 900;
				font-size: 1.8rem;
				line-height: 1.25;
				letter-spacing: -0.02em;
				color: #111;
				margin-bottom: 1.5rem;
			}
			#modalPreview .seccion-img-container {
				margin-top: 1.5rem;
				margin-bottom: 2rem;
			}
			#modalPreview .seccion-divisor {
				border: none;
				border-bottom: 1px solid var(--ipunto-red); 
				margin: 3rem 0;
			}
			
			/* CONTENEDOR DEL ICONO DE CIERRE */
			#modalPreview .seccion-divisor-con-icono {
				display: flex;
				align-items: center;
				justify-content: center;
				margin: 3rem 0 1rem 0; 
				width: 100%;
			}
			#modalPreview .seccion-divisor-con-icono::before,
			#modalPreview .seccion-divisor-con-icono::after {
				content: "";
				flex: 1;
				border-bottom: 1px solid var(--ipunto-red);
				opacity: 0.4;
			}
			#modalPreview .seccion-divisor-con-icono::before { margin-right: 25px; }
			#modalPreview .seccion-divisor-con-icono::after { margin-left: 25px; }
			
			/* CORREGIDO: Imagen del favicon cuadrada */
			#modalPreview .seccion-divisor-con-icono img {
				width: 28px;
				height: 28px;
				object-fit: contain;
				border-radius: 0px !important; /* Forzamos que sea cuadrado */
			}
		</style>
		
		<div class="article-container">
			<header class="mb-5 text-start">
				<h1 class="article-hero-title mb-4">${titulo}</h1>
				
				${resumen ? `<p class="article-lead mb-4">${resumen.replace(/\n/g, "<br>")}</p>` : ""}
				
				<div class="article-meta py-3 d-flex justify-content-between align-items-center">
					<div>
						<span>Por <strong>Redacción iPunto</strong></span>
						<span class="mx-2">•</span>
						<span>Vista Previa</span>
					</div>
					<div>
						<i class="fa-regular fa-clock me-1"></i> 3 min de lectura
					</div>
				</div>
			</header>
			
			${srcPortada ? `
			<div class="mb-5">
				<img src="${srcPortada}" class="article-hero-image" alt="Portada">
			</div>
			` : ""}
			
			<div class="article-body">
				${cuerpoPrincipal.replace(/\n/g, "<br>")}
			</div>
			
			<div id="preview-secciones-dinamicas"></div>
		</div>
	`;

	$("#modalPreview .modal-body").html(htmlPreview);
	var contenedorSecciones = $("#preview-secciones-dinamicas");
	var totalSecciones = $(".seccion-card").length;

	// 4. CICLO DE SECCIONES SECUNDARIAS
	$(".seccion-card").each(function (index, elemento) {
		var bloque = $(elemento);
		var volantaSec = bloque.find("input[name='categorias_seccion[]']").val() || "";
		var subtituloSec = bloque.find("input[name='subtitulos[]']").val() || "";
		var cuerpoBloqueSec = bloque.find("textarea[name='cuerpos_seccion[]']").val() || "";
		
		var inputImgBloque = bloque.find(".file-upload-input")[0];
		var srcMuestraBloque = bloque.find(".preview-img").attr("src");
		var srcSec = "";

		if (inputImgBloque && inputImgBloque.files && inputImgBloque.files[0]) {
			srcSec = URL.createObjectURL(inputImgBloque.files[0]);
		} else if (srcMuestraBloque && srcMuestraBloque.trim() !== "") {
			srcSec = srcMuestraBloque;
		}

		if (index === 0) {
			contenedorSecciones.before('<hr class="seccion-divisor mt-5">');
		}

		var htmlBloquePreview = `
			<div class="seccion-dinamica">
				<div class="seccion-contenido-lateral">
					${volantaSec ? `<span class="seccion-categoria">${volantaSec}</span>` : ""}
					${subtituloSec ? `<h3 class="seccion-subtitulo">${subtituloSec}</h3>` : ""}
					
					${srcSec ? `
					<div class="seccion-img-container">
						<img src="${srcSec}" class="seccion-dinamica-img" alt="Subsección">
					</div>
					` : ""}
					
					<div class="article-content">
						${cuerpoBloqueSec.replace(/\n/g, "<br>")}
					</div>
				</div>
				
				${(index + 1 < totalSecciones) ? '<hr class="seccion-divisor">' : ''}
			</div>
		`;
		
		contenedorSecciones.append(htmlBloquePreview);
	});

	// CORREGIDO: Inyectamos el tag img real con fallback de rutas relativas
	if (totalSecciones > 0) {
		contenedorSecciones.append(`
			<div class="seccion-divisor-con-icono">
				<img src="../assets/img/favicon.png" onerror="this.src='assets/img/favicon.png'; this.onerror=null;" alt="Cierre de nota">
			</div>
		`);
	}

	$("#modalPreview").modal("show");
}
// INICIALIZACIÓN DE SCRIPT
init();