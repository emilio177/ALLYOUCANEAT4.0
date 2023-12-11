<?php
class historialCompras

{
    private $db;
    private $user_id;
    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->conectar();
    }
    public function MostrarCompras($user_id)
    {
        $query = "  SELECT id_detalle_venta,nombre,primer_apellido,segundo_apellido, fecha from detalle_venta v
        join producto p on v.id_producto = p.id_producto
        join cliente c on v.id_usuario = c.id_usuario
         WHERE c.id_usuario = :user_id 
         group by fecha 
        ";
        /*
      
        */
        /*
        SELECT id_venta,nombre,primer_apellido,segundo_apellido,fecha from cliente c
        join deco.usuario u on u.id_usuario = c.id_usuario
        join deco.venta v on u.id_usuario = v.id_usuario
        WHERE c.id_usuario = :user_id
        group by fecha */

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $cursos = array(); // Inicializa un array para almacenar los cursos

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cursos[] = $row;
        }
        return $cursos; // Devuelve el array de cursos
    }
    public function MostrarICompras($user_id, $fecha)
    {
        $query = "SELECT c.id_usuario, id_detalle_venta, producto, nombre, primer_apellido, segundo_apellido, fecha,cantidad,subtotal,id_transaccion
        FROM detalle_venta v
        JOIN producto p ON v.id_producto = p.id_producto
        JOIN cliente c ON v.id_usuario = c.id_usuario
        WHERE c.id_usuario = :user_id
        AND fecha = :fecha
        ORDER BY fecha DESC;
        
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $fecha_formateada = date('Y-m-d', strtotime($fecha));
        $stmt->bindParam(':fecha', $fecha_formateada, PDO::PARAM_STR);
        $stmt->execute();

        $cursos = array(); // Inicializa un array para almacenar los cursos

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cursos[] = $row;
        }
        return $cursos; // Devuelve el array de cursos
    }
}
