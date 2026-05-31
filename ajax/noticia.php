<?php
if (strlen(session_id()) < 1) {
    session_start();
}
require_once "../modelos/Noticia.php";

$noticia = new Noticia();

// Variables del formulario
$idnoticia = isset($_POST["idnoticia"]) ? limpiarCadena($_POST["idnoticia"]) : "";
$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "";
$titulo = isset($_POST["titulo"]) ? limpiarCadena($_POST["titulo"]) : "";
$resumen = isset($_POST["resumen"]) ? limpiarCadena($_POST["resumen"]) : "";
$cuerpo = isset($_POST["cuerpo"]) ? $_POST["cuerpo"] : "";
$autor = isset($_POST["autor"]) ? limpiarCadena($_POST["autor"]) : "";
$calificacion = isset($_POST["calificacion"]) ? limpiarCadena($_POST["calificacion"]) : "";
$explicacion = isset($_POST["explicacion_calificacion"]) ? limpiarCadena($_POST["explicacion_calificacion"]) : "";
$idusuario = $_SESSION["idusuario"];

/**
 * FUNCIÓN PROFESIONAL DE PROCESAMIENTO DE IMÁGENES
 * Redimensiona a 1200px max y convierte a WebP
 */
function procesarImagenWebP($fuente, $destino_nombre, $ancho_max = 1200, $calidad = 80) {
    $info = getimagesize($fuente);
    $ancho_orig = $info[0];
    $alto_orig = $info[1];
    $tipo = $info['mime'];

    // 1. Crear recurso de imagen según el tipo original
    switch ($tipo) {
        case 'image/jpeg': $img = imagecreatefromjpeg($fuente); break;
        case 'image/png':  $img = imagecreatefrompng($fuente); 
                           imagealphablending($img, true);
                           imagesavealpha($img, true);
                           break;
        case 'image/webp': $img = imagecreatefromwebp($fuente); break;
        default: return false;
    }

    // 2. Calcular redimensionamiento proporcional
    if ($ancho_orig > $ancho_max) {
        $ancho_nuevo = $ancho_max;
        $alto_nuevo = ($alto_orig * $ancho_max) / $ancho_orig;
    } else {
        $ancho_nuevo = $ancho_orig;
        $alto_nuevo = $alto_orig;
    }

    // 3. Crear lienzo nuevo y re-muestrear (resizing)
    $lienzo = imagecreatetruecolor($ancho_nuevo, $alto_nuevo);
    
    // Mantener transparencias si es necesario
    imagealphablending($lienzo, false);
    imagesavealpha($lienzo, true);
    
    imagecopyresampled($lienzo, $img, 0, 0, 0, 0, $ancho_nuevo, $alto_nuevo, $ancho_orig, $alto_orig);

    // 4. Guardar como WebP en la carpeta final
    $ruta_final = "../public/files/noticias/" . $destino_nombre;
    $exito = imagewebp($lienzo, $ruta_final, $calidad);

    // 5. Liberar memoria
    imagedestroy($img);
    imagedestroy($lienzo);

    return $exito;
}

switch ($_GET["op"]) {
    case 'guardaryeditar':
        $imagen = "";
        
        // Si el usuario subió una imagen nueva
        if (isset($_FILES['imagen']) && file_exists($_FILES['imagen']['tmp_name']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            
            // Generamos nombre único con extensión .webp siempre
            $nombre_base = round(microtime(true));
            $imagen = $nombre_base . '.webp';
            
            // Procesamos: achicamos, comprimimos y convertimos
            procesarImagenWebP($_FILES["imagen"]["tmp_name"], $imagen);
            
        } else {
            // Si no subió nada, mantenemos la que ya estaba (o vacío)
            $imagen = isset($_POST["imagenactual"]) ? $_POST["imagenactual"] : "";
        }

        if (empty($idnoticia)) {
            $rspta = $noticia->insertar($idusuario, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion);
            echo $rspta ? "Noticia registrada con imagen WebP optimizada" : "No se pudo registrar";
        } else {
            $rspta = $noticia->editar($idusuario, $idnoticia, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion);
            echo $rspta ? "Noticia actualizada con imagen WebP optimizada" : "No se pudo actualizar";
        }
        break;

    case 'listar':
        $rspta = $noticia->listar();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => ($reg->estado) ?
                    '<button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->idnoticia . ')"><i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger btn-sm" onclick="desactivar(' . $reg->idnoticia . ')"><i class="fa fa-times"></i></button>' :
                    '<button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->idnoticia . ')"><i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-primary btn-sm" onclick="activar(' . $reg->idnoticia . ')"><i class="fa fa-check"></i></button>',
                "1" => $reg->titulo,
                "2" => $reg->categoria,
                "3" => $reg->autor,
                "4" => $reg->calificacion,
                "5" => "<img src='../public/files/noticias/" . $reg->imagen . "' class='img-tabla' style='width: 50px; height: auto;'>",
                "6" => ($reg->estado) ? '<span class="badge bg-success">Activado</span>' : '<span class="badge bg-danger">Desactivado</span>'
            );
        }
        echo json_encode(array("sEcho" => 1, "iTotalRecords" => count($data), "iTotalDisplayRecords" => count($data), "aaData" => $data));
        break;

    case 'mostrar':
        $rspta = $noticia->mostrar($idnoticia);
        echo json_encode($rspta);
        break;

    case 'selectCategoria':
        require_once "../modelos/Categoria.php";
        $categoria = new Categoria();
        $rspta = $categoria->select();
        echo '<option value="" selected disabled>Seleccione Categoría</option>';
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
        }
        break;

    case 'desactivar':
        $rspta = $noticia->desactivar($idnoticia);
        echo $rspta ? "Noticia desactivada" : "Error";
        break;
        
    case 'activar':
        $rspta = $noticia->activar($idnoticia);
        echo $rspta ? "Noticia activada" : "Error";
        break;
}