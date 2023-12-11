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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platillos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/js/carrito.js">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/platillos.css">
</head>

<body>

    <header>

        <!--Barra de Navegacion
    
     <a href="../controller/user/ctrlUser.php?opc=11">cerrar la sesion</a>
        <a href="historialDeCompras.html">historial</a>
    
    -->

    </header>
    <div id="mostrarBarra"></div>
    <main>
        <div id="mostrarProductos" class="mostrar"></div>
    </main>

</body>
<script>
let contador = 0;
$(document).ready(function() {
    barra();
    ctrlMostrarP();
    carritoContador();
});

function barra() {
    $.ajax({
        url: '../controller/user/ctrlUser.php?opc=6',
        type: 'GET',
        success: function(response) {
            $('#mostrarBarra').html(response);
        },
        error: function() {
            // Maneja errores si la solicitud AJAX falla
            $('#mostrarBarra').html('Error al cargar la barra de navegación');
        }
    });
}



function ctrlMostrarP() {
    $.ajax({
        url: '../controller/user/ctrlUser.php?opc=1',
        type: 'GET',
        success: function(response) {
            $('#mostrarProductos').html(response);
        },
        error: function() {
            // Maneja errores si la solicitud AJAX falla
            $('#mostrar').html('Error al cargar la barra de navegación');
        }
    });
}

function aumentarContador(idProducto) {
    var contador = document.getElementById('contador-' + idProducto);
    var valorActual = parseInt(contador.textContent);
    contador.textContent = valorActual + 1;
    actualizarURLCarrito(idProducto, valorActual + 1);
}

function disminuirContador(idProducto) {
    var contador = document.getElementById('contador-' + idProducto);
    var valorActual = parseInt(contador.textContent);
    if (valorActual > 0) {
        contador.textContent = valorActual - 1;
        actualizarURLCarrito(idProducto, valorActual - 1);
    }
}

function actualizarURLCarrito(idProducto, cantidad) {
    var link = document.getElementById('add-to-cart-link-' + idProducto);
    //  link.href = `../controller/user/ctrlUser.php?opc=2&id=${idProducto}&cantidad=${cantidad}`;
    contador = cantidad;
    console.log("contador= " + contador);

}


function carritoContador() {
    $.ajax({
        url: '../controller/user/ctrlUser.php?opc=8',
        type: 'GET',
        success: function(response) {
            $('#contador-value').html(response);
        },
        error: function() {
            // Maneja errores si la solicitud AJAX falla
            $('#contador').html('Error al cargar la barra de navegación');
        }
    });
}

function actualizarCarrito(id_producto, cantidad) {
    ctrlMostrarP();
    cantidad = contador;
    console.log("cantidad".cantidad);
    $.ajax({
        url: `../controller/user/ctrlUser.php?opc=2&id_producto=${id_producto}&contador=${contador}`,
        type: 'GET',
        success: function(response) {
            $('#mostrar').html(response);
            contador = 0;
        },
        error: function() {
            // Maneja errores si la solicitud AJAX falla
            $('#mostrar').html('Error al cargar la barra de navegación');
        }
    });
    carritoContador();
    ctrlMostrarP();

}
</script>
<footer>

</footer>

</html>