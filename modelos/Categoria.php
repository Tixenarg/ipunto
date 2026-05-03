<?php 
// Incluimos la conexión a la base de datos
require "../config/Conexion.php";

Class Categoria
{
    // Implementamos nuestro constructor
    public function __construct()
    {
    }

    // Método para insertar registros
    public function insertar($nombre, $descripcion)
    {
        $sql = "INSERT INTO categoria (nombre, descripcion, condicion)
                VALUES ('$nombre', '$descripcion', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para editar registros
    public function editar($idcategoria, $nombre, $descripcion)
    {
        $sql = "UPDATE categoria SET nombre='$nombre', descripcion='$descripcion' 
                WHERE idcategoria='$idcategoria'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar los datos de un registro a modificar
    public function mostrar($idcategoria)
    {
        $sql = "SELECT * FROM categoria WHERE idcategoria='$idcategoria'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los registros
    public function listar()
    {
        $sql = "SELECT * FROM categoria";
        return ejecutarConsulta($sql);
    }

    // Método para listar solo las categorías activas (El que usa el Select de Noticias)
    public function select()
    {
        // Nota: Asegúrate de que en tu tabla 'categoria' la columna se llame 'condicion' o 'estado'
        $sql = "SELECT * FROM categoria WHERE condicion = 1";
        return ejecutarConsulta($sql);
    }
}
?>