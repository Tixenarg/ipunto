<?php
require_once "header_seguridad.php";

// BLOQUEO DE SEGURIDAD PARA NO ADMINISTRADORES
if (isset($_SESSION['tipo']) && $_SESSION['tipo'] != 'Administrador') {
    // Usamos JavaScript para redirigir y evitar el error de "Headers already sent" de PHP
    echo '<script>window.location.href = "escritorio.php?error=acceso_denegado";</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Gestión de Usuarios</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="css/estilo_adm.css">
</head>

<body>

    <?php include "header_admin.php"; ?>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card main-card">

                    <div class="card-header d-md-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold mb-0">Gestión de Usuarios</h4>
                            <small class="text-muted">Control de acceso al sistema</small>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <button class="btn btn-primary shadow-sm" id="btnagregar" onclick="mostrarform(true)">
                                <i class="fa-solid fa-user-plus me-2"></i>Nuevo Usuario
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-4" id="listadoregistros">
                        <div class="table-responsive">
                            <table id="tbllistado" class="table table-hover w-100">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Login</th>
                                        <th>Tipo</th>
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
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nombre (*)</label>
                                    <input type="hidden" name="idusuario" id="idusuario">
                                    <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre completo" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Tipo Documento (*)</label>
                                    <select class="form-select" name="tipo_documento" id="tipo_documento" required>
                                        <option value="DNI">DNI</option>
                                        <option value="RUC">RUC</option>
                                        <option value="CEDULA">CÉDULA</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Número (*)</label>
                                    <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Número de documento" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Dirección</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Dirección">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Teléfono</label>
                                    <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Cargo</label>
                                    <input type="text" class="form-control" name="cargo" id="cargo" maxlength="20" placeholder="Cargo">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipo de Usuario (*)</label>
                                    <select name="tipo" id="tipo" class="form-select" required>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Redactor">Redactor</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Login (*)</label>
                                    <input type="text" class="form-control" name="login" id="login" maxlength="20" placeholder="Nombre de usuario" required>
                                </div>

                                <div class="col-md-6" id="claves">
                                    <label class="form-label fw-semibold">Contraseña (*)</label>
                                    <input type="password" class="form-control" name="clave" id="clave" maxlength="64" placeholder="Contraseña">
                                    <small class="text-info" id="notaclave">Para editar, deje en blanco si no desea cambiar la clave.</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Imagen de Perfil</label>
                                    <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                    <div class="mt-2">
                                        <img src="" class="rounded-circle shadow-sm" width="80" height="80" id="imagenmuestra" style="display:none; object-fit: cover;">
                                    </div>
                                </div>

                                <div class="col-12 mt-4 text-end border-top pt-3">
                                    <button class="btn btn-light btn-lg me-2" onclick="cancelarform()" type="button">Cancelar</button>
                                    <button class="btn btn-primary btn-lg px-5" type="submit" id="btnGuardar">
                                        <i class="fa-solid fa-save me-2"></i>Guardar Usuario
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

    <script type="text/javascript" src="scripts/usuario.js"></script>
</body>

</html>