<?php
require_once '../model/crearUsuario.php';
require_once '../model/conexion.php';

$recaptchaSecretKey = '6LfXi_8oAAAAABDaB25yPOKfh4Yq3fNRzDupSMB6'; // Reemplaza con tu clave secreta de reCAPTCHA
$recaptchaResponse = $_POST['g-recaptcha-response'];

$recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecretKey&response=$recaptchaResponse";
$recaptchaResponse = file_get_contents($recaptchaUrl);
$recaptchaData = json_decode($recaptchaResponse);
if ($recaptchaData->success) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Captura los datos del formulario
        $nombre = $_POST["nombre"];
        $primer_apellido = $_POST["primer_apellido"];
        $segundo_apellido = $_POST["segundo_apellido"];
        $correo = $_POST["correo"];
        $password = $_POST["password"];
        // Realiza las operaciones necesarias con los datos, por ejemplo, insertar en la base de datos
        $user = new crearUsuario();
        //validacion de correo
        $numeroCorreo = $user->validarCorreo($correo);
        if ($numeroCorreo > 0) {
            $response = array(
                'success' => false,
                'message' => 'Error: El correo ya está registrado.'
            );
            // Envía la respuesta como JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // echo $nombre, $primer_apellido,$segundo_apellido,$correo,$password;
            $user->crearUsuarioYCliente($nombre, $primer_apellido, $segundo_apellido, $correo, $password);
            $response = array(
                'success' => true,
                'message' => 'Registro exitoso'
            );
            // Envía la respuesta como JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            // header("Location: Admin/ctrlAdmin.php");
        }

        // Luego, prepara una respuesta en formato JSON
    } else {
        $response = array(
            'success' => false
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // El captcha no se completó con éxito
    // Muestra un mensaje de error o realiza alguna acción
    // Puedes enviar una respuesta JSON con un mensaje de error si lo deseas
    $response = array(
        'success' => false,
        'message' => 'complete el captcha porFavor'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}
