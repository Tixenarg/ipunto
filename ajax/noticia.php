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
$cuerpo = isset($_POST["cuerpo"]) ? $_POST["cuerpo"] : ""; // Mantiene el párrafo plano enviado
$autor = isset($_POST["autor"]) ? limpiarCadena($_POST["autor"]) : "";
$calificacion = isset($_POST["calificacion"]) ? limpiarCadena($_POST["calificacion"]) : "";
$explicacion = isset($_POST["explicacion_calificacion"]) ? limpiarCadena($_POST["explicacion_calificacion"]) : "";
$idusuario = $_SESSION["idusuario"];

/**
 * FUNCIÓN PROFESIONAL DE PROCESAMIENTO DE IMÁGENES
 * Redimensiona a 1200px max y convierte a WebP
 */
function procesarImagenWebP($fuente, $destino_nombre, $ancho_max = 1200, $calidad = 80)
{
    $info = getimagesize($fuente);
    $ancho_orig = $info[0];
    $alto_orig = $info[1];
    $tipo = $info['mime'];

    switch ($tipo) {
        case 'image/jpeg':
            $img = imagecreatefromjpeg($fuente);
            break;
        case 'image/png':
            $img = imagecreatefrompng($fuente);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            break;
        case 'image/webp':
            $img = imagecreatefromwebp($fuente);
            break;
        default:
            return false;
    }

    if ($ancho_orig > $ancho_max) {
        $ancho_nuevo = $ancho_max;
        $alto_nuevo = ($alto_orig * $ancho_max) / $ancho_orig;
    } else {
        $ancho_nuevo = $ancho_orig;
        $alto_nuevo = $alto_orig;
    }

    $lienzo = imagecreatetruecolor($ancho_nuevo, $alto_nuevo);
    imagealphablending($lienzo, false);
    imagesavealpha($lienzo, true);

    imagecopyresampled($lienzo, $img, 0, 0, 0, 0, $ancho_nuevo, $alto_nuevo, $ancho_orig, $alto_orig);

    $ruta_final = "../public/files/noticias/" . $destino_nombre;
    $exito = imagewebp($lienzo, $ruta_final, $calidad);

    imagedestroy($img);
    imagedestroy($lienzo);

    return $exito;
}

