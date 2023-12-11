<?php
 require('conexion.php');

class login {
    private $db;

    public function __construct() {
        $con = new Conexion();
        $this->db = $con->conectar();
    }

    public function login() {
        // Obtención de los datos del formulario
        $correo = $_POST["correo"];
        $password = $_POST["password"];

        // Consulta a la base de datos
        //select usuario, contrasena from usuario;
        $query = $this->db->prepare("SELECT * FROM usuario WHERE correo = :correo and password= :password");
        $query->bindParam(":correo", $correo);
        $query->bindParam(":password", $password);
        
        $query->execute();

        // Validación de los datos
        if ($query->rowCount() > 0) {
            // El usuario existe
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $userID = $row['id_usuario']; // Reemplaza 'nombre_de_columna_id' con el nombre real de la columna de ID
            // Inicia la sesión
            session_start();

            // Almacena el ID del usuario en la sesión
            $_SESSION["id_usuario"] = $userID;

            // Redirige al usuario a la página de inicio
           //echo 'id de usuario' . $userID;
        header("Location:../vistas/productos.php");
            exit();
        } else {
            // El usuario no existe
            echo "El nombre de usuario o la contraseña son incorrectos.";
        }
    }
}
?>