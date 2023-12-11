<?php

class Usuario
{
    private $db;

    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->conectar();
    }

    public function autenticar($correo, $password)
    {
        $passwordHash = md5($password); // Aplica MD5 al password proporcionado

        $query = $this->db->prepare("SELECT * FROM usuario WHERE correo = :correo AND password = :password");
        $query->bindParam(":correo", $correo);
        $query->bindParam(":password", $passwordHash); // Utiliza el hash en la consulta

        $query->execute();


        // Validación de los datos
        if ($query->rowCount() > 0) {
            // El usuario existe
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $userID = $row['id_usuario']; // Reemplaza 'nombre_de_columna_id' con el nombre real de la columna de ID
            // Inicia la sesión
            $rolUser = ($row['id_rol']);
            $_SESSION['id_rol'] = $rolUser;


            // Almacena el ID del usuario en la sesión
            $_SESSION["id_usuario"] = $userID;
            if ($rolUser == 2) {
                $rolUser = 'user';
            } else {
                $rolUser = 'admin';
            }
            echo json_encode(array('error' => false, 'tipo' => $rolUser));
            // echo "hola";
        } else {
            // El usuario no existe
            //  echo "El nombre de usuario o la contraseña son incorrectos.";
            echo json_encode(array('error' => true));
        }
    }
    public function ValidarRol($correo, $password)
    {
    }
}
