<?php
require "../config/Conexion.php";

class Usuario
{
    public function __construct() {}

    // Método para insertar usuario (usando password_hash)
    public function insertar($nombre, $apellido, $login, $clave, $tipo, $imagen)
    {
        $clave_hash = password_hash($clave, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (nombre, apellido, login, clave, tipo, imagen, estado)
                VALUES ('$nombre', '$apellido', '$login', '$clave_hash', '$tipo', '$imagen', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para verificar login
    public function verificar($login, $clave)
    {
        
        $sql = "SELECT idusuario, nombre, apellido, login, clave, tipo FROM usuario WHERE login='$login' AND estado='1'";
        $res = ejecutarConsulta($sql);
        $fetch = $res->fetch_object();

        if ($fetch && password_verify($clave, $fetch->clave)) {
            return $fetch; // Login exitoso
        } else {
            return false; // Login fallido
        }
    }


    public function editar($idusuario, $nombre, $apellido, $login, $clave, $tipo, $imagen)
    {
        // Si la clave no está vacía, la hasheamos para actualizarla
        if (!empty($clave)) {
            $clave_hash = password_hash($clave, PASSWORD_DEFAULT);
            $sql = "UPDATE usuario SET nombre='$nombre', apellido='$apellido', login='$login', clave='$clave_hash', tipo='$tipo', imagen='$imagen' WHERE idusuario='$idusuario'";
        } else {
            // Si está vacía, actualizamos todo menos la clave
            $sql = "UPDATE usuario SET nombre='$nombre', apellido='$apellido', login='$login', tipo='$tipo', imagen='$imagen' WHERE idusuario='$idusuario'";
        }
        return ejecutarConsulta($sql);
    }

    public function desactivar($idusuario)
    {
        $sql = "UPDATE usuario SET estado='0' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    public function activar($idusuario)
    {
        $sql = "UPDATE usuario SET estado='1' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuario WHERE idusuario='$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar()
    {
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql);
    }
}
