<?php
require_once "header_seguridad.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Escritorio | Panel Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="css/estilo_adm.css">
</head>
<body>

<?php include "header_admin.php"; ?>

<div class="container">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card card-stats bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h6 class="small text-uppercase">Total de Registros </h6><h2 id="total_noticias" class="fw-bold mb-0">0</h2></div>
                        <div class="icon-shape"><i class="fa-solid fa-newspaper"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h6 class="small text-uppercase">Opiniones</h6><h2 id="total_verdaderas" class="fw-bold mb-0">0</h2></div>
                        <div class="icon-shape"><i class="fa-solid fa-circle-check"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-danger text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h6 class="small text-uppercase">Noticias</h6><h2 id="total_falsas" class="fw-bold mb-0">0</h2></div>
                        <div class="icon-shape"><i class="fa-solid fa-circle-xmark"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-warning text-dark shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h6 class="small text-uppercase">Usuarios</h6><h2 id="total_usuarios" class="fw-bold mb-0">0</h2></div>
                        <div class="icon-shape"><i class="fa-solid fa-users"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 text-center g-3">
        <div class="col-md-6">
            <a href="noticia.php" class="btn btn-white w-100 shadow-sm border p-4 rounded-4 text-decoration-none">
                <i class="fa-solid fa-file-pen fa-2x text-primary mb-2"></i>
                <h5 class="text-dark fw-bold">Gestionar Noticias</h5>
                <p class="text-muted small mb-0">Redactar, editar y calificar noticias.</p>
            </a>
        </div>
        
        <?php if ($_SESSION['tipo'] == 'Administrador'): ?>
        <div class="col-md-6">
            <a href="usuario.php" class="btn btn-white w-100 shadow-sm border p-4 rounded-4 text-decoration-none">
                <i class="fa-solid fa-user-gear fa-2x text-warning mb-2"></i>
                <h5 class="text-dark fw-bold">Gestionar Usuarios</h5>
                <p class="text-muted small mb-0">Control de accesos y roles del sistema.</p>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="scripts/escritorio.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>