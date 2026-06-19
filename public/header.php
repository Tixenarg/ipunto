<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    /** 
     * @var string $titulo_compartir
     * @var string $resumen_compartir
     * @var string $url_imagen_compartir // IMPORTANTE: Asegurate de que llegue como URL completa (https://...)
     * @var string $url_actual
     */
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo isset($titulo_compartir) ? htmlspecialchars($titulo_compartir) . " | Ipunto" : "Ipunto - Noticias"; ?></title>

    <?php if (isset($titulo_compartir)): ?>
        <!-- Meta Tags Específicos para el Artículo -->
        <meta property="og:type" content="article">
        <meta property="og:title" content="<?php echo htmlspecialchars($titulo_compartir); ?>">
        <meta property="og:description" content="<?php echo htmlspecialchars($resumen_compartir); ?>">
        <meta property="og:image" content="<?php echo $url_imagen_compartir; ?>">
        <meta property="og:image:secure_url" content="<?php echo $url_imagen_compartir; ?>">
        <meta property="og:url" content="<?php echo $url_actual; ?>">
        
        <!-- Tarjeta visual grande (Clave para WhatsApp y Telegram) -->
        <meta name="twitter:card" content="summary_large_image">
    <?php else: ?>
        <!-- Meta Tags por defecto para la Home -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="Ipunto - Periodismo con Opinión">
        <meta property="og:description" content="Toda la información y las últimas noticias en un solo lugar.">
        <meta property="og:image" content="<?php echo RUTA_BASE; ?>assets/img/logo_social.png">
        <meta property="og:image:secure_url" content="<?php echo RUTA_BASE; ?>assets/img/logo_social.png">
        <meta property="og:url" content="<?php echo RUTA_BASE; ?>">
        
        <meta name="twitter:card" content="summary">
    <?php endif; ?>
    
    <!-- Metas comunes de respaldo -->
    <meta property="og:site_name" content="Ipunto">
    <meta name="twitter:title" content="<?php echo isset($titulo_compartir) ? htmlspecialchars($titulo_compartir) : 'Ipunto - Periodismo con Opinión'; ?>">
    <meta name="twitter:description" content="<?php echo isset($resumen_compartir) ? htmlspecialchars($resumen_compartir) : 'Toda la información y las últimas noticias en un solo lugar.'; ?>">
    <meta name="twitter:image" content="<?php echo isset($titulo_compartir) ? $url_imagen_compartir : RUTA_BASE . 'assets/img/logo_social.png'; ?>">

    <!-- Hojas de Estilo y Fuentes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=metropolis@400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="<?php echo RUTA_BASE; ?>css/estilos.css">
    <link rel="shortcut icon" href="<?php echo RUTA_BASE; ?>assets/img/favicon.png" type="image/x-icon">
</head>

<body>

    <nav class="navbar navbar-expand-lg sticky-top bg-white">
        <div class="container">
            <a class="navbar-brand" href="<?php echo RUTA_BASE; ?>index.php">
                <img src="<?php echo RUTA_BASE; ?>assets/img/logo.png"
                    alt="Logo Ipunto"
                    class="img-fluid"
                    style="max-height: 40px; width: auto;">
            </a>
        </div>
    </nav>
    <br>