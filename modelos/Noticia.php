<?php
require "../config/Conexion.php";

class Noticia
{
    public function __construct() {}

public function insertar($idusuario, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion)
    {
        // Escapamos las comillas del HTML para que no rompan la consulta SQL
        $cuerpo_seguro = addslashes($cuerpo);

        $sql = "INSERT INTO noticia (idusuario, idcategoria, titulo, resumen, cuerpo, imagen, autor, calificacion, explicacion_calificacion, estado)
                VALUES ('$idusuario', '$idcategoria', '$titulo', '$resumen', '$cuerpo_seguro', '$imagen', '$autor', '$calificacion', '$explicacion', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($idusuario, $idnoticia, $idcategoria, $titulo, $resumen, $cuerpo, $imagen, $autor, $calificacion, $explicacion)
    {
        // Escapamos las comillas del HTML para que no rompan la consulta SQL
        $cuerpo_seguro = addslashes($cuerpo);

        $sql = "UPDATE noticia SET idusuario='$idusuario', idcategoria='$idcategoria', titulo='$titulo', resumen='$resumen', cuerpo='$cuerpo_seguro', imagen='$imagen', autor='$autor', calificacion='$calificacion', explicacion_calificacion='$explicacion' WHERE idnoticia='$idnoticia'";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idnoticia)
    {
        $sql = "SELECT n.*, c.nombre as categoria 
            FROM noticia n 
            INNER JOIN categoria c ON n.idcategoria = c.idcategoria 
            WHERE n.idnoticia='$idnoticia'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar()
    {
        // Traemos el nombre de la categoría con un JOIN
        $sql = "SELECT n.idnoticia, n.titulo, c.nombre as categoria, n.autor, n.calificacion, n.imagen, n.estado 
                FROM noticia n 
                INNER JOIN categoria c ON n.idcategoria = c.idcategoria 
                ORDER BY n.idnoticia DESC";
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
        ORDER BY n.idnoticia DESC LIMIT 6";
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
}
