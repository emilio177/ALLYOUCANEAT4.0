<?php
require_once '../../model/productos_model.php';
require_once '../../model/conexion.php';
require_once '../../model/carrito.php';
require_once '../../model/adminPanel.php';
require_once '../../adodb5/adodb.inc.php';
require_once '../../model/enviarCorreo.php';  
//require_once '../../assets/img/gracias.jpeg';

$content = 'Este es el contenido del panel administrador';
$data = array("2023-10-11" => 12, "Ron" => 39);

$adminPanel = new admin_panel();
//echo 'llego al controlador';
if (isset($_GET['opc'])) {
    $opc = $_GET['opc'];
    //echo ($opc);
    switch ($opc) {
        case 5: //graficas
            // Realiza la lógica para la opción 5 (por ejemplo, llama a tu función graficaVentaPeriodo)
            if (isset($_POST['fechaInicio']) && isset($_POST['fechaFinal'])) {
                $fechaInicio = $_POST['fechaInicio'];
                $fechaFinal = $_POST['fechaFinal'];
                //echo '' .$fechaInicio.'   '.$fechaFinal;

                // Llama a tu función para obtener los datos
                $datos = $adminPanel->graficaVentaPeriodo($fechaInicio, $fechaFinal);

                // Devuelve los datos en formato JSON
                header('Content-Type: application/json');
                echo json_encode($datos);
                exit;
            } else {
                // Manejo de error si las fechas no están presentes en la solicitud
                echo json_encode(['error' => 'Fechas no proporcionadas']);
                exit;
            }
        default:
            // Manejo de error si la opción no es válida
            echo json_encode(['error' => 'Opción no válida']);
            exit;
    }
} else {
    // Manejo de error si la opción no está presente en la solicitud
    echo json_encode(['error' => 'Opción no proporcionada']);
    exit;
}

