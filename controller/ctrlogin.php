<?php
require_once '../model/usuario.php';
require_once '../model/conexion.php';

// Comprobar si se recibió una solicitud POST para iniciar sesión


if (isset($_POST['correo']) && isset($_POST['password'])) {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $user = new Usuario();

    if ($user->autenticar($correo, $password)) {
    } else {
    }
} else {
    header('Location: ../login.html');
    exit;
}
