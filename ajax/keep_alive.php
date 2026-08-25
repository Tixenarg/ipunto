<?php
// Solo inicia o reanuda la sesión para reiniciar el temporizador del servidor
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Devolvemos un JSON confirmando que la sesión sigue viva
header('Content-Type: application/json');
echo json_encode([
    "status" => "activa", 
    "hora" => date("H:i:s")
]);
?>