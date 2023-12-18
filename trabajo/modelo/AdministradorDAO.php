<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Administrador.php';

    class AdministradorDAO {

        public static function getPasswordAdmin($usuario_id) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Crearemos una consulta para buscar la contraseña del administrador:
            $consulta = $conexion->prepare("SELECT credencial.password FROM credencial WHERE credencial.id_administrador = ?");
            
            // Vincularemos los parámetros:
            $consulta->bind_param("i", $usuario_id);
        
            // Ejecutaremos la consulta:
            $consulta->execute();
        
            // Obtendremos el resultado de la consulta:
            $resultado = $consulta->get_result();
        
            if ($resultado->num_rows > 0) {

                // Si encontramos algún registro relacionado, guardamos la fila relacionada a la contraseña:
                $fila = $resultado->fetch_object();
                
                // Devolveremos el resultado de la consulta:
                return $fila->password;
            }
        }
    }
?>