<?php
require_once "../config/Conexion.php";
require_once "../modelos/Noticia.php";

$noticia = new Noticia();

// 1. Limpiamos el ID
$id_crudo = isset($_GET["id"]) ? $_GET["id"] : "";
$id = (int) $id_crudo;

// 2. Obtenemos los datos (Sabemos que $reg es un ARRAY)
$reg = $noticia->mostrar($id);

// 3. El escudo protector (Usamos empty para comprobar si el array vino vacío)
if (empty($reg)) { 
    header("Location: index.php"); 
    exit(); 
}

// 4. VARIABLES PARA COMPARTIR 
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$servidor = $_SERVER['HTTP_HOST'];

// ¡ACÁ ESTABA EL CAMBIO! Usamos corchetes [''] en lugar de flechas ->
$url_imagen_compartir = $protocolo . $servidor . "/public/files/noticias/" . $reg['imagen'];
$titulo_compartir = $reg['titulo'];
$resumen_compartir = $reg['resumen'];
$url_actual = $protocolo . $servidor . $_SERVER['REQUEST_URI'];

// INCLUIMOS EL HEADER GLOBAL
include 'header.php';
?>

<div class="container mt-5 pt-lg-2">
    <div class="row justify-content-center">
        

        <div class="col-lg-8">
            <article>
                <header class="mb-5">
                    <!-- <span class="category-badge" style="color: #c93b28;"><?php echo $reg['categoria']; ?></span> -->
                    <!-- <span class="category-badge"><?php echo $reg['categoria']; ?></span> -->
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

                <?php endif; ?>

                <div class="text-center">
                    <img src="files/noticias/<?php echo $reg['imagen']; ?>" class="img-fluid featured-image" alt="<?php echo $reg['titulo']; ?>">
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