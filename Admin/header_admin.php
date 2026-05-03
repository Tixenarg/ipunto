<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="escritorio.php"><i class="fa-solid fa-gauge-high me-2"></i>Dashboard</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="noticia.php"><i class="fa-solid fa-newspaper me-1"></i> Noticias</a>
                </li>
                <?php if ($_SESSION['tipo'] == 'Administrador'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="usuario.php"><i class="fa-solid fa-users me-1"></i> Usuarios</a>
                </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center">
                <a href="../public/index.php" target="_blank" class="btn btn-outline-light btn-sm rounded-pill px-3 me-3">
                    <i class="fa-solid fa-globe me-1"></i> Ver Web
                </a>
                <span class="text-white me-3 small">Hola, <b><?php echo $_SESSION['nombre']; ?></b></span>
                <a href="../ajax/usuario.php?op=salir" class="btn btn-outline-danger btn-sm">
                    <i class="fa-solid fa-power-off me-1"></i> Salir
                </a>
            </div>
        </div>
    </div>
</nav>