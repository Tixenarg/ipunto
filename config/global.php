<?php 
// Detecta automáticamente si estás en HTTP o HTTPS
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Detecta el dominio actual (localhost, ip del servidor, o tu dominio real en Hostinger)
$dominio = $_SERVER['HTTP_HOST'];

// Si estás en localhost, le sumamos la carpeta del proyecto. Si estás en Hostinger, apunta a la raíz.
if ($dominio == "localhost") {
    define("RUTA_BASE", $protocolo . $dominio . "/ipunto/");
} else {
    define("RUTA_BASE", $protocolo . $dominio . "/"); 
}

// IP del servidor de base de datos (localhost si es local)
define("DB_HOST","localhost");

// Nombre de la base de datos
define("DB_NAME", "ipunto");

// Usuario de la base de datos
define("DB_USERNAME", "root");

// Contraseña del usuario de la base de datos
define("DB_PASSWORD", "");

// IP del servidor de base de datos (SERVIDOR)
// Nombre de la base de datos
//define("DB_NAME", "u736192581_ipunto");

// Usuario de la base de datos
//define("DB_USERNAME", "u736192581_ipunto");

// Contraseña del usuario de la base de datos
//define("DB_PASSWORD", "T;oS9X2D0");




// Codificación de los caracteres
define("DB_ENCODE","utf8");

// Nombre del proyecto
define("PRO_NOMBRE","BLOG_CHEQUEADO");
?>