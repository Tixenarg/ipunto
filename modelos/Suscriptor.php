<?php
// 1. Llamamos al archivo de conexión (asegurate que la 'C' mayúscula coincida con el nombre de tu archivo real)
require "../config/Conexion.php";

class Suscriptor {
    
    // Constructor vacío (siempre es buena práctica dejarlo)
    public function __construct() {}

    // Método para guardar el correo
    public function insertar($email) {
        
        // Limpiamos espacios en blanco por si el usuario metió un espacio sin querer
        $email = trim($email);

        // PASO A: Verificamos si el correo ya existe en la tabla 'suscriptores'
        $sql_check = "SELECT * FROM suscriptores WHERE email = '$email'";
        $existe = ejecutarConsultaSimpleFila($sql_check);
        
        if ($existe) {
            return "existe"; // Cortamos acá y avisamos que ya está registrado
        }

        // PASO B: Si no existe, armamos la consulta para insertarlo
        $sql_insert = "INSERT INTO suscriptores (email, estado) VALUES ('$email', '1')";
        $resultado = ejecutarConsulta($sql_insert);
        
        // Si el insert funcionó devuelve "ok", sino "error"
        if ($resultado) {
            return "ok";
        } else {
            return "error";
        }
    }
}
?>