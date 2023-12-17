<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Administrador.php';

    class AdministradorDAO {

        public static function obtenerPasswordAdmin($usuario_id) {
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Crear una consulta preparada para evitar inyecciones SQL
            $consulta = $conexion->prepare("SELECT credencial.password FROM credencial WHERE credencial.id_administrador = ?");
            $consulta->bind_param("i", $usuario_id);
        
            // Ejecutar la consulta
            $consulta->execute();
        
            // Obtener el resultado de la consulta
            $resultado = $consulta->get_result();
        
            if ($resultado->num_rows > 0) {
                // Si encontramos algún registro relacionado, guardamos la fila relacionada a la contraseña:
                $fila = $resultado->fetch_object();
                return $fila->password;
            } else {
                // Si no encontramos ningún registro, devolveremos nulo:
                return null;
            }   
        }
        
    }
?>