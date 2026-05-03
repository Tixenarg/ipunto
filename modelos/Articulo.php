<?php 
// Incluímos la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
    // Constructor vacío
    public function __construct() {}

    // Método para listar las categorías en los select (combos)
    public function select()
    {
        $sql = "SELECT * FROM categoria WHERE condicion=1";
        return ejecutarConsulta($sql);		
    }

    // Otros métodos que podrías necesitar para gestionar categorías
    public function listarCategorias()
    {
        $sql = "SELECT * FROM categoria";
        return ejecutarConsulta($sql);
    }
}
?>