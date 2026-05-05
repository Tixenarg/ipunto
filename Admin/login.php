<?php
// Iniciamos el búfer y la sesión por si ya hay una activa
ob_start();
session_start();

// Si el usuario ya está logueado, lo mandamos directo al escritorio
if (isset($_SESSION["idusuario"])) {
    header("Location: escritorio.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso al Sistema | Blog Pro</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .login-logo {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 1rem;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }

        .btn-login {
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="login-logo">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h4 class="text-center fw-bold mb-4">Panel Administrativo</h4>

        <form method="post" id="frmAcceso">
            <div class="mb-3">
                <label for="logina" class="form-label small fw-semibold text-secondary">Usuario</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                    <input type="text" id="logina" name="logina" class="form-control border-start-0" placeholder="Ingresa tu usuario" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="clavea" class="form-label small fw-semibold text-secondary">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                    <input type="password" id="clavea" name="clavea" class="form-control border-start-0" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-login mb-3">
                Iniciar Sesión
            </button>
        </form>

        <div class="text-center">
            <a href="../index.php" class="text-decoration-none small text-muted">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver al Blog
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script type="text/javascript" src="scripts/login.js?v=4"></script>
</body>

</html>