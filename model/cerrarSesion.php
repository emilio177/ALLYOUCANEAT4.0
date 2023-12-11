<?php

class cerrarSesion
{
    private $db;

    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->conectar();
    }
    public function logoutUserById($userId)
    {
        // Destruye la sesión actual si el ID del usuario coincide
        if ($userId) {
            session_destroy();
            // Puedes realizar otras acciones de limpieza si es necesario
            return true; // La sesión se cerró con éxito
        }

        return false; // La sesión no se cerró porque el usuario no coincide o no estaba conectado
    }
}
