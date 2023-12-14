<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Usuario.php';

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

        public function registrarCliente($nombre, $apellidos, $direccion, $email, $telefono, $password) {
            $conexion = self::conectarBaseDeDatos();
    
            // Verificamos si el correo electrónico ya está registrado
            $consulta_email = "SELECT * FROM CLIENTE WHERE email = ?";
            $stmt = $conexion->prepare($consulta_email);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado_email = $stmt->get_result();
    
            if ($resultado_email->num_rows == 0) {
                // Insertamos al nuevo cliente en la tabla CLIENTE
                $consulta_insertar_cliente = "INSERT INTO CLIENTE (nombre, apellidos, direccion, email, telefono) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($consulta_insertar_cliente);
                $stmt->bind_param("sssss", $nombre, $apellidos, $direccion, $email, $telefono);
                $stmt->execute();
    
                // Obtenemos el ID del nuevo cliente
                $id_cliente = $conexion->insert_id;
    
                // Insertamos las credenciales en la tabla CREDENCIAL
                $consulta_insertar_credencial = "INSERT INTO CREDENCIAL (id_cliente, tipo_usuario, password) VALUES (?, 'cliente', ?)";
                $stmt = $conexion->prepare($consulta_insertar_credencial);
                $stmt->bind_param("is", $id_cliente, $password);
                $stmt->execute();
    
                // Devolvemos el ID del nuevo cliente
                return $id_cliente;
    
            } else {
                // El correo electrónico ya está registrado
                return null;
            }
        }

        // Crearemos una función que nos devuelva la información de un usuario por su ID:
        public static function getUsuarioByID($usuario_id) {

            // Nos conectaremos en nuestra base de datos a través de la llamada al método encargado de ello:
            $conexion = self::conectarBaseDeDatos();
        
            // Crearemos una consulta a la base de datos para extraer todos los datos del cliente de la sesión:
            $usuario = "SELECT * FROM CLIENTE WHERE id_cliente = ?";

            // Preparamos la consulta:
            $consulta = $conexion->prepare($usuario);

            // Vincularemos el parámetro de la anterior consulta al valor del ID indicado:
            $consulta->bind_param("i", $usuario_id);

            // Ejecutaremos la consulta:
            $consulta->execute();
        
            // Obtendremos el resultado de la ejecución de la consulta y la guardaremos en una variable:
            $result = $consulta->get_result();
            
            // Asignamos el resultado a la variable datos:
            $datos = $result->fetch_assoc();
        
            // Cerramos la consulta preparada y la conexión a la base de datos:
            $consulta->close();
            $conexion->close();
        
            // Finalmente, devolvemos la información del usuario:
            return $datos;
        }
    }
?>