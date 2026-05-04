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

switch ($_GET["op"]) {
    case 'guardaryeditar':
        // Manejo de Imagen corregido
        $imagen = "";
        if (!isset($_FILES['imagen']) || !file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = isset($_POST["imagenactual"]) ? $_POST["imagenactual"] : "";
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            $imagen = round(microtime(true)) . '.' . end($ext);
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "../public/files/noticias/" . $imagen);
        }

        if (empty($idnoticia)) {
            $rspta = $noticia->insertar($idusuario, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion);
            echo $rspta ? "Noticia registrada" : "No se pudo registrar";
        } else {
            $rspta = $noticia->editar($idusuario, $idnoticia, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion);
            echo $rspta ? "Noticia actualizada" : "No se pudo actualizar";
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
                "5" => "<img src='../public/files/noticias/" . $reg->imagen . "' class='img-tabla'>",
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
