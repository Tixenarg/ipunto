<?php
require_once "../config/Conexion.php";
require_once "../modelos/Noticia.php";

$noticia = new Noticia();

// 1. Limpiamos el ID
$id_crudo = isset($_GET["id"]) ? $_GET["id"] : "";
$id = (int) $id_crudo;

// 2. Obtenemos los datos principales y las secciones dinámicas
$reg = $noticia->mostrar($id);
$rspta_secciones = $noticia->mostrarSecciones($id);

// 3. El escudo protector
if (empty($reg)) {
    $redireccion = defined('RUTA_BASE') ? RUTA_BASE . "index.php" : "index.php";
    header("Location: " . $redireccion);
    exit();
}

// 4. Variables Globales y de Compartir
$ruta_base_dinamica = defined('RUTA_BASE') ? RUTA_BASE : '/';
$url_imagen_compartir = $ruta_base_dinamica . "files/noticias/" . $reg['imagen'];
$titulo_compartir = $reg['titulo'];
$resumen_compartir = $reg['resumen'];

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url_actual = $protocolo . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// 5. CÁLCULO DE TIEMPO DE LECTURA
$palabras = str_word_count(strip_tags($reg['cuerpo']));
$minutos_lectura = ceil($palabras / 200);
if ($minutos_lectura < 1) $minutos_lectura = 1;

include 'header.php';
?>

<div class="container mt-5 pt-lg-4">
    <article class="article-container">

        <header class="mb-5  text-start">
            <h1 class="article-hero-title mb-4"><?php echo $reg['titulo']; ?></h1>
            <p class="article-lead mb-4"><?php echo $reg['resumen']; ?></p>

            <div class="article-meta py-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 gap-md-3">
                <div>
                    <span>Por <strong><?php echo $reg['autor']; ?></strong></span>
                    <span class="mx-2 d-none d-md-inline">•</span>
                    <span><?php echo date("d M, Y", strtotime($reg['fecha_publicacion'])); ?></span>
                </div>
                <div>
                    <i class="fa-regular fa-clock me-1"></i> <?php echo $minutos_lectura; ?> min de lectura
                </div>
            </div>
        </header>

        <?php if (!empty($reg['imagen'])): ?>
            <div class="mb-5">
                <img src="<?php echo $ruta_base_dinamica; ?>files/noticias/<?php echo $reg['imagen']; ?>" class="article-hero-image" alt="<?php echo $reg['titulo']; ?>">
            </div>
        <?php endif; ?>

        <div class="article-body">
            <?php echo nl2br($reg['cuerpo']); ?>
        </div>

        <?php
        if (isset($rspta_secciones) && $rspta_secciones->num_rows > 0) {
            // Imprimimos una línea fina antes de empezar el bloque de breves
            echo '<hr class="seccion-divisor mt-5">';

            // Preparamos el contador
            $total_secciones = $rspta_secciones->num_rows;
            $contador_secciones = 0;

            // BUCLE: Repite esto por cada sección que exista
            while ($seccion = $rspta_secciones->fetch_assoc()) {
                $contador_secciones++; // Sumamos 1 por cada vuelta
        ?>
                <div class="seccion-dinamica">
                    <div class="seccion-contenido-lateral">

                        <?php if (!empty($seccion['categoria_seccion'])): ?>
                            <span class="seccion-categoria"><?php echo $seccion['categoria_seccion']; ?></span>
                        <?php endif; ?>

                        <?php if (!empty($seccion['subtitulo'])): ?>
                            <h3 class="seccion-subtitulo"><?php echo $seccion['subtitulo']; ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($seccion['imagen'])): ?>
                            <div class="seccion-img-container">
                                <img src="<?php echo $ruta_base_dinamica; ?>files/noticias/<?php echo $seccion['imagen']; ?>" class="seccion-dinamica-img" alt="<?php echo $seccion['subtitulo']; ?>">
                            </div>
                        <?php endif; ?>

                        <div class="article-content">
                            <?php echo nl2br($seccion['cuerpo']); ?>
                        </div>

                    </div> <?php
                            // Solo imprimimos esta línea si NO estamos en la última sección
                            if ($contador_secciones < $total_secciones) {
                                echo '<hr class="seccion-divisor">';
                            }
                            ?>

                </div>
            <?php
            } // Fin del bucle while

            // 6. EL GRAN CIERRE EDITORIAL (Afuera del bucle, imprime una sola vez al final)
            ?>
            <div class="seccion-divisor-con-icono">
                <img src="<?php echo $ruta_base_dinamica; ?>assets/img/favicon.png" alt="Cierre de nota">
            </div>
        <?php
        } // Fin del if
        ?>

    </article>
</div>

