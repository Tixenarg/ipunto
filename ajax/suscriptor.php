<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "../modelos/Suscriptor.php";

$suscriptor = new Suscriptor();

$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";

switch ($_GET["op"]) {
    case 'guardar':
        // Validamos que sea un email real en el servidor también
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $rspta = $suscriptor->insertar($email);
            echo $rspta; // devolverá "ok", "existe" o "error"
        } else {
            echo "invalido";
        }
    break;
}
?>