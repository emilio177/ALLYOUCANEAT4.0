jQuery(document).on('submit', '#forming', function (event) {
    event.preventDefault();
    jQuery.ajax({
        url: '../controller/ctrlogin.php',
        type: 'POST',
        dataType: 'json',
        data: jQuery(this).serialize(),
        beforeSend: function () {
            // Puedes realizar acciones antes de enviar la solicitud aquí
            jQuery('.botonlg').val('validando...'); // Debes usar jQuery en lugar de $
        }
    })
        .done(function (respuesta) {
            console.log(respuesta);
            if (!respuesta.error) {
                alert("credenciales validas");
                window.location.href = '../vistas/productos.php';
            } else {
                alert('Credenciales no válidas');
            }
        })
        .fail(function (resp) {
            console.log(resp.responseText);
        })
        .always(function () {
            console.log("complete");
        });
});
