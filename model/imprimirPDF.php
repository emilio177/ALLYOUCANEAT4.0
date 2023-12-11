<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Autoloader;

require_once "../../vendor/autoload.php";
require_once '../../model/historialCompra.php';
ob_start();

class imprimirPDF
{
    private $userId; // Asegúrate de obtener este ID de alguna manera
    private $db;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $con = new Conexion();
        $this->db = $con->conectar();
    }

    public function crearPDF($user, $fecha)
    {
        $mostrarVenta = new historialCompras();

        $venta = $mostrarVenta->MostrarICompras($user, $fecha);
        $dompdf = new Dompdf();
        $html = '
        <!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .datos-cliente {
            margin-bottom: 20px;
        }

        .datos-cliente h2 {
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }

        .datos {
            display: flex;
            justify-content: space-between;
        }

        .detalle {
            margin-top: 20px;
        }

        .detalle table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .detalle th,
        .detalle td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .total {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Reporte de Compras</h1>
        

        ';

        foreach ($venta as $curso) {
            $html .= '
            <div class="container">
            <div class="logo">
            </div>
    
            <div class="datos-cliente">
                <h2>Datos del Cliente</h2>
                <div class="datos">
                    <p><strong>Nombre:</strong> ' . $curso['nombre'] . ' ' . $curso['primer_apellido'] . '</p>
                    <p><strong>Dirección:aqui va la direccion despues la que usemos la api</strong> </p>
                </div>
            </div>
    
            <div class="detalle">
                <h2>Detalle de Compra</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Transaccion</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>' . $curso['producto'] . '</td>
                            <td>' . $curso['cantidad'] . '</td>
                            <td>' . $curso['id_transaccion'] . '</td>
                            <td>$' . $curso['subtotal'] . '</td>
                        </tr>
                        <!-- Puedes agregar más filas según sea necesario -->
                    </tbody>
                </table>
            </div>
        </div>
                ';
        }
        $html .= '
    </div>
</body>

</html>
';

        $dompdf->loadHtml($html);
        $dompdf->render();

        // Especifica el nombre del archivo y permite mostrarlo en el navegador
        $dompdf->stream("documento.'.$fecha.'.pdf", array('Attachment' => '0'));
        ob_end_flush();
        exit; // Importante para evitar la salida adicional que puede afectar al PDF

    }
}
