<?php
require "../config/Conexion.php";


class Noticia
{
    public function __construct() {}
/**
     * @param mixed $idusuario
     * @param mixed $idcategoria
     * @param mixed $titulo
     * @param mixed $resumen
     * @param mixed $cuerpo
     * @param mixed $imagen
     * @param mixed $autor
     * @param mixed $calificacion
     * @param mixed $explicacion
     */
public function insertar($idusuario, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion, $categorias_seccion, $subtitulos, $cuerpos_seccion, $imagenes_seccion_nombres)
    {
        global $conexion; 
        $cuerpo_seguro = addslashes($cuerpo);

        // Inserción en la tabla principal
        $sql = "INSERT INTO noticia (idusuario, idcategoria, titulo, resumen, cuerpo, imagen, autor, calificacion, explicacion_calificacion, estado)
                VALUES ('$idusuario', '$idcategoria', '$titulo', '$resumen', '$cuerpo_seguro', '$imagen', '$autor', '$calificacion', '$explicacion', '1')";
        
        $idnoticianew = ejecutarConsulta_retornarID($sql);

        if (!$idnoticianew || $idnoticianew == 0) {
            return "Error MySQL Cabecera: " . mysqli_error($conexion);
        }

        // CORRECCIÓN: Ahora se inserta categoria_seccion y orden correctamente
        $num_elementos = count($subtitulos);
        for ($i = 0; $i < $num_elementos; $i++) {
            $cat_sec = isset($categorias_seccion[$i]) ? addslashes($categorias_seccion[$i]) : "";
            $sub_sec = isset($subtitulos[$i]) ? addslashes($subtitulos[$i]) : "";
            $cue_sec = isset($cuerpos_seccion[$i]) ? addslashes($cuerpos_seccion[$i]) : "";
            $img_sec = isset($imagenes_seccion_nombres[$i]) ? $imagenes_seccion_nombres[$i] : "";
            $orden = $i + 1; 

            $sql_seccion = "INSERT INTO noticia_seccion (idnoticia, categoria_seccion, subtitulo, cuerpo, imagen, orden) 
                            VALUES ('$idnoticianew', '$cat_sec', '$sub_sec', '$cue_sec', '$img_sec', '$orden')";
            
            $res_sec = ejecutarConsulta($sql_seccion);
            if (!$res_sec) {
                return "Error MySQL Sección N° $orden: " . mysqli_error($conexion);
            }
        }

        return true; 
    }

    public function editar($idusuario, $idnoticia, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion, $categorias_seccion, $subtitulos, $cuerpos_seccion, $imagenes_seccion_nombres)
    {
        global $conexion;
        $cuerpo_seguro = addslashes($cuerpo);

        // CORRECCIÓN: Quitamos el campo fantasma 'clasificacion' del UPDATE
        $sql = "UPDATE noticia SET idusuario='$idusuario', idcategoria='$idcategoria', titulo='$titulo', resumen='$resumen', cuerpo='$cuerpo_seguro', imagen='$imagen', autor='$autor', calificacion='$calificacion', explicacion_calificacion='$explicacion' WHERE idnoticia='$idnoticia'";
        
        $sw = ejecutarConsulta($sql);
        if (!$sw) {
            return "ERR-EDIT-MAIN: Falló la actualización de la cabecera. Código MySQL: " . mysqli_error($conexion);
        }

        // Rescatamos las imágenes que ya estaban en el formulario para no perderlas
        $imagenes_seccion_actuales = isset($_POST["imagenes_seccion_actuales"]) ? $_POST["imagenes_seccion_actuales"] : array();

        // Limpiamos bloques viejos
        $sql_del = "DELETE FROM noticia_seccion WHERE idnoticia='$idnoticia'";
        ejecutarConsulta($sql_del);

        // Re-insertamos bloques
        $num_elementos = count($subtitulos);
        for ($i = 0; $i < $num_elementos; $i++) {
            $cat_sec = isset($categorias_seccion[$i]) ? addslashes($categorias_seccion[$i]) : "";
            $sub_sec = isset($subtitulos[$i]) ? addslashes($subtitulos[$i]) : "";
            $cue_sec = isset($cuerpos_seccion[$i]) ? addslashes($cuerpos_seccion[$i]) : "";
            $orden = $i + 1;

            // CORRECCIÓN DE FOTOS: Si no subió foto nueva, usa la foto actual.
            if (!empty($imagenes_seccion_nombres[$i])) {
                $img_sec = $imagenes_seccion_nombres[$i];
            } else {
                $img_sec = isset($imagenes_seccion_actuales[$i]) ? $imagenes_seccion_actuales[$i] : "";
            }

            // CORRECCIÓN: Nombres de columnas iguales a tu DB (categoria_seccion, imagen, orden)
            $sql_seccion = "INSERT INTO noticia_seccion (idnoticia, categoria_seccion, subtitulo, cuerpo, imagen, orden) 
                            VALUES ('$idnoticia', '$cat_sec', '$sub_sec', '$cue_sec', '$img_sec', '$orden')";
            
            $res_sec = ejecutarConsulta($sql_seccion);
            if (!$res_sec) {
                return "ERR-EDIT-BLOCK: Falló al reescribir el Bloque N° " . ($i + 1) . ". Código MySQL: " . mysqli_error($conexion);
            }
        }

        return true;
    }
    public function mostrar($idnoticia)
    {
        $sql = "SELECT n.*, c.nombre as categoria 
            FROM noticia n 
            INNER JOIN categoria c ON n.idcategoria = c.idcategoria 
            WHERE n.idnoticia='$idnoticia'";
        return ejecutarConsultaSimpleFila($sql);
    }

public function listar($filtro = 'activas')
    {
        // Traemos los datos esenciales, sumando la calificación (Tipo de nota)
        $sql = "SELECT n.idnoticia, n.titulo, n.fecha_publicacion, n.imagen, n.estado, n.calificacion 
                FROM noticia n ";
        
        // Aplicamos la magia del filtro inteligente
        if ($filtro == 'activas') {
            $sql .= " WHERE n.estado = '1' ";
        } else if ($filtro == 'borradores') {
            $sql .= " WHERE n.estado = '0' ";
        }
        
        $sql .= " ORDER BY n.idnoticia DESC";
        return ejecutarConsulta($sql);
    }

