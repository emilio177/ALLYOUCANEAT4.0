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
    <title>Carrito</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Agregar Toastr CSS y JS a tu página -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="../assets/css/carrito.css">
    <script
        src="https://www.paypal.com/sdk/js?client-id=ARN5czrYjMu071sfZcrw269dMcQEwOd6ChK1jcSwM3OuYbZ3z3Ndb-C3Sid_YObld_Zmf-tzba87M_0J&currency=MXN">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

<div id="currencyCode"></div>
    <a href=""></a>
    <div class="container">
        <div class="row">
            <div class="col-xs-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
                                </div>
                                <div class="col-xs-6">
                                    <button type="button" class="btn btn-primary btn-sm btn-block"
                                        href="./productos.php">
                                        <span class="glyphicon glyphicon-share-alt"></span> Continue shopping
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="mostrarCarro">

                    </div>
                    <div id="sas"></div>



</body>

</html>
<script>
$(document).ready(function() {
    recargarPagina();
    barra();
    recargarPaginaT();
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



function recargarPagina() {
    $.ajax({
        type: "GET",
        url: "../controller/user/ctrlUser.php?opc=3",
        data: {},
        success: function(data) {
            $('#mostrarCarro').html(data);
        }
    });
}

function mostrarTotal() {
    $.ajax({
        type: "GET",
        url: "../controller/user/ctrlUser.php?opc=3",
        data: {},
        success: function(data) {
            $('#total').html(data);
        }
    });
}

function borrarDeCarrito(id_producto) {
    $.ajax({
        type: "POST",
        url: "../controller/user/ctrlUser.php?opc=4",
        data: {
            id_producto: id_producto
        },
        success: function(data) {
            $('#tbMensajes').html(data); // Actualiza la tabla del carrito
        }
    });
    recargarPagina();

}

function comprarCarrito() {
    // Agrega al carrito
    $.ajax({
        type: "POST",
        url: "../controller/user/ctrlUser.php?opc=5",
        data: {},
        success: function(data) {
            $('#sas').html(data); // Actualiza la tabla del carrito
            mostrarNotificacion('¡Compra realizada con éxito!', 'success');
        },
    });
    recargarPagina();
}

function mostrarNotificacion(mensaje, tipo) {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3000, // Duración de la notificación en milisegundos
    };

    if (tipo === 'success') {
        toastr.success(mensaje);
    } else if (tipo === 'error') {
        toastr.error(mensaje);
    } else if (tipo === 'warning') {
        toastr.warning(mensaje);
    } else if (tipo === 'info') {
        toastr.info(mensaje);
    }
}
</script>

<script>
var total; // Variable global para almacenar el valor total
var titulo;
var currencyCode;
var id;

function recargarPaginaT() {
    $.ajax({
        type: "GET",
        url: "../controller/user/ctrlUser.php?opc=12",
        data: {},
        success: function(data) {
            try {
                // Intenta analizar la respuesta como JSON
                var respuestaJSON = JSON.parse(data);

                // Verifica si la respuesta contiene la clave 'total'
                if ('total' in respuestaJSON) {
                    total = respuestaJSON.total;
                   // total = "100";
                    // Hacer algo con el valor total
                    console.log("Total:", total);



                    // Llama a la función de PayPal después de obtener el valor
                 inicializarPayPal(total);
                } else {
                    console.error('La respuesta no contiene la clave "total".');
                }
            } catch (error) {
                console.error('Error al analizar la respuesta como JSON:', error);
            }
        }
    });
}

function inicializarPayPal(total) {
    paypal.Buttons({
        style: {
            color: 'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: total
                        .toString() //el valro total es el valor que aparecera al momento de pagar
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            actions.order.capture().then(function(details) {
                // Extract values from the details object
                var purchaseUnit = details.purchase_units[0];
                var amount = purchaseUnit.amount.value;
                currencyCode = purchaseUnit.amount.currency_code;
                var estado = details.status;
                id = details.id;
                // Log or use the extracted values
                console.log(details);
                console.log("Amount:", amount);
                console.log("Currency Code:", currencyCode);
                console.log("estado:", estado);
                //comprarCarrito();
                console.log("id:", id);
                ComprarConPaypal(id);

            });

        },
        // Payment canceled
        onCancel: function(data) {
            alert('Payment canceled');
            console.log(data);
        }
    }).render('#paypal-button-container');
}

function ComprarConPaypal(id) {
    // Muestra un mensaje de espera
    Swal.fire({
        title: 'Espere por favor...',
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    });

    // Agrega al carrito
    $.ajax({
        type: "POST",
        url: "../controller/user/ctrlUser.php?opc=5",
        data: {
            id: id
        },
        success: function(data) {
            // Cierra el mensaje de espera
            Swal.close();

            // Muestra mensaje de éxito
            Swal.fire({
                title: '¡Éxito!',
                text: 'El ticket se ha enviado al correo.',
                icon: 'success',
                confirmButtonText: 'Ok'
            });

            // Actualiza la tabla del carrito
            $('#currencyCode').html(data);
        },
        error: function() {
            // Cierra el mensaje de espera y muestra un mensaje de error si falla la solicitud AJAX
            Swal.close();
            Swal.fire({
                title: 'Error',
                text: 'Hubo un error al procesar la solicitud.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });

    recargarPagina();
}
</script>