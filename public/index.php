<?php
require_once "../config/Conexion.php";
require_once "../modelos/Noticia.php";

$noticia = new Noticia();
$listado = $noticia->listarUltimasNoticias();
$rsptaOpinion = $noticia->listarUltimaOpinion();
$opinion = $rsptaOpinion->fetch_object();

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
                            <h2>Noticia del día</h2>
                        </div>
                    </div>

                    <div class="col-12 mb-5 ">
                        <div class="card hero-section border-0 shadow-lg position-relative card-news">
                            <div class="row g-0">
                                <div class="col-lg-7">
                                    <div class="hero-img-container">
                                        <img src="files/noticias/<?php echo $reg->imagen; ?>" class="w-100 h-100" style="object-fit: cover;" alt="...">
                                    </div>
                                </div>
                                <div class="col-lg-5 p-4 p-md-5 d-flex flex-column justify-content-center bg-white">
                                    <?php if (!empty($reg->calificacion) && $reg->calificacion != 'Noticia'): ?>
                                        <!--                                         <div class="sello-veritas check-<?php echo strtolower(str_replace(' ', '-', $reg->calificacion)); ?> position-relative" style="z-index: 2;">
                                            <i class="fa-solid fa-shield-check me-1"></i> <?php echo $reg->calificacion; ?>
                                        </div> -->
                                    <?php endif; ?>

                                    <a href="articulo.php?id=<?php echo $reg->idnoticia; ?>" class="text-decoration-none text-dark stretched-link">
                                        <h1 class="main-title"><?php echo $reg->titulo; ?></h1>
                                    </a>

                                    <p class="lead text-secondary d-none d-sm-block"><?php echo $reg->resumen; ?></p>

                                    <div class="d-flex align-items-center mt-3 mt-md-4">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 fw-bold small">Por <?php echo $reg->autor; ?></h6>
                                            <small class="text-muted"><?php echo date("d M, Y", strtotime($reg->fecha_publicacion)); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="section-separator">
                            <h2>Últimas Noticias</h2>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row g-4">
                        <?php else: // NOTICIAS SECUNDARIAS (3 POR FILA EN PC) 
                        ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <article class="card h-100 card-news position-relative">
                                    <div class="position-relative mb-3">
                                        <div style="height: 200px; overflow: hidden; border-radius: 12px;">
                                            <img src="files/noticias/<?php echo $reg->imagen; ?>" class="w-100 h-100" style="object-fit: cover;" alt="...">
                                        </div>

                                    </div>
                                    <div class="card-body p-0">

                                        <div class="sello-veritas check-<?php echo mb_strtolower(str_replace(' ', '-', $reg->categoria), 'UTF-8'); ?> position-relative" style="z-index: 2; color: #c93b28;">
                                            <?php echo $reg->categoria; ?>
                                        </div>

                                        <a href="articulo.php?id=<?php echo $reg->idnoticia; ?>" class="text-decoration-none text-dark stretched-link">
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

                    <?php if ($opinion): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <!-- <article class="card h-100 card-news  position-relative"> -->
                            <!--                             <article class="card h-100 card-news card-opinion position-relative">

                                <div class="position-relative mb-3">
                                    <div style="height: 200px; overflow: hidden; border-radius: 12px;">
                                        <img src="files/noticias/<?php echo $opinion->imagen; ?>" class="w-100 h-100 " style="object-fit: cover;" alt="...">
                                    </div>

                                </div>
                                <div class="card-body p-0">
                                    <div class="sello-veritas check-position-relative" style="z-index: 2; color: #c93b28;">
                                        <?php echo "Opinion"; ?>
                                    </div>

                                    <a href="articulo.php?id=<?php echo $opinion->idnoticia; ?>" class="text-decoration-none text-dark stretched-link">
                                        <h5 class="card-title" style="font-size: 1.2rem;"><?php echo $opinion->titulo; ?></h5>
                                    </a>
                                    <p class="card-text text-muted small mt-2 d-none d-md-block"><?php echo substr($opinion->resumen, 0, 80); ?>...</p>
                                </div>
                            </article> -->

                            <article class="card h-100 card-news card-opinion position-relative">
                                <div class="position-relative mb-3 d-flex">
                                    <div class="mx-auto" style="width: 200px; height: 200px; overflow: hidden; border-radius: 50%; border: 2px solid #c93b28;">
                                        <img src="files/noticias/<?php echo $opinion->imagen; ?>"
                                            class="w-100 h-100"
                                            style="object-fit: cover;"
                                            alt="...">
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="sello-veritas check-position-relative" style="z-index: 2; color: #c93b28;">
                                        <?php echo "Opinión"; ?>
                                    </div>

                                    <a href="articulo.php?id=<?php echo $opinion->idnoticia; ?>" class="text-decoration-none text-dark stretched-link">
                                        <h5 class="card-title" style="font-size: 1.2rem;"><?php echo $opinion->titulo; ?></h5>
                                    </a>

                                    <p class="card-text text-muted small mt-2 d-none d-md-block">
                                        <?php echo substr($opinion->resumen, 0, 80); ?>...
                                    </p>
                                </div>
                            </article>
                        </div>
                    <?php endif; ?>
                        </div>
                    </div> <?php else: // SI NO HAY NOTICIAS EN LA BASE DE DATOS 
                            ?>
                    <div class="col-12 d-flex flex-column justify-content-center align-items-center text-center w-100 mt-5 pt-5">
                        <i class="fa-solid fa-newspaper mb-4" style="font-size: 5rem; color: #dee2e6;"></i>
                        <h3 class="fw-bold text-dark mb-2">Aún no hay noticias publicadas</h3>
                        <p class="text-muted fs-5">Estamos trabajando en nuevos artículos y coberturas. <br> ¡Volvé a revisar pronto!</p>
                    </div>
                <?php endif; ?>
    </div>

</main>

<?php include 'footer.php'; ?>