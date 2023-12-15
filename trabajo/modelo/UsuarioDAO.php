<?php

    include_once 'config/dataBase.php';

    class UsuarioDAO {

        // Crearemos una función para conectarnos a nuestra base de datos:
        public static function conectarBaseDeDatos() {
            $db = new DataBase();
            return $db->connect();
        }

        // Crearemos una función para extraer todos los correos de nuestra página web:
        public function getUsuarioPorEmail($email, $conexion) {

            // Crearemos una variable para comprobar si el email introducido por el usuario es un cliente:
            $busqueda_credencial_cliente = "SELECT cliente.id_cliente AS ID, cliente.email, credencial.tipo_usuario, credencial.password
                                            FROM CLIENTE cliente
                                            JOIN CREDENCIAL credencial ON cliente.id_cliente = credencial.id_cliente
                                            WHERE credencial.tipo_usuario = 'cliente' AND cliente.email = '$email'";
            
            // Crearemos una variable para comprobar si el email introducido por el usuario es un empleado:
            $busqueda_credencial_administrador = "SELECT administrador.id_administrador AS ID, administrador.email, credencial.tipo_usuario, credencial.password
                                            FROM ADMINISTRADOR ADMINISTRADOR
                                            JOIN CREDENCIAL credencial ON administrador.id_administrador = credencial.id_administrador
                                            WHERE credencial.tipo_usuario = 'administrador' AND administrador.email = '$email'";
            
            // Guardaremos en una variable la ejecución de las anteriores consultas a la base de datos tras conectarnos a la base de datos mediante el método encargado de ello:
            $consulta_cliente = self::conectarBaseDeDatos()->query($busqueda_credencial_cliente);
            $consulta_administrador = self::conectarBaseDeDatos()->query($busqueda_credencial_administrador);

            if ($consulta_cliente->num_rows > 0 || $consulta_administrador->num_rows > 0) {

                // Si de ambas búsquedas, encontramos algún registro que coincida, guardamos dicho objeto en una variable:
                $credencial = ($consulta_cliente->num_rows > 0) ? $consulta_cliente->fetch_object() : $consulta_administrador->fetch_object();
                return $credencial;
            
            } else {

                return null;
            }
        }
    }
?>