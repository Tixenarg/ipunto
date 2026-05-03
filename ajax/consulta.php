<?php
session_start();
require_once "../modelos/Consulta.php";
$consulta = new Consulta();

switch ($_GET["op"]) {
    case 'cantidadNoticias':
        $rspta = $consulta->cantidadNoticias();
        echo json_encode($rspta);
    break;
}
?>