switch ($_GET["op"]) {

    case 'guardaryeditar':
        $clasificacion = isset($_POST["clasificacion"]) ? limpiarCadena($_POST["clasificacion"]) : "Noticia";

        // Procesamiento WebP de la Portada
        if (isset($_FILES['imagen']) && file_exists($_FILES['imagen']['tmp_name']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $nombre_base = round(microtime(true));
            $imagen = $nombre_base . '.webp';
            procesarImagenWebP($_FILES["imagen"]["tmp_name"], $imagen);
        } else {
            $imagen = isset($_POST["imagenactual"]) ? limpiarCadena($_POST["imagenactual"]) : "";
        }

        // Arrays de los bloques dinámicos
        $categorias_seccion = isset($_POST["categorias_seccion"]) ? $_POST["categorias_seccion"] : array();
        $subtitulos = isset($_POST["subtitulos"]) ? $_POST["subtitulos"] : array();
        $cuerpos_seccion = isset($_POST["cuerpos_seccion"]) ? $_POST["cuerpos_seccion"] : array();

        $imagenes_seccion_nombres = array();
        if (isset($_FILES["imagenes_seccion"])) {
            $cantidad_secciones = count($categorias_seccion);
            for ($i = 0; $i < $cantidad_secciones; $i++) {
                $nombre_foto = "";
                if (isset($_FILES["imagenes_seccion"]["tmp_name"][$i]) && file_exists($_FILES["imagenes_seccion"]["tmp_name"][$i]) && is_uploaded_file($_FILES["imagenes_seccion"]["tmp_name"][$i])) {
                    $nombre_base_sec = round(microtime(true)) . '_sec_' . $i;
                    $nombre_foto = $nombre_base_sec . '.webp';
                    procesarImagenWebP($_FILES["imagenes_seccion"]["tmp_name"][$i], $nombre_foto);
                }
                $imagenes_seccion_nombres[$i] = $nombre_foto;
            }
        }

        if (empty($idnoticia)) {
            $rspta = $noticia->insertar(
                $idusuario,
                $idcategoria,
                $titulo,
                $resumen,
                $cuerpo,
                $imagen,
                $autor,
                $calificacion,
                $explicacion,
                $categorias_seccion,
                $subtitulos,
                $cuerpos_seccion,
                $imagenes_seccion_nombres
            );

            if ($rspta === true) {
                echo "Noticia y bloques registrados correctamente.";
            } else {
                echo $rspta;
            }
        } else {
            $rspta = $noticia->editar(
                $idusuario,
                $idnoticia,
                $idcategoria,
                $titulo,
                $resumen,
                $cuerpo,
                $imagen,
                $autor,
                $calificacion,
                $explicacion,
                $categorias_seccion,
                $subtitulos,
                $cuerpos_seccion,
                $imagenes_seccion_nombres
            );

            if ($rspta === true) {
                echo "Noticia y bloques actualizados correctamente.";
            } else {
                echo $rspta;
            }
        }
        break;

case 'listar':
        // Recibimos el filtro que mande el editor
        $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'activas';
        $rspta = $noticia->listar($filtro);
        
        // =======================================================
        // MAGIA UX: Detectar cuáles están vivas en el Index
        // =======================================================
        $en_portada = array();
        
        // Solo nos gastamos en calcular la portada si estamos viendo notas públicas
        if ($filtro == 'activas' || $filtro == 'todas') {
            // Traemos las 7 de noticias[cite: 4]
            $rspta_noticias_index = $noticia->listarUltimasNoticias();
            if ($rspta_noticias_index) {
                while($ni = $rspta_noticias_index->fetch_object()){
                    $en_portada[] = $ni->idnoticia;
                }
            }
            // Traemos la 1 de opinión[cite: 4]
            $rspta_opinion_index = $noticia->listarUltimaOpinion();
            if ($rspta_opinion_index) {
                if($oi = $rspta_opinion_index->fetch_object()){
                    $en_portada[] = $oi->idnoticia;
                }
            }
        }

        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $fecha = date("d/m/Y H:i", strtotime($reg->fecha_publicacion));

            $btn_preview = '<a href="../articulo.php?id=' . $reg->idnoticia . '" target="_blank" class="btn btn-info btn-sm text-white" title="Vista Previa (Como lo ve el público)"><i class="fa fa-eye"></i></a>';
            $btn_edit = ' <button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->idnoticia . ')" title="Editar Noticia"><i class="fa fa-pencil"></i></button>';

            // Definimos el estado y la etiqueta de portada
            if ($reg->estado) {
                $btn_action = ' <button class="btn btn-danger btn-sm" onclick="desactivar(' . $reg->idnoticia . ')" title="Pasar a Borrador"><i class="fa fa-times"></i></button>';
                
                // ¿Esta noticia está en el array de las que salen en portada?
                if (in_array($reg->idnoticia, $en_portada)) {
                    $estado_label = '<span class="badge bg-success mb-1">Pública</span><br><span class="badge bg-warning text-dark shadow-sm"><i class="fa-solid fa-star text-danger"></i> En Portada</span>';
                } else {
                    $estado_label = '<span class="badge bg-success mb-1">Pública</span><br><span class="badge bg-light text-secondary border">Histórico</span>';
                }
            } else {
                $btn_action = ' <button class="btn btn-success btn-sm" onclick="activar(' . $reg->idnoticia . ')" title="Publicar Ya"><i class="fa fa-check"></i></button>';
                $estado_label = '<span class="badge bg-secondary mb-1">Borrador</span>';
            }

            // Etiqueta de Tipo de Nota
            $tipo_limpio = strtolower(trim($reg->calificacion));
            if ($tipo_limpio == 'opinion' || $tipo_limpio == 'opinión') {
                $tipo_badge = '<span class="badge text-white me-2" style="background-color: #6f42c1; font-size: 0.75rem; padding: 0.35em 0.65em;">Opinión</span>';
            } else {
                $tipo_badge = '<span class="badge bg-primary text-white me-2" style="font-size: 0.75rem; padding: 0.35em 0.65em;">Noticia</span>';
            }

            $data[] = array(
                "0" => $btn_preview . $btn_edit . $btn_action,
                "1" => "<img src='../public/files/noticias/" . $reg->imagen . "' class='img-tabla-preview' style='width: 80px; height: 50px; object-fit: cover; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);'>",
                "2" => $tipo_badge . ' <strong style="font-size: 0.95rem; color: #2d3748;">' . $reg->titulo . '</strong>',
                "3" => $fecha,
                "4" => $estado_label
            );
        }
        echo json_encode(array("sEcho" => 1, "iTotalRecords" => count($data), "iTotalDisplayRecords" => count($data), "aaData" => $data));
        break;

case 'mostrar':
        // Forzamos a que PHP muestre cualquier error oculto
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        header('Content-Type: application/json'); // Obligamos a que la respuesta sea JSON

        // 1. Traemos los datos de la noticia (Tu Conexion.php devuelve un Array aquí)
        $noticia_data = $noticia->mostrar($idnoticia);
        
        if ($noticia_data) {
            $secciones = array();
            
            // 2. Traemos los bloques dinámicos
            $rspta_secciones = $noticia->mostrarSecciones($idnoticia);
            
            if ($rspta_secciones) {
                // Como ejecutarConsulta devuelve un objeto mysqli_result, usamos fetch_assoc()
                while ($reg_sec = $rspta_secciones->fetch_assoc()) {
                    $secciones[] = $reg_sec;
                }
            }
            
            // 3. Metemos las secciones adentro de los datos de la noticia
            $noticia_data['secciones'] = $secciones;
            
            // 4. Imprimimos el resultado final
            echo json_encode($noticia_data);
        } else {
            // Si la noticia no existe, devolvemos un JSON de error
            echo json_encode(["error" => "No se encontraron datos para esta noticia."]);
        }
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
