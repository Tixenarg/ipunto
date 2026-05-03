<?php
// Incluímos la conexión a la base de datos
require "../config/Conexion.php";

class Consulta
{
    // Constructor vacío
    public function __construct() {}

    public function cantidadNoticias()
    {
        $sql = "SELECT 
        (SELECT COUNT(*) FROM noticia) as total,
        (SELECT COUNT(*) FROM noticia WHERE calificacion='Opinion') as verdaderas,
        (SELECT COUNT(*) FROM noticia WHERE calificacion='Noticias') as falsas,
        (SELECT COUNT(*) FROM usuario) as usuarios";
        return ejecutarConsultaSimpleFila($sql);
    }
}
