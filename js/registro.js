jQuery(document).on('submit', '#forming', function (event) {
    event.preventDefault();

    // Verificar el captcha antes de continuar
    var response = grecaptcha.getResponse();

    if (!response) {
        response = 'completa el captcha';
        // El captcha no se completó
        alert('Por favor, complete el captcha.');
        jQuery('#error').html(response);
        jQuery('#error').slideDown('slow');
        setTimeout(function () {
            jQuery('#error').slideUp('slow');
        }, 3000);
        return;
    }

    // Continúa con el envío del formulario si el captcha se completó
    jQuery.ajax({
        url: '../controller/ctrlRegistrar.php',
        type: 'POST',
        dataType: 'json',
        data: jQuery(this).serialize(),
        beforeSend: function () {
            // jQuery('.botonlg').val('Validando...');
        }
    })
        .done(function (respuesta) {
            if (respuesta.success) {
                alert("exito");
                // Actualiza el contenido del div con el mensaje de respuesta
                jQuery('#error').html(respuesta.message);
                jQuery('#error').slideDown('slow');
                setTimeout(function () {
                    jQuery('#error').slideUp('slow');
                }, 3000);
                $('#successModal').find('.modal-body').html(respuesta.message);
                $('#successModal').modal('show');
                setTimeout(function () {
                    // Realiza otra acción aquí, por ejemplo, redirige a otra página
                    window.location.href = '../index.php';
                }, 1000);

            } else {
                alert('correo duplicado');
                jQuery('#error').html(respuesta.message);
                //alert(respuesta.message);
                jQuery('#error').slideDown('slow');
                setTimeout(function () {
                    jQuery('#error').slideUp('slow');
                }, 1000);
                console.log('Error: ' + respuesta.message);
                grecaptcha.reset();
                // Puedes mostrar un mensaje de error
            }
        })

        .fail(function (resp) {
            console.log(resp.responseText);
        })
        .always(function () {
            console.log('Complete');

        });
});
