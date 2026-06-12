<?php
if (strlen(session_id()) < 1) {
    session_start();
}
require_once "../modelos/Noticia.php";

$noticia = new Noticia();

// 1. PROTECCIÓN DE SESIÓN: Si la sesión de Candela caducó, frenamos el colapso.
if (!isset($_SESSION["idusuario"]) || empty($_SESSION["idusuario"])) {
    echo "Error: Su sesión ha expirado. Por favor, vuelva a iniciar sesión para guardar.";
    exit();
}

// Variables del formulario sanitizadas
$idnoticia = isset($_POST["idnoticia"]) ? limpiarCadena($_POST["idnoticia"]) : "";
$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "";
$titulo = isset($_POST["titulo"]) ? limpiarCadena($_POST["titulo"]) : "";
$resumen = isset($_POST["resumen"]) ? limpiarCadena($_POST["resumen"]) : "";
$cuerpo = isset($_POST["cuerpo"]) ? $_POST["cuerpo"] : "";
$autor = isset($_POST["autor"]) ? limpiarCadena($_POST["autor"]) : "";
$calificacion = isset($_POST["calificacion"]) ? limpiarCadena($_POST["calificacion"]) : "";
$explicacion = isset($_POST["explicacion_calificacion"]) ? limpiarCadena($_POST["explicacion_calificacion"]) : "";

// Capturamos el ID del usuario de forma segura
$idusuario = $_SESSION["idusuario"];

/**
 * FUNCIÓN PROFESIONAL DE PROCESAMIENTO DE IMÁGENES
 */
function procesarImagenWebP($fuente, $destino_nombre, $ancho_max = 1200, $calidad = 80) {
    $info = getimagesize($fuente);
    if (!$info) return false;
    
    $ancho_orig = $info[0];
    $alto_orig = $info[1];
    $tipo = $info[2];

    if ($tipo == IMAGETYPE_JPEG) {
        $img = imagecreatefromjpeg($fuente);
    } elseif ($tipo == IMAGETYPE_PNG) {
        $img = imagecreatefrompng($fuente);
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
    } elseif ($tipo == IMAGETYPE_WEBP) {
        $img = imagecreatefromwebp($fuente);
    } else {
        return false;
    }

    if ($ancho_orig > $ancho_max) {
        $alto_nuevo = ($alto_orig / $ancho_orig) * $ancho_max;
        $img_rescalada = imagecreatetruecolor($ancho_max, $alto_nuevo);
        if ($tipo == IMAGETYPE_PNG) {
            imagealphablending($img_rescalada, false);
            imagesavealpha($img_rescalada, true);
        }
        imagecopyresampled($img_rescalada, $img, 0, 0, 0, 0, $ancho_max, $alto_nuevo, $ancho_orig, $alto_orig);
        imagedestroy($img);
        $img = $img_rescalada;
    } else {
        $img_rescalada = $img;
    }

    $exito = imagewebp($img_rescalada, $destino_nombre, $calidad);
    imagedestroy($img_rescalada);
    return $exito;
}

switch ($_GET["op"]) {
    case 'guardaryeditar':
        $imagen = isset($_POST["imagenactual"]) ? limpiarCadena($_POST["imagenactual"]) : "";

        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
            $formatos_permitidos = array("jpg", "jpeg", "png", "webp");

            if (in_array($ext, $formatos_permitidos)) {
                $nuevo_nombre = round(microtime(true)) . '.webp';
                $ruta_destino = "../public/files/noticias/" . $nuevo_nombre;

                if (procesarImagenWebP($_FILES["imagen"]["tmp_name"], $ruta_destino)) {
                    if (!empty($_POST["imagenactual"]) && file_exists("../public/files/noticias/" . $_POST["imagenactual"])) {
                        unlink("../public/files/noticias/" . $_POST["imagenactual"]);
                    }
                    $imagen = $nuevo_nombre;
                }
            }
        }

        if (empty($idnoticia)) {
            // Guardar noticia nueva
            $rspta = $noticia->insertar($idusuario, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion);
            echo $rspta ? "Noticia registrada correctamente" : "La noticia no se pudo registrar";
        } else {
            // 2. CORRECCIÓN FATAL: Agregamos el $idusuario al principio para que coincida con Noticia.php
            $rspta = $noticia->editar($idusuario, $idnoticia, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion);
            echo $rspta ? "Noticia actualizada correctamente" : "La noticia no se pudo actualizar";
        }
        break;

    case 'desactivar':
        $rspta = $noticia->desactivar($idnoticia);
        echo $rspta ? "Noticia desactivada" : "La noticia no se pudo desactivar";
        break;

    case 'activar':
        $rspta = $noticia->activar($idnoticia);
        echo $rspta ? "Noticia activada" : "La noticia no se pudo activar";
        break;

    case 'mostrar':
        $rspta = $noticia->mostrar($idnoticia);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $noticia->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => ($reg->estado) ? 
                    '<button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->idnoticia . ')"><i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger btn-sm" onclick="desactivar(' . $reg->idnoticia . ')"><i class="fa fa-close"></i></button>' :
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

    case 'selectCategoria':
        require_once "../modelos/Categoria.php";
        $categoria = new Categoria();
        $rspta = $categoria->select();
        echo '<option value="" selected disabled>Seleccione Categoría</option>';
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
        }
        break;
}
?>