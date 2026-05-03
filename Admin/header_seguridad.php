<?php
/* 1. ob_start: Prepara el "camino" para que el header("Location") funcione 
  aunque haya algún espacio en blanco accidental en otros archivos.
*/
ob_start(); 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* 2. Evitar el almacenamiento en caché:
  Esto obliga al navegador a consultar al servidor siempre. 
  Si no lo pones, el usuario podría darle al botón "Atrás" después de 
  cerrar sesión y ver el contenido bloqueado.
*/
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION["idusuario"])) {
    // Si no existe la sesión, lo mandamos al login
    header("Location: login.php");
    exit(); // 3. CRUCIAL: Detiene el script para que no se cargue nada de la noticia.
}
?>