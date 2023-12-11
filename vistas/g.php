<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    //  header('location: vistas2.php');
    // You may want to remove this echo statement unless it's for debugging purposes
    // echo "sesion" . $_SESSION['id_usuario'];
} else {
    //echo "Sesión no iniciada";
    header('location: Login.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gráfico de Ventas por Período</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="../assets/css/g.css">
    <style>
     
    </style>
</head>

<body>


    <form id="fechaForm">
        <label for="fechaInicio">Fecha Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio" required>

        <label for="fechaFinal">Fecha Final:</label>
        <input type="date" id="fechaFinal" name="fechaFinal" required>

        <button type="button" onclick="obtenerDatos()">Generar Gráfico</button>
    </form>

    <div id="columnchart_material"></div>

    <script type="text/javascript">
        function obtenerDatos() {
            var fechaInicio = $('#fechaInicio').val();
            var fechaFinal = $('#fechaFinal').val();

            // Realiza la petición AJAX al controlador
            $.ajax({
                url: '../controller/Admin/ctrlPanel.php?opc=5',
                type: 'POST',
                data: { fechaInicio: fechaInicio, fechaFinal: fechaFinal },
                dataType: 'json',
                success: function (data) {
                    // Llama a la función para dibujar el gráfico con los datos recibidos
                    dibujarGrafico(data);
                },
                error: function (error) {
                    console.error('Error en la petición AJAX:', error);
                }
            });
        }

        function dibujarGrafico(data) {
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(function () {
                var chartData = new google.visualization.DataTable();
                chartData.addColumn('string', 'Fecha');
                chartData.addColumn('number', 'Cantidad');

                for (var i = 0; i < data.length; i++) {
                    chartData.addRow([data[i].fecha, data[i].cantidad]);
                }

                var options = {
                    chart: {
                        title: 'Ventas por Período',
                        subtitle: 'Cantidad de Ventas por Fecha',
                    }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
                chart.draw(chartData, options);
            });
        }
    </script>

</body>

</html>
