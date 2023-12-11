<?php

class crearUsuario
{
    private $db;

    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->conectar();
    }
    public function crearUsuario($correo, $password)
    {
        $password_md5 = md5($password);
        $id_rol = 2;
        $query = "INSERT INTO usuario (correo, password, id_rol) VALUES (:correo, :password, :id_rol)";
        $rs = $this->db->prepare($query);
        $rs->bindParam(":correo", $correo);
        $rs->bindParam(":password", $password_md5);
        $rs->bindParam(":id_rol", $id_rol);
        $rs->execute();
    }

    public function crearCliente($nombre, $primer_apellido, $segundo_apellido, $id_usuario)
    {

        $query = "INSERT INTO cliente (nombre, primer_apellido, segundo_apellido, id_usuario) VALUES
                                     (:nombre, :primer_apellido, :segundo_apellido, :id_usuario)";
        $rs = $this->db->prepare($query);
        $rs->bindParam(":nombre", $nombre);
        $rs->bindParam(":primer_apellido", $primer_apellido);
        $rs->bindParam(":segundo_apellido", $segundo_apellido);
        $rs->bindParam(":id_usuario", $id_usuario);
        $rs->execute();
    }

    public function trerCorreo($correo)
    {
        $query = $this->db->prepare("SELECT id_usuario FROM usuario WHERE correo = :correo");
        $query->bindParam(":correo", $correo);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['id_usuario'];
    }

    public function crearUsuarioYCliente($nombre, $primer_apellido, $segundo_apellido, $correo, $password)
    {
        $this->db->beginTransaction();
        try {
            $this->crearUsuario($correo, $password); //creamos el usuario
            
            $id_usuario = $this->trerCorreo($correo); //solicitamos el correo
            $this->crearCliente($nombre, $primer_apellido, $segundo_apellido, $id_usuario); //creamos el usuario
            $this->db->commit(); //fin de la transaccion
        } catch (PDOException $e) {
            $this->db->rollBack();
            $response = array(
                'success' => false,
                'message' => 'Error: Transacción fallida ' . $e->getMessage()
            );

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }


    public function validarCorreo($correo)
    {
        $query = "SELECT count(correo)  from usuario WHERE correo= :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $existeCompra = $stmt->fetchColumn();
        return $existeCompra;
    }
}
