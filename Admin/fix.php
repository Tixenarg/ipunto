<?php
require_once "../config/Conexion.php";

// Generamos el Hash real desde TU propio servidor
$clave_nueva = "admin123";
$hash_sistema = password_hash($clave_nueva, PASSWORD_DEFAULT);

// Actualizamos la base de datos con este hash exacto
$sql = "UPDATE usuario SET clave = '$hash_sistema' WHERE login = 'admin'";

if (ejecutarConsulta($sql)) {
    echo "<h3>¡Contraseña actualizada con éxito!</h3>";
    echo "Tu nuevo hash generado es: " . $hash_sistema . "<br>";
    echo "Ahora intenta loguearte con <b>admin</b> y <b>admin123</b> en la página de login.";
} else {
    echo "Error al actualizar la base de datos.";
}
?>