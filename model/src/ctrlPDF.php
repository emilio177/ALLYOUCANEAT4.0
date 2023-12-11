<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Autoloader;

require_once '../../model/historialCompra.php';
require_once("../../vendor/autoload.php");
require_once '../../adodb5/adodb.inc.php';
require_once '../../model/imprimirPDF.php';
require_once '../../model/conexion.php';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$imprimir = new imprimirPDF($_SESSION["id_usuario"]);

$dompdf = new Dompdf($options);
// Devuelve el contenido como respuesta
//echo $content;
$mostrarVenta = new historialCompras();

if (isset($_GET['opc'])) {
    $opc = $_GET['opc'];
    //echo ($opc);
    switch ($opc) {
        case '1': ///mostrar historial de compras
            if (isset($_SESSION["id_usuario"])) {
                $venta = $mostrarVenta->MostrarCompras($_SESSION["id_usuario"]);
                foreach ($venta as $curso) {
                    echo '
                    <style>
    .curso-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .display-1 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .cat-origen {
        font-size: 1.2em;
        margin-bottom: 5px;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }
</style>
                    
                    <div class="curso-card">';
                    echo '<p class="display-1 pt-2 nombre-pro">compra del usuario= ' . $curso['nombre'] . ' ' . $curso['primer_apellido'] . ' ' . $curso['segundo_apellido'] . '</p>';
                    echo '<p class="cat-origen pb-1">compra del dia=' . $curso['fecha'] . '</p>';
                    echo '<p class="cat-origen pb-1">idventa=' . $curso['id_venta'] . '</p>';
                    echo '<a href="../controller/pdf/ctrlPDF.php?opc=2&id_venta=' . $curso['id_venta'] . '&fecha=' . $curso['fecha'] . '" target="_blank">aaaaa</a>';

                    echo '</div>';
                }
            } else {
                echo "El usuario no está definido";
            }
            break;
        case '2': //imprimir pdf
            $id_venta = isset($_GET['id_venta_detalle']) && isset($_GET['fecha']) ? $_GET['id_venta'] : NULL;
            $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : NULL;

            $fecha = $_GET['fecha'];
            echo $fecha . "  " . $_SESSION["id_usuario"] . " " . $id_venta;

            $imprimir->crearPDF($_SESSION["id_usuario"], $fecha);
            exit;
    }
}
