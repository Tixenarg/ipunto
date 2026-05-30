<?php
require_once "../config/Conexion.php";
require_once "../modelos/Noticia.php";

$noticia = new Noticia();
$listado = $noticia->listarUltimasNoticias();
$rsptaOpinion = $noticia->listarUltimaOpinion();
$opinion = $rsptaOpinion->fetch_object();

function generarSlug($texto) {
    // Reemplaza caracteres especiales
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
    // Convierte a minúsculas
    $texto = strtolower($texto);
    // Elimina caracteres que no sean letras, números o espacios
    $texto = preg_replace('/[^a-z0-9\s-]/', '', $texto);
    // Reemplaza espacios y guiones múltiples por un solo guión
    $texto = preg_replace('/[\s-]+/', '-', $texto);
    // Limpia guiones al principio y al final
    $texto = trim($texto, '-');
    return $texto;
}


include 'header.php';
?>

<main class="container" style="min-height: 65vh;">

    <div class="row">
        <?php
        if ($listado && $listado->num_rows > 0):
            $count = 0;
            while ($reg = $listado->fetch_object()):
                if ($count == 0): // NOTICIA PRINCIPAL (HERO)
        ?>
                    <div class="col-12">
                        <div class="section-separator">
                            <h2>Resumen de Noticias</h2>
                        </div>
                    </div>

                    <div class="col-12 mb-5">
                        <div class="card hero-section border-0 shadow-lg position-relative card-news">
                            <div class="row g-0">
                                <div class="col-lg-7">
                                    <div class="hero-img-container">
                                        <img src="files/noticias/<?php echo $reg->imagen; ?>" class="hero-img" alt="...">
                                    </div>
                                </div>
                                <div class="col-lg-5 p-4 p-md-5 d-flex flex-column justify-content-center bg-white hero-text-container">
                                    
                                    <a href="articulo/<?php echo $reg->idnoticia . '-' . generarSlug($reg->titulo); ?>" class="text-decoration-none text-dark stretched-link">
                                        <h1 class="main-title text-dark fw-bold mb-3"><?php echo $reg->titulo; ?></h1>
                                    </a>
                                    <p class="lead text-muted d-none d-sm-block mb-4"><?php echo $reg->resumen; ?></p>
                                    <div class="d-flex align-items-center mt-auto">
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">Por <?php echo $reg->autor; ?></h6>
                                            <small class="text-muted"><?php echo date("d M, Y", strtotime($reg->fecha_publicacion)); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="section-separator">
                            <h2>Random</h2>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row g-4">
                        <?php else: // NOTICIAS SECUNDARIAS (GRILLA RANDOM) 
                        ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <article class="card h-100 card-news position-relative">
                                    <div class="position-relative mb-3">
                                        <div style="height: 200px; overflow: hidden; border-radius: 12px;">
                                            <img src="files/noticias/<?php echo $reg->imagen; ?>" class="w-100 h-100" style="object-fit: cover;" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <a href="articulo/<?php echo $reg->idnoticia . '-' . generarSlug($reg->titulo); ?>" class="text-decoration-none text-dark stretched-link">
                                        <!-- <a href="articulo.php?id=<?php echo $reg->idnoticia; ?>" class="text-decoration-none text-dark stretched-link"> -->
                                            <h5 class="card-title" style="font-size: 1.2rem;"><?php echo $reg->titulo; ?></h5>
                                        </a>

                                        <p class="card-text text-muted small mt-2 d-none d-md-block"><?php echo substr($reg->resumen, 0, 80); ?>...</p>
                                    </div>
                                </article>
                            </div>
                    <?php
                    endif;
                    $count++;
                endwhile;
                    ?>
                        </div>
                    </div>

                    <?php if ($opinion): ?>
                        <div class="col-12 mt-5">
                            <div class="section-separator">
                                <h2>Punto de Vista</h2>
                            </div>
                        </div>


                        <div class="col-12 mb-5">
                        <!-- CLAVE: Cambiamos 'card-news' por 'card-opinion' para que mantenga sus estilos visuales propios -->
                        <div class="card hero-section border-0 shadow-lg position-relative card-opinion overflow-hidden">
                            <!-- Estiramos las columnas para alinear las bases milimétricamente en PC -->
                            <div class="row g-0 align-items-lg-stretch">
                                <div class="col-lg-7 d-flex">
                                    <div class="hero-img-container w-100" style="--bg-image: url('files/noticias/<?php echo $opinion->imagen; ?>');">
                                        <img src="files/noticias/<?php echo $opinion->imagen; ?>" class="hero-img" alt="...">
                                    </div>
                                </div>
                                
                                <div class="col-lg-5 p-4 p-md-5 d-flex flex-column justify-content-center bg-white hero-text-container">

                                    <a href="articulo/<?php echo $opinion->idnoticia . '-' . generarSlug($opinion->titulo); ?>" class="text-decoration-none text-dark stretched-link">
                                    <!-- <a href="articulo.php?id=<?php echo $opinion->idnoticia; ?>" class="text-decoration-none text-dark stretched-link"> -->
                                        <h1 class="main-title text-dark fw-bold mb-3"><?php echo $opinion->titulo; ?></h1>
                                    </a>

                                    <p class="lead text-muted d-none d-sm-block mb-4"><?php echo $opinion->resumen; ?></p>

                                    <div class="d-flex align-items-center mt-auto">
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">Por <?php echo isset($opinion->autor) ? $opinion->autor : 'Redacción'; ?></h6>
                                            <small class="text-muted">
                                                <?php echo isset($opinion->fecha_publicacion) ? date("d M, Y", strtotime($opinion->fecha_publicacion)) : ''; ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        
                    <?php endif; ?>

                <?php else: ?>
                    <div class="col-12 d-flex flex-column justify-content-center align-items-center text-center w-100 mt-5 pt-5">
                        <i class="fa-solid fa-newspaper mb-4" style="font-size: 5rem; color: #dee2e6;"></i>
                        <h3 class="fw-bold text-dark mb-2">Aún no hay noticias publicadas</h3>
                        <p class="text-muted fs-5">Estamos trabajando en nuevos artículos y coberturas. <br> ¡Volvé a revisar pronto!</p>
                    </div>
                <?php endif; ?>
    </div>

</main>

<?php include 'footer.php'; ?>