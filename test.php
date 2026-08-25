<?php
// Muestra el tiempo máximo de vida de la sesión en tu servidor
$segundos = ini_get('session.gc_maxlifetime');
$minutos = $segundos / 60;

echo "<h3>Tu servidor destruye las sesiones inactivas a los: <strong>" . $segundos . " segundos (" . $minutos . " minutos)</strong>.</h3>";
?>