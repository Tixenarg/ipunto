<?php
// 1. Seguridad y Búfer
require_once "header_seguridad.php";
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
                        <div class="table-responsive">
                            <table id="tbllistado" class="table table-hover w-100">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Título</th>
                                        <th>Categoría</th>
                                        <th>Autor</th>
                                        <th>Calificación</th>
                                        <th>Imagen</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-body p-4" id="formularioregistros" style="display: none;">
                        <form name="formulario" id="formulario" method="POST">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Título de la Noticia (*)</label>
                                    <input type="hidden" name="idnoticia" id="idnoticia">
                                    <input type="text" class="form-control" name="titulo" id="titulo" maxlength="100" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Categoría (*)</label>
                                    <select name="idcategoria" id="idcategoria" class="form-select" required>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Resumen / Bajada</label>
                                    <textarea class="form-control" name="resumen" id="resumen" rows="2" maxlength="200"></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Cuerpo de la Noticia (*)</label>
                                    <textarea class="form-control" name="cuerpo" id="cuerpo"></textarea>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Calificación Noticia U Opinión</label>
                                    <select name="calificacion" id="calificacion" class="form-select">
                                        <option value="Noticias">Noticia</option>
                                        <option value="Opinión">Opinión</option>
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Explicación breve del sello</label>
                                    <input type="text" class="form-control" name="explicacion_calificacion" id="explicacion_calificacion">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Autor</label>
                                    <input type="text" class="form-control" name="autor" id="autor" value="<?php echo $_SESSION['nombre']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Imagen Destacada (Portada)</label>
                                    <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                    <div class="mt-2">
                                        <img src="" class="rounded shadow-sm" width="120" id="imagenmuestra" style="display:none;">
                                    </div>
                                    <small class="text-muted">Esta foto solo saldrá en la cuadrícula de inicio.</small>
                                </div>

                                <div class="col-12 mt-4 text-end">
                                    <button class="btn btn-light btn-lg" onclick="cancelarform()" type="button">Cancelar</button>

                                    <button class="btn btn-primary btn-lg px-5" type="button" id="btnGuardar" onclick="guardaryeditar(event)">
                                        <i class="fa-solid fa-save me-2"></i>Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
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


    <script type="text/javascript" src="scripts/noticia.js?v=11"></script>

</body>

</html>