    // Método para listar solo las noticias activas en la parte pública
    public function listarActivos()
    {
        $sql = "SELECT n.idnoticia, n.titulo, n.resumen, n.cuerpo, n.imagen, n.autor, n.fecha_publicacion, c.nombre as categoria 
            FROM noticia n 
            INNER JOIN categoria c ON n.idcategoria = c.idcategoria 
            WHERE n.estado = '1' 
            ORDER BY n.idnoticia DESC";
        return ejecutarConsulta($sql);
    }

    public function desactivar($idnoticia)
    {
        $sql = "UPDATE noticia SET estado='0' WHERE idnoticia='$idnoticia'";
        return ejecutarConsulta($sql);
    }

    public function activar($idnoticia)
    {
        $sql = "UPDATE noticia SET estado='1' WHERE idnoticia='$idnoticia'";
        return ejecutarConsulta($sql);
    }

    // Método para listar solo las 6 últimas NOTICIAS (Excluye opiniones)
    // Trae las últimas 6 noticias (excluyendo opiniones)
    public function listarUltimasNoticias()
    {
        $sql = "SELECT n.idnoticia, n.titulo, n.resumen, n.cuerpo, n.imagen, n.autor, n.fecha_publicacion, c.nombre as categoria, n.calificacion 
        FROM noticia n 
        INNER JOIN categoria c ON n.idcategoria = c.idcategoria 
        WHERE n.estado = '1' AND n.calificacion != 'Opinion' AND n.calificacion != 'Opinión'
        ORDER BY n.idnoticia DESC LIMIT 7";
        return ejecutarConsulta($sql);
    }

    // Trae solo la última opinión
    public function listarUltimaOpinion()
    {
        $sql = "SELECT n.idnoticia, n.titulo, n.resumen, n.cuerpo, n.imagen, n.autor, n.fecha_publicacion, c.nombre as categoria, n.calificacion 
        FROM noticia n 
        INNER JOIN categoria c ON n.idcategoria = c.idcategoria 
        WHERE n.estado = '1' AND (n.calificacion = 'Opinion' OR n.calificacion = 'Opinión')
        ORDER BY n.idnoticia DESC LIMIT 1";
        return ejecutarConsulta($sql);
    }

    // Implementar un método para listar las secciones de una noticia
    public function mostrarSecciones($idnoticia) {
        // Buscamos todas las secciones de esta noticia y las ordenamos por la columna 'orden'
        $sql = "SELECT * FROM noticia_seccion WHERE idnoticia='$idnoticia' ORDER BY idseccion ASC";
        return ejecutarConsulta($sql); 
    }
}
