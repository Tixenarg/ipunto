<?php 
require_once "global.php";

// Creamos la conexión a la base de datos utilizando las constantes de global.php
$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Forzamos el juego de caracteres a UTF8 para evitar problemas con tildes y ñ
mysqli_query($conexion, 'SET NAMES "'.DB_ENCODE.'"');

// Si falla la conexión, mostramos el error
if (mysqli_connect_errno())
{
    printf("Falló conexión a la base de datos: %s\n", mysqli_connect_error());
    exit();
}

// Verificamos si las funciones ya existen para evitar errores de duplicidad
if (!function_exists('ejecutarConsulta'))
{
    // Función para ejecutar una consulta (Insert, Update, Delete, Select)
    function ejecutarConsulta($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $query;
    }

    // Función para obtener una sola fila (útil para el login o mostrar un artículo)
    function ejecutarConsultaSimpleFila($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }

    // Función que ejecuta una consulta y devuelve el ID insertado
    function ejecutarConsulta_retornarID($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $conexion->insert_id;
    }

    // Función para limpiar cadenas y evitar Inyección SQL y ataques XSS
    function limpiarCadena($str)
    {
        global $conexion;
        $str = mysqli_real_escape_string($conexion, trim($str));
        return htmlspecialchars($str);
    }
}
?>