<div class="container mt-5 mb-5 border-top border-2 pt-5">
    <h4 class="fw-bold mb-4" style="font-family: 'Metropolis', sans-serif; color: #1a1a1a;">
        <span style="color: #c93b28;">|</span> Te puede interesar
    </h4>
    <div class="row">
        <?php
        // 1. Declaramos tu función para generar el slug al vuelo
        if (!function_exists('generarSlug')) {
            function generarSlug($texto)
            {
                $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
                $texto = strtolower($texto);
                $texto = preg_replace('/[^a-z0-9\s-]/', '', $texto);
                $texto = preg_replace('/[\s-]+/', '-', $texto);
                $texto = trim($texto, '-');
                return $texto;
            }
        }

        $rspta_relacionadas = $noticia->listarUltimasNoticias();
        $contador_relacionadas = 0;

        while ($relacionada = $rspta_relacionadas->fetch_object()) {
            if ($relacionada->idnoticia != $id && $contador_relacionadas < 3) {

                // Formateamos la fecha premium
                $fecha_formateada = date("d M, Y", strtotime($relacionada->fecha_publicacion));

                // 2. MAGIA SEO: Generamos el slug dinámico usando el título
                $slug_dinamico = generarSlug($relacionada->titulo);

                // 3. ARMAMOS LA URL AMIGABLE SEGÚN TU .HTACCESS (ID-slug)
                // Ahora lleva un guion (-) en vez de una barra (/) para evitar el error 500
                $url_amigable = $ruta_base_dinamica . "articulo/" . $relacionada->idnoticia . "-" . $slug_dinamico;
        ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; transition: transform 0.3s ease;">

                        <a href="<?php echo $url_amigable; ?>" class="text-decoration-none text-dark d-flex flex-column h-100">

                            <img src="<?php echo $ruta_base_dinamica; ?>files/noticias/<?php echo $relacionada->imagen; ?>" class="card-img-top" alt="<?php echo $relacionada->titulo; ?>" style="height: 200px; object-fit: cover;">

                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold mb-4" style="font-family: 'Metropolis', sans-serif; font-size: 1.15rem; line-height: 1.4;"><?php echo $relacionada->titulo; ?></h5>

                                <div class="mt-auto pt-3 border-top" style="border-color: #f0f0f0 !important;">
                                    <div class="d-flex align-items-center text-muted" style="font-family: 'Metropolis', sans-serif; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px;">
                                        <span class="fw-bold" style="color: #c93b28;"><?php echo $relacionada->autor; ?></span>
                                        <span class="mx-2">•</span>
                                        <span><?php echo $fecha_formateada; ?></span>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                </div>
        <?php
                $contador_relacionadas++;
            }
        }
        ?>
    </div>
</div>
<div class="progress-container">
    <div class="progress-bar" id="barraProgreso"></div>
</div>

<script>
    window.onscroll = function() {
        var scrollActual = document.body.scrollTop || document.documentElement.scrollTop;
        var alturaTotal = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var porcentaje = (scrollActual / alturaTotal) * 100;
        document.getElementById("barraProgreso").style.width = porcentaje + "%";
    };
</script>
<div class="social-share-floating">
<!--     <a href="https://wa.me/?text=<?php echo urlencode($titulo_compartir . ' - ' . $url_actual); ?>" target="_blank" class="btn-share-wsp">
        <i class="fa-brands fa-whatsapp"></i>
    </a> -->
    <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($url_actual); ?>" class="btn-share-wsp" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="https://www.instagram.com/" target="_blank" class="btn-share-ig">
        <i class="fa-brands fa-instagram"></i>
    </a>
</div>
<!-- MAGIA PARA OCULTAR BOTONES AL LLEGAR AL FINAL DE LA NOTA -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Seleccionamos los botones flotantes
        const shareButtons = document.querySelector('.social-share-floating');

        // Buscamos específicamente el contenedor de "Te puede interesar" usando sus clases de Bootstrap
        const limitSection = document.querySelector('.container.border-top.border-2.pt-5') || document.querySelector('footer');

        if (shareButtons && limitSection) {
            // Transición un poco más rápida para que no se superponga
            shareButtons.style.transition = "opacity 0.2s ease-out, visibility 0.2s, transform 0.2s ease-out";

            window.addEventListener('scroll', function() {
                // Medimos a qué distancia está la línea de "Te puede interesar" respecto al techo de la pantalla
                const limitPosition = limitSection.getBoundingClientRect().top;

                // NUEVO RADAR: En lugar de esperar a la mitad de la pantalla, el límite ahora es el 80% del alto de la ventana.
                // Es decir, apenas la sección "Te puede interesar" asoma por abajo, los botones ya se esconden.
                const triggerPoint = window.innerHeight * 0.80;

                if (limitPosition < triggerPoint) {
                    // Ocultar botones
                    shareButtons.style.opacity = "0";
                    shareButtons.style.visibility = "hidden";
                    shareButtons.style.transform = "translateY(-50%) scale(0.8)";
                } else {
                    // Mostrar botones
                    shareButtons.style.opacity = "1";
                    shareButtons.style.visibility = "visible";
                    shareButtons.style.transform = "translateY(-50%) scale(1)";
                }
            });
        }
    });
</script>
<?php include 'footer.php'; ?>