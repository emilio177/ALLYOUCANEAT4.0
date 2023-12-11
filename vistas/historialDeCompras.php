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
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/iniciousuario.css">
    <link rel="icon" href="../assets/imagenes/Tacos.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/headerMenu.css">
    <link rel="stylesheet" href="../assets/js/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/historial.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="mostrarBarra"></div>
    <script>
        function cargarBarraDeNavegacion() {
            $.ajax({
                url: '../controller/pdf/ctrlPDF.php?opc=1',
                type: 'GET',
                success: function (response) {
                    $('#barra-navegacion-container').html(response);
                },
                error: function () {
                    // Maneja errores si la solicitud AJAX falla
                    $('#barra-navegacion-container').html('Error al cargar la barra de navegación');
                }
            });

        }
        function barra() {
            $.ajax({
                url: '../controller/user/ctrlUser.php?opc=6',
                type: 'GET',
                success: function (response) {
                    $('#mostrarBarra').html(response);
                },
                error: function () {
                    // Maneja errores si la solicitud AJAX falla
                    $('#mostrarBarra').html('Error al cargar la barra de navegación');
                }
            });
        }

        function imprimir() {
            // Agrega al carrito
            $.ajax({
                type: "POST",
                url: "../controller/pdf/ctrlPDF.php?opc=2",
                data: {},
                success: function (data) {
                    $('#compra').html(data); // Actualiza la tabla del carrito
                },
            });
        }
    </script>
</head>

<body>
    <br>
    <div id="barra-navegacion-container"></div>
    <div id=""></div>
</body>

</html>


<script>
    $(document).ready(function () {
        // Realiza una solicitud AJAX para obtener el valor de id_rol desde PHP
        cargarBarraDeNavegacion();
        barra();



    });
</script>