<?php

class admin_panel
{
    private $db;
    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->conectar();
    }

    public function graficaVentaPeriodo($fecha1, $fecha2)
    {
        $query = "SELECT count(v.id_producto) as cantidad,fecha
        from detalle_venta v join producto p on p.id_producto = v.id_producto
         WHERE fecha BETWEEN :fechaInicio AND :fechaFinal
                          GROUP BY fecha
";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':fechaInicio', $fecha1);
        $stmt->bindParam(':fechaFinal', $fecha2);
        $stmt->execute();

        $cursos = array(); // Inicializa un array para almacenar los cursos

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cursos[] = $row;
        }

        return $cursos;
    }
}