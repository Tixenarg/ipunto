<?php
// 1. Seguridad y Búfer
require_once "header_seguridad.php";

// 2. Traemos las variables globales (LA LÍNEA MÁGICA)
require_once "../config/Conexion.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Gestión de Noticias </title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="css/estilo_adm.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

</head>

<body>

    <?php include "header_admin.php"; ?>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card main-card">

                    <div class="card-header d-md-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold mb-0">Gestión de Noticias</h4>
                            <small class="text-muted">Bienvenido, <?php echo $_SESSION['nombre']; ?></small>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <button class="btn btn-primary shadow-sm" id="btnagregar" onclick="mostrarform(true)">
                                <i class="fa-solid fa-plus me-2"></i>Nueva Noticia
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-4" id="listadoregistros">

                        <!-- Pestañas de Filtro UX -->
                        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold px-4" id="tab-activas" onclick="cambiarFiltro('activas')" type="button"><i class="fa fa-globe me-2"></i>Publicadas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-secondary px-4" id="tab-borradores" onclick="cambiarFiltro('borradores')" type="button"><i class="fa fa-lock me-2"></i>Borradores</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-secondary px-4" id="tab-todas" onclick="cambiarFiltro('todas')" type="button"><i class="fa fa-list me-2"></i>Ver Todas</button>
                            </li>
                        </ul>

                        <div class="table-responsive">
                            <table id="tbllistado" class="table table-hover w-100 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="15%">Acciones</th>
                                        <th width="10%">Portada</th>
                                        <th width="45%">Título de la Noticia</th>
                                        <th width="15%">Fecha</th>
                                        <th width="15%">Estado</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-body p-4" id="formularioregistros" style="display: none;">
                        <form id="formulario" name="formulario" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="idnoticia" id="idnoticia">
                            <div class="row mb-4">
                                <div class="col-md-5">
                                    <label class="fw-bold mb-2">Foto de Portada <span class="text-danger">*</span></label>
                                    <div class="drop-zone dz-portada">
                                        <div class="placeholder-content text-muted">
                                            <i class="fa-solid fa-cloud-arrow-up fa-3x mb-2 text-primary"></i>
                                            <p class="mb-0">Clic o arrastrar imagen aquí</p>
                                            <small>(Formato 3:2 - 1200x800)</small>
                                        </div>
                                        <input type="file" class="file-upload-input" name="imagen" id="imagen" accept="image/jpeg, image/png, image/webp">
                                        <input type="hidden" name="imagenactual" id="imagenactual">
                                        <img src="" class="preview-img" id="imagenmuestra">
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Título Principal <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" name="titulo" id="titulo" placeholder="Ej: El Gobierno sumó respaldo del FMI..." required>
                                        <small class="text-muted text-end d-block" id="titulo_count">0/100</small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Bajada o Copete:</label>
                                        <textarea class="form-control" name="resumen" id="resumen" rows="3" placeholder="Un breve resumen que acompaña al título..."></textarea>
                                    </div>

                                    <div class="row mb-4">
                                        <input type="hidden" name="idcategoria" id="idcategoria" value="1">

                                        <div class="col-md-6 form-group">
                                            <label for="calificacion" class="fw-bold mb-1 text-muted small">Clasificación de la Nota <span class="text-danger">*</span></label>
                                            <select class="form-select form-control fw-bold" name="calificacion" id="calificacion" required style="border-radius: 8px; border-color: #cbd5e1;">
                                                <option value="Noticia" selected>Noticia</option>
                                                <option value="Opinion">Opinión</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label class="fw-bold mb-1 text-muted small">Autor:</label>
                                            <input type="text" class="form-control fw-bold" name="autor" id="autor" value="Redacción I." style="border-radius: 8px; border-color: #cbd5e1; color: #334155;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-12 mb-2">
                                        <label class="fw-bold">Cuerpo Principal de la Noticia <span class="text-danger"></span></label>
                                    </div>

                                    <div class="col-md-8 col-lg-7">
                                        <textarea class="form-control fs-5 shadow-sm" name="cuerpo" id="cuerpo" rows="12" placeholder="Escribí acá el desarrollo de la noticia..." style="line-height: 1.6; resize: vertical; background-color: #fafafa; border: 1px solid #dee2e6;"></textarea>
                                    </div>

                                    <div class="col-md-4 col-lg-5 d-flex flex-column justify-content-center text-muted px-4 mt-3 mt-md-0">
                                        <i class="fa-solid fa-align-left fa-2x mb-3 opacity-50"></i>
                                        <h6 class="fw-bold">Formato de Lectura Web</h6>
                                        <p class="small mb-0">La caja de texto simula el ancho real de la noticia en los celulares.</p>
                                        <p class="small mt-2 mb-0"><strong>Tip:</strong> Usá párrafos cortos (3 o 4 líneas) y andá directo al grano para mantener la atención del lector.</p>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 text-muted">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="fw-bold text-dark mb-0"><i class="fa-solid fa-layer-group text-primary me-2"></i>Desarrollo por Secciones</h4>
                            </div>

                            <div id="contenedor-secciones">
                            </div>

                            <button type="button" class="btn btn-outline-primary mb-4 fw-bold rounded-pill px-4" onclick="agregarSeccion()">
                                <i class="fa fa-plus me-1"></i> Añadir un nuevo bloque
                            </button>

                            <hr>

                            <div class="d-flex justify-content-end align-items-center mt-4 style-gap" style="gap: 15px;">
                                <button class="btn btn-outline-primary btn-lg px-4 fw-bold d-flex align-items-center" type="button" id="btnPrevisualizar" style="border-radius: 8px; gap: 8px;">
                                    <i class="fa fa-eye"></i> Previsualizar Nota
                                </button>
                                <button class="btn btn-success btn-lg px-5 fw-bold d-flex align-items-center" type="submit" id="btnGuardar" style="border-radius: 8px; gap: 8px;">
                                    <i class="fa fa-paper-plane"></i> Publicar Noticia
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPreview" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background-color: #ffffff;">

                <div class="modal-header bg-dark text-white py-3 px-4 shadow-sm sticky-top d-flex justify-content-between align-items-center" style="z-index: 1060; border-bottom: 3px solid #da251d;">
                    <div class="d-flex align-items-center" style="gap: 12px;">
                        <span style="background-color: #da251d; color: white; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 20px;" class="text-uppercase">Modo Previsualización</span>
                        <h5 class="modal-title fw-bold m-0" style="font-family: 'Inter', sans-serif;">Asistente de Maquetación en Vivo</h5>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 12px;">
                        <button type="button" class="btn btn-sm btn-outline-light px-3 fw-bold" data-bs-dismiss="modal" style="border-radius: 6px;">
                            <i class="fa fa-pencil me-1"></i> Seguir Editando
                        </button>
                        <button type="button" class="btn btn-success px-4 fw-bold" id="btnConfirmarPublicacionDesdePreview" style="border-radius: 6px; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);">
                            <i class="fa fa-paper-plane me-1"></i> Todo Listo, Publicar
                        </button>
                    </div>
                </div>

                <div class="modal-body p-0" style="background-color: #ffffff;">
                    <div class="container my-5" style="max-width: 800px; font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: left;">

                        <div class="mb-4 text-start">
                            <span id="preview-principal-categoria" class="badge text-uppercase fw-bold px-2 py-1 mb-3" style="background-color: #da251d; letter-spacing: 1px; font-size: 0.75rem; border-radius: 3px;">CATEGORÍA</span>

                            <h1 id="preview-principal-titulo" class="text-dark mb-3" style="font-weight: 900 !important; font-size: 2.8rem; line-height: 1.1; letter-spacing: -1px;">Título de la noticia</h1>

                            <p id="preview-principal-resumen" class="fs-5 mb-4" style="line-height: 1.5; color: #444 !important; font-style: normal;">Resumen introductorio de la nota...</p>

                            <div class="d-flex justify-content-between align-items-center py-3 mb-4" style="border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; font-size: 0.85rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
                                <div>
                                    POR <strong id="preview-principal-autor" style="color: #111; font-weight: 800;">Redacción</strong> &nbsp;&bull;&nbsp; <span id="preview-fecha-actual"><?php echo date("d M, Y"); ?></span>
                                </div>
                                <div class="d-none d-sm-flex align-items-center" style="gap: 6px;">
                                    <i class="far fa-clock"></i> 1 MIN DE LECTURA
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 overflow-hidden" style="border-radius: 6px; background-color: #f8f9fa;">
                            <img id="preview-principal-img" src="" alt="Portada" style="width:100%; height:auto; object-fit:cover; display:none;">

                        </div>

                        <div id="preview-principal-cuerpo" class="mb-5 text-dark" style="font-size: 1.1rem; line-height: 1.7; border-left: 4px solid #da251d; padding-left: 20px;">
                            Contenido base...
                        </div>

                        <div id="preview-contenedor-bloques">
                        </div>

                        <div class="d-flex align-items-center justify-content-center" style="margin: 60px 0 30px 0;">
                            <div style="flex-grow: 1; height: 1px; background-color: #fca5a5; opacity: 0.8;"></div>
                            <div style="padding: 0 15px;">
                                <div style="background-color: #da251d; color: #ffffff; font-weight: 900; font-family: 'Arial Black', Impact, sans-serif; font-size: 1.4rem; padding: 2px 10px; border-radius: 3px; letter-spacing: -1px; line-height: 1;">i.</div>
                            </div>
                            <div style="flex-grow: 1; height: 1px; background-color: #fca5a5; opacity: 0.8;"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-es-ES.min.js"></script>

    <script>
        const RUTA_BASE = "<?php echo RUTA_BASE; ?>";
    </script>

    <!-- <script type="text/javascript" src="scripts/noticia.js?v=13"></script> -->
    <!--  <script type="text/javascript" src="scripts/noticia.js?v=<?php echo time(); ?>"></script> -->
     <script type="text/javascript" src="scripts/noticia.js?v=<?php echo filemtime('scripts/noticia.js'); ?>"></script>



</body>

</html>