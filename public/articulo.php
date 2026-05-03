<?php
require_once "../config/Conexion.php";
require_once "../modelos/Noticia.php";

$noticia = new Noticia();
$id = isset($_GET["id"]) ? $_GET["id"] : "";

// Obtenemos los datos (tu modelo ya devuelve un array asociativo)
$reg = $noticia->mostrar($id);

// Redirección si no existe la noticia
if (!$reg) { 
    header("Location: index.php"); 
    exit(); 
}

// INCLUIMOS EL HEADER GLOBAL (Esto trae el CSS, el <head> y el <nav>)
include 'header.php';
?>

<div class="container mt-5 pt-lg-2">
    <div class="row justify-content-center">
        
        <div class="col-lg-1 d-none d-lg-block">
            <div class="share-bar">
                <span class="small fw-bold text-muted mb-2" style="writing-mode: vertical-rl; text-orientation: mixed;">COMPARTIR</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-link bg-facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($reg['titulo']); ?>&url=<?php echo urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-link bg-twitter">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($reg['titulo'] . " " . "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-link bg-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <article>
                <header class="mb-5">
                    <span class="category-badge"><?php echo $reg['categoria']; ?></span>
                    <h1 class="article-title"><?php echo $reg['titulo']; ?></h1>
                    <p class="article-resumen"><?php echo $reg['resumen']; ?></p>
                    
                    <div class="d-flex align-items-center mt-4 pt-4 border-top">
                        <div class="flex-grow-1">
                            <span class="text-muted">Escrito por</span> 
                            <b class="text-dark ms-1"><?php echo $reg['autor']; ?></b>
                            <span class="mx-2 text-muted">•</span>
                            <span class="text-muted"><?php echo date("d M, Y", strtotime($reg['fecha_publicacion'])); ?></span>
                        </div>
                    </div>
                </header>

                <?php if (!empty($reg['calificacion'])): ?>
<!--                     <div class="card check-card mb-5">
                        <div class="row g-0">
                            <div class="col-md-3 check-header check-<?php echo strtolower(str_replace(' ', '-', $reg['calificacion'])); ?>">
                                <i class="fa-solid fa-shield-check d-block mb-2 fs-1"></i>
                                <span class="fs-4">CHECK</span>
                            </div>
                            <div class="col-md-9 p-4 bg-white border-start">
                                <h4 class="fw-bold text-dark mb-2"><?php echo $reg['calificacion']; ?></h4>
                                <p class="mb-0 text-secondary small"><?php echo $reg['explicacion_calificacion']; ?></p>
                            </div>
                        </div>
                    </div> -->
                <?php endif; ?>

                <div class="text-center">
                    <img src="../files/noticias/<?php echo $reg['imagen']; ?>" class="img-fluid featured-image" alt="<?php echo $reg['titulo']; ?>">
                </div>

                <div class="article-content">
                      <?php echo nl2br($reg['cuerpo']); ?>
                </div>

            </article>
        </div>
    </div>
</div>

<div class="py-5"></div>

<?php
// INCLUIMOS EL FOOTER GLOBAL (Scripts y pie de página)
include 'footer.php';
?>