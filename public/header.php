<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    /** * @var string $titulo_compartir
     * @var string $resumen_compartir
     * @var string $url_imagen_compartir
     * @var string $url_actual
     */
    // Detectamos si es servidor local o Hostinger
    $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    
    // Si estás en local (XAMPP), usamos la carpeta ipunto. Si es Hostinger, usamos la raíz.
    if ($host == 'localhost' || $host == '127.0.0.1') {
        $ruta_base = '/ipunto/'; 
    } else {
        $ruta_base = '/';
    }
    
    $base_url = $protocolo . $host . $ruta_base;
    ?>
    <base href="<?php echo $base_url; ?>">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo isset($titulo_compartir) ? $titulo_compartir . " | Ipunto" : "Ipunto - Noticias"; ?></title>

    <?php if (isset($titulo_compartir)): ?>
        <meta property="og:title" content="<?php echo $titulo_compartir; ?>">
        <meta property="og:description" content="<?php echo $resumen_compartir; ?>">
        <meta property="og:image" content="<?php echo $url_imagen_compartir; ?>">
        <meta property="og:url" content="<?php echo $url_actual; ?>">
    <?php else: ?>
        <meta property="og:title" content="Ipunto - Periodismo con Opinión">
        <meta property="og:description" content="Toda la información y las últimas noticias en un solo lugar.">
        <meta property="og:image" content="<?php echo $base_url; ?>assets/img/logo_social.png">
        <meta property="og:url" content="<?php echo $base_url; ?>">
    <?php endif; ?>
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ipunto">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=metropolis@400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="css/estilos.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
</head>

<body>

    <nav class="navbar navbar-expand-lg sticky-top bg-white">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo.png"
                    alt="Logo Ipunto"
                    class="img-fluid"
                    style="max-height: 40px; width: auto;">
            </a>
        </div>
    </nav>
    <br>