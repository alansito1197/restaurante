<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Administrador.php';

    class AdministradorDAO {

        // Crearemos una función para conectarnos a nuestra base de datos:
        public static function conectarBaseDeDatos() {
            $db = new DataBase();
            return $db->connect();
        }

        public static function obtenerPasswordAdmin($usuario_id) {
            
            // Crearemos una consulta a la base de datos para buscar la contraseña del usuario:
            $password_bbdd = "SELECT credencial.password FROM credencial WHERE credencial.id_administrador = '$usuario_id'";

            // Ejecutaremos la consulta mediante la llamada al método que se conecta a la base de datos:
            $ejecutar_busqueda = self::conectarBaseDeDatos()->query($password_bbdd);

            if ($ejecutar_busqueda->num_rows > 0) {

                // Si encontramos algún registro relacionado, guardamos la fila relacionada a la contraseña:
                $fila = $ejecutar_busqueda->fetch_assoc();
                return $fila['password'];

            } else {

                // Si no encontramos ningún registro, devolveremos nulo:
                return null;
            }
        }
    }   
?>