<?php
session_start();
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

// Captura de datos (si vienen por POST)
$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$apellido = isset($_POST["apellido"]) ? limpiarCadena($_POST["apellido"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$tipo = isset($_POST["tipo"]) ? limpiarCadena($_POST["tipo"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idusuario)) {
            // Insertar nuevo usuario (la clave se hashea en el modelo)
            $rspta = $usuario->insertar($nombre, $apellido, $login, $clave, $tipo, $imagen);
            echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
        } else {
            // Editar usuario existente
            $rspta = $usuario->editar($idusuario, $nombre, $apellido, $login, $clave, $tipo, $imagen);
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
    break;

    case 'desactivar':
        $rspta = $usuario->desactivar($idusuario);
        echo $rspta ? "Usuario Desactivado" : "No se puede desactivar";
    break;

    case 'activar':
        $rspta = $usuario->activar($idusuario);
        echo $rspta ? "Usuario Activado" : "No se puede activar";
    break;

    case 'mostrar':
        $rspta = $usuario->mostrar($idusuario);
        // Codificamos el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta = $usuario->listar();
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => ($reg->estado) ? 
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>' :
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
                "1" => $reg->nombre . " " . $reg->apellido,
                "2" => $reg->login,
                "3" => $reg->tipo,
                "4" => ($reg->estado) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
            );
        }
        $results = array(
            "sEcho" => 1, // Información para el datatables
            "iTotalRecords" => count($data), // enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), // enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;

    case 'verificar':
        // Caso específico para el Login
        $logina = isset($_POST["logina"]) ? $_POST["logina"] : "";
        $clavea = isset($_POST["clavea"]) ? $_POST["clavea"] : "";

        $rspta = $usuario->verificar($logina, $clavea);

        if ($rspta) {
            // Declaramos las variables de sesión
            $_SESSION['idusuario'] = $rspta->idusuario;
            $_SESSION['nombre'] = $rspta->nombre;
            $_SESSION['apellido'] = $rspta->apellido;
            $_SESSION['login'] = $rspta->login;
            $_SESSION['tipo'] = $rspta->tipo;
            
            echo "1"; // Éxito
        } else {
            echo "0"; // Fallo
        }
    break;

    case 'salir':
        // Limpiamos las variables de sesión
        session_unset();
        // Destruimos la sesión
        session_destroy();
        // Redireccionamos al login
        header("Location: ../Admin/login.php");
        exit();
    break;
}
?>